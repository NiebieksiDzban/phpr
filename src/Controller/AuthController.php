<?php
    declare(strict_types=1);

    namespace App\Controller;

    use App\Auth\AuthService;
    use App\View\View;

    final class AuthController
    {
        private View $view;
        private AuthService $auth;

        public function __construct(View $view)
        {
            $pdo = require dirname(__DIR__, 2) . '/config/database.php';

            $this->view = $view;
            $this->auth = new AuthService($pdo);
        }

        public function getLogin(): void
        {
            $this->view->renderPage('login', [
                'title' => 'Login'
            ]);
        }

        public function postLogin(): void
        {
            $email = $_POST['email'] ?: '';
            $password = $_POST['password'] ?: '';
            if (
                filter_var($email, FILTER_VALIDATE_EMAIL)
                && $password !== '') {
                $res = $this->auth->attemptLogin($email, $password);
                if ($res) {
                    header("Location: ./");
                }
                exit();
            }
            header("Location: ./login");
        }

        public function postLogout(): void
        {
            $this->auth->attemptLogout();
        }
    }