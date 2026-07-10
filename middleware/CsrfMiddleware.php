<?php

declare(strict_types=1);

namespace Middleware;

class CsrfMiddleware
{
    public static function check(?string $token = null): bool
    {
        $token = $token ?? ($_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');

        if (empty($token) || empty($_SESSION['_csrf_token']) || !hash_equals($_SESSION['_csrf_token'], $token)) {
            return false;
        }

        if ((time() - ($_SESSION['_csrf_time'] ?? 0)) > CSRF_TOKEN_LIFETIME) {
            return false;
        }

        return true;
    }

    public static function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!self::check()) {
                http_response_code(419);
                if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
                    echo json_encode(['error' => 'CSRF token mismatch', 'message' => 'The CSRF token is invalid or expired.']);
                } else {
                    echo '<h1>419 CSRF Token Mismatch</h1><p>The CSRF token is invalid or expired. Please try again.</p>';
                }
                exit;
            }
        }
    }
}
