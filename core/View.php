<?php

declare(strict_types=1);

namespace Core;

class View
{
    public static function render(string $view, array $data = [], ?string $layout = 'layouts/main'): void
    {
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
                $data['content'] = $content;
                extract($data);
                require $layoutPath;
                return;
            }
        }

        echo $content;
    }

    public static function partial(string $view, array $data = []): string
    {
        extract($data);
        $viewPath = __DIR__ . '/../app/views/partials/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            return '';
        }

        ob_start();
        require $viewPath;
        return ob_get_clean();
    }
}
