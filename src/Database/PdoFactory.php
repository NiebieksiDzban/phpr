<?php
    declare(strict_types=1);

    namespace App\Database;

    use PDO;
    use RuntimeException;

    final class PdoFactory
    {
        public static function makeFromEnv(): PDO
        {
            $host = $_ENV['DB_HOST'] ?? null;
            $db   = $_ENV['DB_NAME'] ?? null;
            $user = $_ENV['DB_USER'] ?? null;
            $pass = $_ENV['DB_PASS'] ?? null;

            if (!$host || !$db || !$user) {
                throw new RuntimeException('Database environment variables are missing.');
            }

            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $host, $db);

            return new PDO(
                $dsn,
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );
        }
    }