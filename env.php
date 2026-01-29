<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dotenv->required([
    'DB_HOST',
    'DB_USER',
    'DB_PASS',
    'DB_NAME',
]);