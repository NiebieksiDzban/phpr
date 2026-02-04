<?php
    declare(strict_types=1);

    namespace App\Http;

    class Router {
        private array $routes = [];
        private function normalizePath(string $path): string {
            return trim($path, '/');
        }

        public function add(string $method, string $path, array $controller, string $title): void
        {
            $path = $this->normalizePath($path);

            $this->routes[] = [
                'path' => $path,
                'method' => strtoupper($method),
                'controller' => $controller,
                'middlewares' => [],
                'title' => $title
            ];

        }
        public function group(string $prefix, callable $callback): void
        {
            array_map($callback, $this->routes);

            // TODO: Funkcja do grupowania sciezek
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

//                createHead($route['title']);
                $controllerInstance->{$function}();
//                createFooter();

                return;
            }

            http_response_code(404);
            echo '404 Not Found';
        }
    }