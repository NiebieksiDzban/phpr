<?php
    declare(strict_types=1);

    namespace App\Controller;

    class SiteController
    {
        private function view(string $view, array $params = []): void
        {
            $viewFile = dirname(__DIR__, 2) . '/templates/' . trim($view, '/') . '.php';

            if (!is_file($viewFile)) {
                http_response_code(500);
                echo 'View not found';
                return;
            }

            extract($params, EXTR_SKIP);
            require_once $viewFile;
        }




        public function home(): void
        {
            $pdo = require dirname(__DIR__, 2) . '/config/database.php';

            $stmt = $pdo->query("SELECT id FROM `test`");
            $rows = $stmt->fetchAll();

            $this->view('pages/home', [
                'rows' => $rows
            ]);
        }

        public function login(): void
        {
            $this->view('pages/login');
        }

        public function logout(): void
        {
            $this->view('pages/logout');
        }

        public function register(): void
        {
            $this->view('pages/register');
        }

    }