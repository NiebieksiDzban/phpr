<?php
    declare(strict_types=1);

    use App\Controller\SiteController;
    use App\Http\Router;

    /**
     * Definicja tras
     *
     * @var App\Http\Router $router
     */
    $router->group($_ENV['ROOT_DIR'], function (Router $router) {
        $router->add('GET', '/', [SiteController::class, 'home']);

        $router->group('/login', function (Router $router) {
            $router->add('GET', '/', [SiteController::class, 'login']);
            $router->add('POST', '/', [AuthController::class, 'login']);
        });

    });