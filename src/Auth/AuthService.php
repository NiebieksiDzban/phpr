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

        public function attemptRegister(
            string  $identifier,
            string  $password,
            string  $role_name,

            string  $first_name,
            string  $last_name,

            ?string $phone_number = '',
            ?string $country = '',
            ?string $city = '',
            ?string $address = '',

            ?string $warehouse_id = null
        ): bool
        {
            $identifier = trim($identifier);

            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare(
                "INSERT INTO users(email, password, role_id) values (:identifier, :password, (SELECT id FROM roles WHERE name = :role_name))"
            );

            try {
                $stmt->execute(['identifier' => $identifier, 'password' => $password, 'role_name' => $role_name]);
            } catch (\PDOException $e) {
                $this->pdo->rollBack();
                return false;
            }
            $user_id = $this->pdo->lastInsertId();

            try {
                switch ($role_name) {
                    case 'customer':
                        $stmt = $this->pdo->prepare(
                            "INSERT INTO customers(first_name, last_name, phone, country, city, address, user_id) VALUES (:first_name, :last_name, :phone, :country, :city, :address, :user_id)"
                        );

                        $stmt->execute([
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'phone' => $phone_number,
                            'country' => $country,
                            'city' => $city,
                            'address' => $address,
                            'user_id' => $user_id
                        ]);
                        break;
                    default:
                        $stmt = $this->pdo->prepare(
                            "INSERT INTO employees(first_name, last_name, warehouse_id, user_id) VALUES (:first_name, :last_name, :warehouse_id, :user_id)"
                        );

                        $stmt->execute([
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'warehouse_id' => $warehouse_id,
                            'user_id' => $user_id
                        ]);
                        break;
                }

                return $this->pdo->commit();
            } catch (\PDOException $e) {
                $this->pdo->rollBack();
                return false;
            }
        }

        private function ensureSession(): void
        {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }
    }