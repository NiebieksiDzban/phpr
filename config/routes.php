<?php
    declare(strict_types=1);

    use App\Controller\SiteController;

    /** @var App\Http\Router $router */

    $router->add('GET', '/grzesiu/', [SiteController::class, 'home'], 'Home');
    $router->add('GET', '/grzesiu/login', [SiteController::class, 'login'], 'Login');
    $router->add('GET', '/grzesiu/logout', [SiteController::class, 'logout'], 'Logout');
    $router->add('GET', '/grzesiu/register', [SiteController::class, 'register'], 'Register');