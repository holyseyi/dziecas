<?php

declare(strict_types=1);

namespace Core;

class App
{
    private static ?App $instance = null;
    private array $config = [];

    private function __construct()
    {
        date_default_timezone_set(\APP_TIMEZONE);
    }

    public static function getInstance(): App
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function run(): void
    {
        $this->config = require __DIR__ . '/../config/config.php';

        foreach ($this->config as $key => $value) {
            if (!defined($key)) {
                define($key, $value);
            }
        }

        if (\MAINTENANCE_MODE && !$this->isAdminRoute()) {
            $this->renderMaintenance();
            return;
        }

        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');

        $isApi = str_starts_with(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/', '/api');

        if ($isApi) {
            require_once __DIR__ . '/../routes/api.php';
            if (isset($GLOBALS['_api_router'])) {
                $GLOBALS['_api_router']->dispatch();
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'API not configured']);
            }
        } else {
            require_once __DIR__ . '/../routes/web.php';
            if (isset($GLOBALS['_router'])) {
                $GLOBALS['_router']->dispatch();
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Routes not configured']);
            }
        }
    }

    private function isAdminRoute(): bool
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
        return str_starts_with($uri, '/admin');
    }

    private function renderMaintenance(): void
    {
        http_response_code(503);
        echo '<!DOCTYPE html><html><head><title>Maintenance</title><meta name="robots" content="noindex"></head>';
        echo '<body style="font-family: sans-serif; text-align: center; padding: 50px;">';
        echo '<h1>Under Maintenance</h1><p>We will be back shortly.</p>';
        echo '</body></html>';
    }

    public function getConfig(string $key, mixed $default = null): mixed
    {
        return $this->config[$key] ?? $default;
    }
}
