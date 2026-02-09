<?php
    declare(strict_types=1);

    namespace App\Auth;

    use PDO;
    final class AuthService
    {
        private const SESSION_USER_ID_KEY = "user_id";
        private const SESSION_USER_ROLE_KEY = "user_role";

        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        public function attemptLogin(string $identifier, string $password): bool
        {
            $identifier = trim($identifier);

            if ($identifier === '' || $password === '') {
                return false;
            }

            $stmt = $this->pdo->prepare(
                'SELECT users.id, users.password, roles.name as `role_name` FROM users JOIN roles ON users.role_id = roles.id WHERE email = :identifier LIMIT 1'
            );

            $stmt->execute(['identifier' => $identifier]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (
                $user === false
                || !isset($user['password'])
                || $password !== $user['password']
            ) {
                $_SESSION['login_error'] = 'Wrong email or password.';
                return false;
            }

            $this->ensureSession();
            session_regenerate_id(true);

            $_SESSION[self::SESSION_USER_ID_KEY] = $user['id'];
            $_SESSION[self::SESSION_USER_ROLE_KEY] = $user['role_name'];

            return true;
        }

        public function attemptLogout(): void
        {
            $this->ensureSession();
            unset($_SESSION[self::SESSION_USER_ID_KEY]);
            unset($_SESSION[self::SESSION_USER_ROLE_KEY]);

            session_regenerate_id(true);
        }

//        public function attemptRegister(
//            string $identifier,
//            string $password,
//            string
//        ): bool
//        {
//            $identifier = trim($identifier);
//        }

        private function ensureSession(): void
        {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }
    }