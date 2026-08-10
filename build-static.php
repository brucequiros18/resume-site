<?php
/**
 * Static build — pre-renders the whole site into dist/ for GitHub Pages.
 *
 *   php build-static.php
 *
 * Renders every GET route through the same router + views used at runtime,
 * then copies assets. The contact page renders a mailto form (STATIC_BUILD)
 * because Pages has no PHP backend.
 */

declare(strict_types=1);

define('STATIC_BUILD', true);

require __DIR__ . '/app/lib/helpers.php';
require __DIR__ . '/app/lib/csrf.php';
require __DIR__ . '/app/lib/router.php';

$routes = require __DIR__ . '/app/routes.php';
$data   = content();

$dist = __DIR__ . '/dist';
if (is_dir($dist)) {
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dist, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($it as $file) {
        $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
    }
}
if (!is_dir($dist)) { mkdir($dist, 0777, true); }

$render = function (string $path) use ($routes): \Response {
    $_SERVER['REQUEST_URI'] = $path;
    $_SERVER['REQUEST_METHOD'] = 'GET';
    return (new Router($routes))->dispatch(new Request());
};

$pages = [
    '/'        => 'index.html',
    '/about'   => 'about/index.html',
    '/work'    => 'work/index.html',
    '/uses'    => 'uses/index.html',
    '/contact' => 'contact/index.html',
];

foreach ($pages as $path => $rel) {
    $resp = $render($path);
    $target = $dist . '/' . $rel;
    if (!is_dir(dirname($target))) {
        mkdir(dirname($target), 0777, true);
    }
    file_put_contents($target, (string) $resp->body);
    echo sprintf("page %-12s -> %s (%d bytes, %d)\n", $path, $rel, strlen((string) $resp->body), $resp->status);
}

foreach ($data['projects'] as $project) {
    $path = '/work/' . $project['slug'];
    $rel  = 'work/' . $project['slug'] . '/index.html';
    $resp = $render($path);
    $target = $dist . '/' . $rel;
    if (!is_dir(dirname($target))) {
        mkdir(dirname($target), 0777, true);
    }
    file_put_contents($target, (string) $resp->body);
    echo sprintf("page %-12s -> %s (%d bytes, %d)\n", $path, $rel, strlen((string) $resp->body), $resp->status);
}

// 404 page — GitHub Pages serves dist/404.html automatically.
$resp = $render('/definitely-not-a-route');
file_put_contents($dist . '/404.html', (string) $resp->body);
echo sprintf("404           -> 404.html (%d bytes, %d)\n", strlen((string) $resp->body), $resp->status);

// Assets + images — plain copy.
foreach (['assets', 'images'] as $dir) {
    $src = __DIR__ . '/public/' . $dir;
    if (!is_dir($src)) {
        continue;
    }
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($src, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($it as $file) {
        if ($file->isDir()) {
            continue;
        }
        $rel  = substr($file->getPathname(), strlen(__DIR__ . '/public/'));
        $dest = $dist . '/' . $rel;
        if (!is_dir(dirname($dest))) {
            mkdir(dirname($dest), 0777, true);
        }
        copy($file->getPathname(), $dest);
    }
    echo "copied public/$dir -> dist/$dir\n";
}

// No Jekyll processing on Pages.
file_put_contents($dist . '/.nojekyll', '');

echo "Static build complete: $dist\n";
