<?php
    declare(strict_types=1);

    namespace App\Http;

    use App\View\View;

    /**
     * Klasa Router
     *
     * Zarządza kierowaniem żądań HTTP do przypisanych kontrolerów i metod.
     * Umożliwia definiowanie tras z metodami HTTP, dopasowywaniem ścieżek i grupowaniem tras
     * ze wspólnym prefiksem. Obsługuje wysyłanie żądań i wywoływanie odpowiedniej
     * metody kontrolera na podstawie metody HTTP i ścieżki.
     */
    class Router {
        private array $routes = [];
        private string $basePath = '';

        /**
         * Konwertuje ścieżkę do małych liter i usuwa wiodące oraz końcowe ukośniki.
         * Zapewnia spójny format ścieżek używanych w systemie routingu.
         *
         * @param string $path Ścieżka do normalizacji
         * @return string Znormalizowana ścieżka
         */
        private function normalizePath(string $path): string {
            return strtolower(trim($path, '/'));
        }

        /**
         * Łączy prefiks ze ścieżką w prawidłowy format URL. Obsługuje przypadki,
         * gdy prefiks lub ścieżka są puste, zapewniając poprawne formatowanie
         * wynikowej ścieżki z ukośnikami.
         *
         * @param string $prefix Prefiks ścieżki do połączenia
         * @param string $path Ścieżka do połączenia z prefiksem
         * @return string Połączona ścieżka
         */
        private function joinPaths(string $prefix, string $path): string
        {
            $prefix = trim($prefix, '/');
            $path   = trim($path, '/');

            if ($prefix === '') {
                return '/' . $path;
            }
            if ($path === '') {
                return '/' . $prefix;
            }

            return '/' . $prefix . '/' . $path;
        }

        /**
         * Rejestruje nową trasę w systemie routingu, łącząc podaną ścieżkę z aktualną
         * ścieżką bazową i normalizując wynik. Trasa jest powiązana z kontrolerem,
         * metodą HTTP oraz tytułem strony.
         *
         * @param string $method Metoda HTTP (GET, POST, PUT, DELETE, itp.)
         * @param string $path Ścieżka trasy, która zostanie połączona z aktualną ścieżką bazową
         * @param array $controller Tablica zawierająca klasę kontrolera i nazwę metody [Class::class, 'methodName']
         * @return void
         */
        public function add(string $method, string $path, array $controller): void
        {
            $fullPath = $this->joinPaths($this->basePath, $path);
            $fullPath = $this->normalizePath($fullPath);

            $this->routes[] = [
                'path' => $fullPath,
                'method' => strtoupper($method),
                'controller' => $controller,
                'middlewares' => []
            ];

        }

        /**
         * Tworzy grupę tras ze wspólnym prefiksem ścieżki. Wszystkie trasy zdefiniowane
         * wewnątrz funkcji callback będą miały automatycznie dodany podany prefiks.
         * Po zakończeniu wykonywania callback, poprzednia ścieżka bazowa jest przywracana.
         *
         * @param string $prefix Prefiks dodawany do wszystkich tras w grupie
         * @param callable $callback Funkcja callback definiująca trasy w grupie, otrzymuje instancję routera jako parametr
         * @return void
         */
        public function group(string $prefix, callable $callback): void
        {
            $previous = $this->basePath;
            $this->basePath = $this->joinPaths($this->basePath, $prefix);

            try {
                $callback($this);
            } finally {
                $this->basePath = $previous;
            }
        }

        /**
         * Dopasowuje żądaną ścieżkę i metodę HTTP do zdefiniowanych tras.
         * Jeśli znaleziono trasę, tworzy instancję kontrolera i wywołuje
         * przypisaną metodę. W przypadku braku dopasowania zwraca odpowiedź 404.
         *
         * @param string $path Ścieżka żądania HTTP do przetworzenia
         * @return void
         */
        public function dispatch(string $path, View $view): void
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

                $controllerInstance = new $class($view);


                $controllerInstance->{$function}();

                return;
            }

            http_response_code(404);
            echo '404 Not Found';
        }
    }