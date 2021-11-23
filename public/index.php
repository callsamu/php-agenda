<?php
error_reporting(E_ALL);
require_once __DIR__.'/../vendor/autoload.php';
$configDirectory = __DIR__ . '/../config/';

$routes = require $configDirectory.'routes.php';
$container = require $configDirectory.'container.php';

$uri = $_SERVER['PATH_INFO'];

if (!array_key_exists($uri, $routes)) {
    http_response_code(404);
    exit();
}

$controllerClass = $routes[$uri];
$controller = new $controllerClass($container);

$controller->processRequest($uri);
