<?php
require_once __DIR__.'/../vendor/autoload.php';

use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;

$configDirectory = __DIR__ . '/../config/';

$routes = require $configDirectory.'routes.php';

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(require $configDirectory.'dependencies.php'); 
$container = $builder->build();

$request = $container->get(RequestInterface::class);
$uri = $request->getUri()->getPath();

if (!array_key_exists($uri, $routes)) {
    $response = new Response(404);
} else {
    $controllerClass = $routes[$uri];
    $controller = $container->get($controllerClass);
    $response = $controller->handle($request);
}

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header("$name: $value");
    }
}

echo $response->getBody();
