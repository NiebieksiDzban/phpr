<?php
    require dirname(__DIR__) . '/vendor/autoload.php';

    $app = require dirname(__DIR__) . '/bootstrap/app.php';

    $router = $app['router'];

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
    $router->dispatch($path);

