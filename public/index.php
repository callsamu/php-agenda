<?php
error_reporting(E_ALL);
require_once __DIR__.'/../vendor/autoload.php';

$configDirectory = __DIR__ . '/../config/';

$routes = require $configDirectory.'routes.php';
$container = require $configDirectory.'dependencies.php';

$uri = $_SERVER['PATH_INFO'];

if (!array_key_exists($uri, $routes)) {
    http_response_code(404);
    exit();
}

$request = $container['request'];

$controllerClass = $routes[$uri];
$controller = new $controllerClass($container);

$response = $controller->handle($request);

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header("$name: $values");
    }
}

echo $response->getBody();
