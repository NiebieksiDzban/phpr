<?php
    declare(strict_types=1);

    use App\Controller\AuthController;
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
            $router->add('GET', '/', [AuthController::class, 'getLogin']);
            $router->add('POST', '/', [AuthController::class, 'postLogin']);
        });

        $router->group('/logout', function (Router $router) {
            $router->add('GET', '/', [AuthController::class, 'getLogout']);
            $router->add('POST', '/', [AuthController::class, 'postLogout']);
        });

        $router->group('/register', function (Router $router) {
            $router->add('GET', '/', [AuthController::class, 'getRegister']);
            $router->add('POST', '/', [AuthController::class, 'postRegister']);
        });
    });