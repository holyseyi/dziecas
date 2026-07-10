<?php

declare(strict_types=1);

namespace Middleware;

class AuthMiddleware
{
    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function guest(): bool
    {
        return !isset($_SESSION['user_id']);
    }

    public static function handle(): void
    {
        if (!self::check()) {
            \Core\Controller::redirect('/login');
        }
    }
}
