<?php
    declare(strict_types=1);

    namespace App\Controller;

    use App\Auth\AuthService;
    use App\View\View;
    use PDO;

    final class AuthController
    {
        private View $view;
        private AuthService $auth;

        public function __construct(View $view, AuthService $auth)
        {
            $this->view = $view;
            $this->auth = $auth;
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
            exit();
        }

        public function getLogout(): void
        {
            $this->auth->attemptLogout();

            header("Location: ./");
            exit();
        }

        public function getRegister(): void
        {
            $this->view->renderPage('register', [
                'title' => 'Register'
            ]);
        }

        public function postRegister(): void
        {
            if (isset(
                $_POST['email'],
                $_POST['password'],
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['phone_number'],
                $_POST['country'],
                $_POST['city'],
                $_POST['address'],
            )) {
                $ok =  $this->auth->attemptRegister(
                    $_POST['email'],
                    $_POST['password'],
                    "customer",
                    $_POST['first_name'],
                    $_POST['last_name'],
                    $_POST['phone_number'],
                    $_POST['country'],
                    $_POST['city'],
                    $_POST['address']
                );
                if (!$ok) {
                    $_SESSION['register_error'] = 'Registration failed (email may already exist).';
                    header('Location: /register');
                    exit;
                }

                header("Location: ./login");
                exit();
            }

            header("Location: ./register");
            exit();
        }
    }