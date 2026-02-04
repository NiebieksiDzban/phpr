<?php
    declare(strict_types=1);

    /**
     * The Router class provides a mechanism to handle HTTP routes, manage route groups,
     * and dispatch requests to corresponding controllers and methods.
     */

    namespace App\Http;


    /**
     * Class Router
     *
     * Handles the routing functionality of the application. This includes storing
     * routes, dispatching them based on the requested HTTP method and path,
     * and grouping routes under a common prefix.
     */
    class Router {
        private array $routes = [];
        private function normalizePath(string $path): string {
            $path = trim($path, '/');
            $path = "/{$path}/";
            return preg_replace('#/{2,}#', '/', $path);

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

                echo "s";
                return;
            }

            http_response_code(404);
            echo '404 Not Found';
        }
    }