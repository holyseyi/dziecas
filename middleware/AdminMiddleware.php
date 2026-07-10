<?php

declare(strict_types=1);

namespace Middleware;

class AdminMiddleware
{
    public static function check(): bool
    {
        return isset($_SESSION['user_id']) && ($_SESSION['user']['role'] ?? '') === 'admin';
    }

    public static function handle(): void
    {
        if (!self::check()) {
            http_response_code(403);
            die('<h1>403 Forbidden</h1><p>You do not have permission to access this page.</p>');
        }
    }
}
