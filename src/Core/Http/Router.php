<?php

namespace MoolrePayments\Core\Http;

use JetBrains\PhpStorm\NoReturn;

class Router
{
    protected array $routes = [];

    protected function build(string $method, string $uri, string $controller): void
    {
        $this->routes[] = [
            'uri' => $uri,
            'method' => $method,
            'controller' => $controller
        ];
    }

    public function get(string $uri, string $controller): void
    {
        $this->build('GET', $uri, $controller);
    }

    public function post(string $uri, string $controller): void
    {
        $this->build('POST', $uri, $controller);
    }

    public function route(string $uri, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $method === strtoupper($method)) {
                $instance = new $route['controller'];
                return call_user_func($instance);
            }
        }

        $this->abort();
    }

    #[NoReturn]
    protected function abort(): void
    {
        http_response_code(404);

        die();
    }
}