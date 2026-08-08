<?php
/**
 * Route handlers for non-view routes.
 * Systematic: each public method handles one route action.
 */

declare(strict_types=1);

namespace Handlers;

final class ContactHandler
{
    /** Minimum seconds between submissions per session — crude spam brake. */
    private const MIN_INTERVAL = 5;

    public function handle($req, array $action): \Response
    {
        // 1. Honeypot: bots fill hidden "website" fields. Silently pretend success.
        if (trim((string) ($req->body['website'] ?? '')) !== '') {
            return $this->redirectToContact();
        }

        // 2. Rate limit per session.
        if (!$this->rateLimited()) {
            $this->flashError('_form', 'Slow down — one message at a time, please.');
            return $this->redirectToContact();
        }

        // 3. Verify the CSRF token before trusting the payload.
        if (!csrf_verify($req->body['_csrf'] ?? null)) {
            $this->flashError('_csrf', 'Your session expired — please try again.');
            return $this->redirectToContact();
        }

        // 4. Sanitize input.
        $name    = trim((string) ($req->body['name']    ?? ''));
        $email   = trim((string) ($req->body['email']   ?? ''));
        $message = trim((string) ($req->body['message'] ?? ''));

        // 5. Validate (server is the source of truth).
        $errors = $this->validate($name, $email, $message);
        if ($errors) {
            foreach ($errors as $field => $msg) {
                $this->flashError($field, $msg);
            }
            $this->flashOld(compact('name', 'email', 'message'));
            return $this->redirectToContact();
        }

        // 6. Persist with a prepared statement — never string-interpolated SQL.
        try {
            $db = \Database::connection();
            $stmt = $db->prepare(
                'INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)'
            );
            $stmt->execute([
                ':name'    => mb_substr($name, 0, 70),
                ':email'   => mb_substr($email, 0, 190),
                ':message' => $message,
            ]);
        } catch (\PDOException $e) {
            error_log('[resume] contact insert failed: ' . $e->getMessage());
            $this->flashError('_form', 'Message could not be saved. Please try again later.');
            $this->flashOld(compact('name', 'email', 'message'));
            return $this->redirectToContact();
        }

        // 7. Success → redirect (PRG pattern: no double-submit on refresh).
        $_SESSION['contact_sent'] = true;
        return $this->redirectToContact();
    }

    private function validate(string $name, string $email, string $message): array
    {
        $errors = [];
        if ($name === '' || mb_strlen($name) > 70) {
            $errors['name'] = 'Tell me your name (up to 70 characters).';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Enter a valid email so I can reply.';
        }
        if (mb_strlen($message) < 12 || mb_strlen($message) > 4000) {
            $errors['message'] = 'Your message must be 12–4000 characters.';
        }
        return $errors;
    }

    private function rateLimited(): bool
    {
        $now    = time();
        $last   = (int) ($_SESSION['contact_last_ts'] ?? 0);
        $ok     = ($now - $last) >= self::MIN_INTERVAL;
        if ($ok) {
            $_SESSION['contact_last_ts'] = $now;
        }
        return $ok;
    }

    private function flashError(string $field, string $message): void
    {
        $_SESSION['contact_errors'][$field] = $message;
    }

    private function flashOld(array $data): void
    {
        $_SESSION['contact_old'] = $data;
    }

    private function redirectToContact(): \Response
    {
        return new \Response(303, headers: ['Location' => '/contact']);
    }
}

final class ResumeHandler
{
    public function handle($req, array $action): \Response
    {
        $file = __DIR__ . '/../../public/assets/resume.pdf';

        if (!is_file($file)) {
            return new \Response(404, 'Resume not found yet.', isHead: $req->method === 'HEAD');
        }

        $content = \content();
        $slug    = strtolower(str_replace(' ', '-', $content['name']));

        return new \Response(
            200,
            file_get_contents($file),
            headers: [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $slug . '-resume.pdf"',
            ],
            isHead: $req->method === 'HEAD'
        );
    }
}