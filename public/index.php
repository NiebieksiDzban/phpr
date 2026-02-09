<?php
    declare(strict_types=1);
    session_start();

    require dirname(__DIR__) . '/vendor/autoload.php';

    $app = require dirname(__DIR__) . '/bootstrap/app.php';

    $router = $app['router'];
    $view = $app['view'];
    $auth = $app['auth'];

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
    $router->dispatch($path, $view, $auth);

