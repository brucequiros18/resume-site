<?php
/**
 * Database configuration — XAMPP defaults.
 * Override via environment variables in production:
 *   DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS
 */

return [
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => getenv('DB_PORT') ?: '3306',
    'name' => getenv('DB_NAME') ?: 'resume',
    'user' => getenv('DB_USER') ?: 'root',
    'pass' => getenv('DB_PASS') ?: '',
];
