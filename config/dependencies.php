<?php

use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestInterface;
use Samu\TodoList\Helper\EntityManagerCreator;

$requestMaker = function() {
    $psr17 = new Psr17Factory();
    $creator = new ServerRequestCreator(
        $psr17, $psr17, $psr17, $psr17
    );
    return $creator->fromGlobals();
};

return [
    EntityManagerInterface::class => 
        fn () => EntityManagerCreator::create(),
    RequestInterface::class => $requestMaker
];

