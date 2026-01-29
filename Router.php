<?php
declare(strict_types=1);
class Router { private array $routes = [];
    public function add(string $method, string $path, array $controller): void
    {
        $path = $this->normalizePath($path);

        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller,
            'middlewares' => []
        ];

    }
    private function normalizePath(string $path): string {
        $path = trim($path, '/');
        $path = "/{$path}/";
        return preg_replace('#/{2,}#', '/', $path);

    }
    public function dispatch(string $path): void
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path) ||
                $route['method'] !== $method
            ) {
                continue;
            }

            [$class, $function] = $route['controller'];

            $controllerInstance = new $class;

            $controllerInstance->{$function}();
        }

    } }