<?php
/**
 * View helpers — small, side-effect-free functions used inside views.
 * Kept tiny so logic stays in the views, not buried in helpers.
 */

declare(strict_types=1);

// mbstring is bundled with XAMPP; fall back gracefully on bare PHP builds.
if (!function_exists('mb_strlen')) {
    function mb_strlen(string $s): int { return strlen($s); }
    /** @noinspection PhpUnused */
    function mb_substr(string $s, int $start, ?int $length = null): string
    {
        return $length === null ? substr($s, $start) : substr($s, $start, $length);
    }
}

function content(): array
{
    static $data = null;
    $data ??= require __DIR__ . '/../config/content.php';
    return $data;
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function active_path(Request $req, string $route): string
{
    return $req->path === $route ? ' aria-current="page"' : '';
}

/** One-shot success flash (read + clear). */
function flash_sent(): bool
{
    $sent = !empty($_SESSION['contact_sent']);
    unset($_SESSION['contact_sent']);
    return $sent;
}

/** Per-field validation error, if any. */
function field_error(string $field): string
{
    return isset($_SESSION['contact_errors'][$field])
        ? e($_SESSION['contact_errors'][$field])
        : '';
}

/** Repopulate a form field after a failed submit. */
function old_value(string $field): string
{
    return e($_SESSION['contact_old'][$field] ?? '');
}

function clear_contact_flash(): void
{
    unset($_SESSION['contact_errors'], $_SESSION['contact_old']);
}
