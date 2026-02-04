<?php
    declare(strict_types=1);

    use App\Http\Router;
    use Dotenv\Dotenv;

    $root = dirname(__DIR__);

// Load .env
    $dotenv = Dotenv::createImmutable($root);
    $dotenv->load();

    $dotenv->required([
        'DB_HOST',
        'DB_USER',
        'DB_PASS',
        'DB_NAME',
    ]);

    $router = new Router();

// Register routes
    require $root . '/config/routes.php';

    return [
        'router' => $router,
    ];