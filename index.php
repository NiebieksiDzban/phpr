<?php
    require("env.php");
    require("Router.php");

    $path = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $uri = $path[count($path) - 1];

    class SiteController
    {
        public function home(): void
        {
            require("views/home.php");
        }

        public function login(): void
        {
            require("views/login.php");
        }

        public function logout(): void
        {
            require("views/logout.php");
        }

    }

    $router = new Router();
    $router->add('GET', '/', [SiteController::class, 'home']);
    $router->add('GET', '/login', [SiteController::class, 'login']);
    $router->add('GET', '/logout', [SiteController::class, 'logout']);

    require("components/head.php");
    $router->dispatch($uri);
    require("components/footer.php");
