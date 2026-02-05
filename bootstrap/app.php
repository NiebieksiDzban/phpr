<?php
    declare(strict_types=1);

    use App\Http\Router;
    use App\View\View;
    use Dotenv\Dotenv;

    $root = dirname(__DIR__);

    /**
     * Instancja Dotenv używana do wczytywania zmiennych środowiskowych z pliku `.env` do środowiska aplikacji.
     *
     * Ta zmienna pozwala na bezpieczne i spójne zarządzanie wartościami konfiguracyjnymi poprzez zdefiniowanie ich w jednym pliku.
     * Biblioteka Dotenv odczytuje te ustawienia i udostępnia je jako zmienne środowiskowe, wspierając
     * separację konfiguracji od kodu.
     */
    $dotenv = Dotenv::createImmutable($root);
    $dotenv->load();

    $dotenv->required([
        'ROOT_DIR',

        'DB_HOST',
        'DB_USER',
        'DB_PASS',
        'DB_NAME',
    ]);

    // Inicjalizacja Routera
    $router = new Router();
    $view = new View($root . '/templates');

    require $root . '/config/routes.php';

    return [
        'router' => $router,
        'view' => $view
    ];