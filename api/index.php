<?php
/**
 * Vercel serverless entrypoint (vercel-php community runtime).
 *
 * Vercel rewrites every path to this file (see vercel.json). The runtime
 * forwards the original request URI, but normalize defensively anyway:
 * if the path arrives as /api/index.php, map it back to the route path.
 */

declare(strict_types=1);

$uri   = $_SERVER['REQUEST_URI'] ?? '/';
$path  = parse_url($uri, PHP_URL_PATH) ?: '/';
$fixed = '/api/index.php';

if ($path === $fixed) {
    $path = '/';
} elseif (str_starts_with($path, $fixed . '/')) {
    $path = substr($path, strlen($fixed));
}

$_SERVER['REQUEST_URI'] = $path;

require __DIR__ . '/../public/index.php';
