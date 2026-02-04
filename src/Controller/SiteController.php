<?php
    declare(strict_types=1);

    namespace App\Controller;
    class SiteController
    {
        public function home(): void
        {
            require __DIR__ . '/../../views/pages/home.php';
        }

        public function login(): void
        {
            require __DIR__ . '/../../views/pages/login.php';
        }

        public function logout(): void
        {
            require __DIR__ . '/../../views/pages/logout.php';
        }

    }