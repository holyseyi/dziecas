<?php

declare(strict_types=1);

namespace Core;

class Router
{
    private array $routes = [];
    private array $groups = [];
    private string $notFound = '';

    public function add(string $method, string $path, $handler): self
    {
        $path = '/' . ltrim($path, '/');
        $prefix = $this->getPrefix();
        $this->routes[] = [
            'method'  => strtoupper($method),
            'path'    => $prefix . $path,
            'handler' => $handler
        ];
        return $this;
    }

    public function prefix(string $prefix, callable $callback): self
    {
        $this->groups[] = ['prefix' => '/' . trim($prefix, '/'), 'middlewares' => []];
        $callback($this);
        array_pop($this->groups);
        return $this;
    }

    public function get(string $path, $handler): self
    {
        return $this->add('GET', $path, $handler);
    }

    public function post(string $path, $handler): self
    {
        return $this->add('POST', $path, $handler);
    }

    public function put(string $path, $handler): self
    {
        return $this->add('PUT', $path, $handler);
    }

    public function delete(string $path, $handler): self
    {
        return $this->add('DELETE', $path, $handler);
    }

    public function any(string $path, $handler): self
    {
        return $this->add('GET', $path, $handler);
    }

    public function notFound(string $handler): self
    {
        $this->notFound = $handler;
        return $this;
    }

    private function getPrefix(): string
    {
        $prefix = '';
        foreach ($this->groups as $group) {
            $prefix .= $group['prefix'];
        }
        return $prefix;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method && $route['method'] !== 'ANY') {
                continue;
            }

            $path = $route['path'];
            $regex = '#^' . preg_replace('#\{[^}]+\}#', '([^/]+)', $path) . '$#';

            if (preg_match($regex, $uri, $matches)) {
                array_shift($matches);
                $this->callHandler($route['handler'], $matches);
                return;
            }
        }

        if ($this->notFound) {
            http_response_code(404);
            if (is_callable($this->notFound)) {
                call_user_func($this->notFound);
            } else {
                echo json_encode(['error' => 'Not Found', 'message' => 'The requested resource was not found.']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not Found', 'message' => 'The requested resource was not found.']);
        }
    }

    private function callHandler($handler, array $params = []): void
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
        } elseif (is_string($handler) && str_contains($handler, '@')) {
            [$controller, $method] = explode('@', $handler);
            $controllerClass = 'Controllers\\' . $controller;

            if (!class_exists($controllerClass)) {
                throw new \RuntimeException("Controller class not found: " . $controllerClass);
            }

            $instance = new $controllerClass();
            if (!method_exists($instance, $method)) {
                throw new \RuntimeException("Method not found: " . $controllerClass . "::" . $method);
            }

            call_user_func_array([$instance, $method], $params);
        } else {
            throw new \RuntimeException("Invalid route handler");
        }
    }
}
