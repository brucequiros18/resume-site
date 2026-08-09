<?php
/**
 * Database configuration — XAMPP defaults (MySQL).
 * Override via environment variables in production:
 *   DB_DRIVER (mysql|pgsql), DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS
 * Or set a single DATABASE_URL connection string (Vercel/Neon format,
 * e.g. postgres://user:pass@host:5432/dbname) — it wins over the parts.
 */

$config = [
    'driver' => getenv('DB_DRIVER') ?: 'mysql',
    'host'   => getenv('DB_HOST')   ?: '127.0.0.1',
    'port'   => getenv('DB_PORT')   ?: '3306',
    'name'   => getenv('DB_NAME')   ?: 'resume',
    'user'   => getenv('DB_USER')   ?: 'root',
    'pass'   => getenv('DB_PASS')   ?: '',
];

$url = getenv('DATABASE_URL');
if ($url !== false && $url !== '') {
    $parts = parse_url($url);
    $config['driver'] = str_starts_with((string) ($parts['scheme'] ?? ''), 'postgres') ? 'pgsql' : 'mysql';
    $config['host']   = $parts['host']   ?? 'localhost';
    $config['port']   = (string) ($parts['port'] ?? ($config['driver'] === 'pgsql' ? 5432 : 3306));
    $config['name']   = ltrim((string) ($parts['path'] ?? '/'), '/');
    $config['user']   = urldecode((string) ($parts['user'] ?? ''));
    $config['pass']   = urldecode((string) ($parts['pass'] ?? ''));
}

return $config;
