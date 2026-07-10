<?php

declare(strict_types=1);

namespace Core;

class Controller
{
    protected array $data = [];

    protected string $pageTitle = '';

    public function configPageTitle(string $title): void
    {
        $this->pageTitle = $title;
        $this->data['title'] = $title;
    }

    public function view(string $view, array $data = [], ?string $layout = 'layouts/main'): void
    {
        $this->data = $data;
        extract($data);

        $viewPath = __DIR__ . '/../app/views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View not found: {$viewPath}");
        }

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if ($layout) {
            $layoutPath = __DIR__ . '/../app/views/' . str_replace('.', '/', $layout) . '.php';
            if (file_exists($layoutPath)) {
                $this->data['content'] = $content;
                extract($this->data);
                require $layoutPath;
                return;
            }
        }

        echo $content;
    }

    public function partial(string $view, array $data = []): void
    {
        $viewPath = __DIR__ . '/../app/views/' . str_replace('.', '/', $view) . '.php';
        if (!file_exists($viewPath)) {
            return;
        }
        extract($data);
        ob_start();
        require $viewPath;
        echo ob_get_clean();
    }

    public function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        exit;
    }

    public function redirect(string $url, int $statusCode = 302): void
    {
        http_response_code($statusCode);
        header("Location: {$url}");
        exit;
    }

    public function back(): void
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        $this->redirect($referer);
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    public function old(string $key, mixed $default = ''): mixed
    {
        return $_SESSION['_old'][$key] ?? $default;
    }

    public function withError(string $key, string $message): void
    {
        $_SESSION['_errors'][$key] = $message;
    }

    public function errors(): array
    {
        return $_SESSION['_errors'] ?? [];
    }

    public function withSuccess(string $message): void
    {
        $_SESSION['_success'] = $message;
    }

    public function success(): ?string
    {
        return $_SESSION['_success'] ?? null;
    }

    public function csrfToken(): string
    {
        if (empty($_SESSION['_csrf_token']) || (time() - $_SESSION['_csrf_time']) > CSRF_TOKEN_LIFETIME) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['_csrf_time'] = time();
        }
        return $_SESSION['_csrf_token'];
    }

    public function validateCsrf(?string $token = null): bool
    {
        $token = $token ?? $_POST['csrf_token'] ?? '';
        if (empty($token) || empty($_SESSION['_csrf_token']) || !hash_equals($_SESSION['_csrf_token'], $token)) {
            return false;
        }
        return true;
    }

    public function isAuthenticated(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public function auth()
    {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
        return $this->user();
    }

    public function isAdmin(): bool
    {
        if (!$this->isAuthenticated()) {
            return false;
        }
        $role = $_SESSION['user']['role'] ?? null;
        $roleId = $_SESSION['user']['role_id'] ?? null;
        return $role === 'admin' || $roleId == 1;
    }

    public function admin()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/admin/login');
        }
        return $this->user();
    }
}
