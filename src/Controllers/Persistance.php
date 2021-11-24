<?php

namespace Samu\TodoList\Controllers;

use DateTime;
use Nyholm\Psr7\Response;
use Pimple\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Samu\TodoList\Entity\Task;

class Persistance
implements RequestHandlerInterface
{
    private $entityManager;

    public function __construct(Container $c) 
    {
        $this->entityManager = $c['entity-manager'];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $name = filter_var(
            $request->getParsedBody()['description'],
            FILTER_SANITIZE_STRING
        );
            
        $id = filter_var(
            $request->getQueryParams()['id'],
            FILTER_VALIDATE_INT
        );

        $task = new Task();
        $task->setName($name)
             ->setDate(new DateTime('now'));
        
        if ($id !== null && $id !== false) {
            $task->setId($id);
            $this->entityManager->merge($task);
        } else {
            $this->entityManager->persist($task);
        }
        
        $this->entityManager->flush();

        return new Response(200, ['Location' => '/tasks']);
    }
}
