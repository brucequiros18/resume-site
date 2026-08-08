<?php
/**
 * Minimal router + request abstraction.
 *
 * Responsibility:
 *  - parse the request path,
 *  - match against the route model,
 *  - dispatch to a view (GET) or handler (POST),
 *  - emit the right HTTP status on miss.
 *
 * No libraries. No magic. Easy to debug because every code path
 * is named in routes.php first.
 */

declare(strict_types=1);

final class Request
{
    public readonly string $method;
    public readonly string $path;
    public readonly array  $query;
    public readonly array  $body;

    public function __construct()
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $raw          = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $this->path   = rtrim($raw ?: '/', '/') ?: '/';
        $this->query  = $_GET;
        $this->body   = $_POST;
    }
}

final class Response
{
    /** @param array<string,string> $headers */
    public function __construct(
        public int $status = 200,
        public ?string $body = null,
        public array $headers = [],
        public bool $isHead = false,
    ) {}

    public function send(): void
    {
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
        http_response_code($this->status);
        if ($this->body !== null && !$this->isHead) {
            echo $this->body;
        }
    }
}

final class Router
{
    public function __construct(private array $routes) {}

    public function dispatch(Request $req): Response
    {
        // HEAD mirrors GET so link-checkers and curl -I work.
        $method = $req->method === 'HEAD' ? 'GET' : $req->method;
        $table  = $this->routes[$method] ?? [];
        $params = [];

        if (isset($table[$req->path])) {
            $action = $table[$req->path];
        } else {
            // Dynamic routes — match a static key pattern against the path.
            $action = $this->matchDynamic($table, $req->path, $params);
        }

        if ($action === null) {
            return $this->resolve($req);
        }

        if (isset($action['view'])) {
            $rendered = $this->renderView($action['view'], $action['title'], $req, $params);
            if ($rendered === null) {
                return new Response(500, 'Internal server error.', isHead: $req->method === 'HEAD');
            }
            [$body, $status] = $rendered;
            return new Response($status, $body, isHead: $req->method === 'HEAD');
        }

        if (isset($action['handler'])) {
            require_once __DIR__ . '/handlers.php';
            [$class, $method] = explode('.', $action['handler'], 2) + [1 => 'handle'];
            $fqcn = 'Handlers\\' . ucfirst($class) . 'Handler';
            if (!class_exists($fqcn) || !method_exists($fqcn, $method)) {
                return new Response(500, 'Handler missing: ' . $action['handler'], isHead: $req->method === 'HEAD');
            }
            return (new $fqcn())->$method($req, $action);
        }

        return $this->notFound($req);
    }

    /**
     * Route exists under another verb → 405 + Allow; otherwise 404.
     */
    private function resolve(Request $req): Response
    {
        $allow = [];
        foreach ($this->routes as $verb => $table) {
            if ($verb === 'HEAD') {
                continue;
            }
            if (isset($table[$req->path])) {
                $allow[] = $verb;
            }
        }
        $allow = array_values(array_unique($allow));

        if ($allow !== []) {
            return new Response(
                405,
                'Method not allowed. Try: ' . implode(', ', $allow),
                ['Allow' => implode(', ', $allow)],
                $req->method === 'HEAD'
            );
        }
        return $this->notFound($req);
    }

    private function notFound(Request $req): Response
    {
        $name = content()['name'];
        $rendered = $this->renderView('404', 'Not found — ' . $name, $req);
        $body = $rendered[0] ?? 'Not found.';
        return new Response(404, $body, isHead: $req->method === 'HEAD');
    }

    /**
     * Captures the view's markup, then wraps it in the layout shell.
     * Null when the view file is missing (caller turns that into a 500).
     * Returns [html, status] — a view may set $viewStatus to emit e.g. 404.
     *
     * @param array<string,string> $params route params from a dynamic match
     * @return array{0:string,1:int}|null
     */
    private function renderView(string $view, string $title, Request $req, array $params = []): ?array
    {
        $file = __DIR__ . '/../views/' . $view . '.php';
        if (!is_file($file)) {
            return null;
        }

        $data = content();
        $viewStatus = 200;

        ob_start();
        require $file;
        $viewContent = (string) ob_get_clean();

        $pageTitle = $title;

        ob_start();
        require __DIR__ . '/../views/partials/layout.php';
        return [(string) ob_get_clean(), $viewStatus];
    }

    /**
     * Exact keys win; otherwise try each route key that contains {placeholders},
     * converting {name} into a named capture group. Returns the action and
     * fills $params with the captured values, or null when nothing matches.
     *
     * @param array<string,array>  $table
     * @param array<string,string> $params
     * @return array|null
     */
    private function matchDynamic(array $table, string $path, array &$params): ?array
    {
        foreach ($table as $key => $action) {
            if (!str_contains($key, '{')) {
                continue;
            }
            $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[^/]+)', $key);
            $pattern = '#^' . $pattern . '$#';
            if (preg_match($pattern, $path, $captures)) {
                foreach ($captures as $name => $value) {
                    if (is_string($name)) {
                        $params[$name] = $value;
                    }
                }
                return $action;
            }
        }
        return null;
    }
}