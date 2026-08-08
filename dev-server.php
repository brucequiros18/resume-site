<?php
/**
 * Development router for PHP's built-in web server (no Apache needed):
 *   php -S 127.0.0.1:8080 dev-server.php
 *
 * Serves real files from public/ as-is, everything else hits the
 * front controller — same routing model as the Apache setup.
 */

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

if ($uri !== '/') {
    $file = __DIR__ . '/public' . $uri;
    if (is_file($file)) {
        $ext   = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $types = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'svg'  => 'image/svg+xml',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'webp' => 'image/webp',
            'ico'  => 'image/x-icon',
            'pdf'  => 'application/pdf',
        ];
        header('Content-Type: ' . ($types[$ext] ?? 'application/octet-stream'));
        readfile($file);
        return true; // streamed ourselves — works regardless of docroot
    }
}

require __DIR__ . '/public/index.php';
