<?php
/**
 * Front controller — every request enters here.
 *
 * Boot sequence (kept linear for easy debugging):
 *  1. start session (flash + CSRF state)
 *  2. load the core libraries
 *  3. build the request, match the route model, dispatch
 *  4. send the response
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']),
    ]);
    session_start();
}

require __DIR__ . '/../app/lib/helpers.php';
require __DIR__ . '/../app/lib/csrf.php';
require __DIR__ . '/../app/lib/db.php';
require __DIR__ . '/../app/lib/router.php';

$routes = require __DIR__ . '/../app/routes.php';

$request  = new Request();
$response = (new Router($routes))->dispatch($request);
$response->send();
