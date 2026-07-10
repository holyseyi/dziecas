<?php

declare(strict_types=1);

// Global helper functions

use Core\App;

if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        return rtrim(App::getInstance()->getConfig('APP_URL', 'http://localhost'), '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('path')) {
    function path(string $path = ''): string
    {
        return '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string
    {
        return url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('route')) {
    function route(string $name, array $params = []): string
    {
        $routes = $_ENV['ROUTES'] ?? [];
        $path = $routes[$name] ?? $name;
        foreach ($params as $key => $value) {
            $path = str_replace('{' . $key . '}', $value, $path);
        }
        return url($path);
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        $token = $_SESSION['_csrf_token'] ?? '';
        return '<input type="hidden" name="csrf_token" value="' . e($token) . '">';
    }
}

if (!function_exists('method_field')) {
    function method_field(string $method): string
    {
        return '<input type="hidden" name="_method" value="' . e(strtoupper($method)) . '">';
    }
}

if (!function_exists('old')) {
    function old(string $key, mixed $default = ''): mixed
    {
        return $_SESSION['_old'][$key] ?? $default;
    }
}

if (!function_exists('error')) {
    function error(string $key): ?string
    {
        return $_SESSION['_errors'][$key] ?? null;
    }
}

if (!function_exists('has_error')) {
    function has_error(string $key): bool
    {
        return !empty($_SESSION['_errors'][$key]);
    }
}

if (!function_exists('errors')) {
    function errors(): array
    {
        return $_SESSION['_errors'] ?? [];
    }
}

if (!function_exists('success')) {
    function success(): ?string
    {
        return $_SESSION['_success'] ?? null;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('formatDate')) {
    function formatDate(string $date, string $format = 'M d, Y'): string
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber(int $number): string
    {
        return number_format($number);
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string
    {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        return strtolower($text);
    }
}

if (!function_exists('truncate')) {
    function truncate(string $text, int $length = 150, string $suffix = '...'): string
    {
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        return mb_substr($text, 0, $length) . $suffix;
    }
}

if (!function_exists('generateRandomString')) {
    function generateRandomString(int $length = 16): string
    {
        return bin2hex(random_bytes($length / 2));
    }
}

if (!function_exists('getIpAddress')) {
    function getIpAddress(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}

if (!function_exists('dd')) {
    function dd(mixed ...$vars): void
    {
        echo '<pre>';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
        die;
    }
}

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('cache_get')) {
    function cache_get(string $key): mixed
    {
        $file = CACHE_PATH . md5($key) . '.cache';
        if (!file_exists($file)) {
            return null;
        }
        if ((time() - filemtime($file)) > CACHE_TTL) {
            @unlink($file);
            return null;
        }
        return unserialize(file_get_contents($file));
    }
}

if (!function_exists('cache_set')) {
    function cache_set(string $key, mixed $value, int $ttl = CACHE_TTL): void
    {
        $file = CACHE_PATH . md5($key) . '.cache';
        file_put_contents($file, serialize($value));
    }
}

if (!function_exists('get_client_ip')) {
    function get_client_ip(): string
    {
        return getIpAddress();
    }
}

if (!function_exists('standalonePartial')) {
    function standalonePartial(string $view, array $data = []): string {
        extract($data);
        $viewPath = __DIR__ . '/../app/views/partials/' . $view . '.php';
        if (!file_exists($viewPath)) return '';
        ob_start();
        require $viewPath;
        return ob_get_clean();
    }
}
