<?php
    declare(strict_types=1);

    namespace App\View;

    final class View
    {
        private string $basePath;

        public function __construct(string $basePath)
        {
            $this->basePath = rtrim($basePath, '/\\');
        }

        public function render(string $template, array $params = []): void
        {
            $file = $this->basePath . '/' . trim($template, '/') . '.php';

            if (!is_file($file)) {
                http_response_code(500);
                echo 'Template not found';
                return;
            }

            extract($params, EXTR_SKIP);
            require $file;
        }

        public function renderPage(string $page, array $params = []): void
        {
            $this->render('layout/head', $params);
            $this->render('pages/' . trim($page, '/'), $params);
            $this->render('layout/footer', $params);
        }
    }