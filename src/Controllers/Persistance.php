<?php

namespace Samu\TodoList\Controllers;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Samu\TodoList\Entity\Task;

class Persistance
implements RequestHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        extract($request->getParsedBody());

        $name = filter_var($description, FILTER_SANITIZE_STRING);
            
        $task = new Task(
            $name,
            new DateTime($schedule),
            new DateTime($deadline)
        );
        
        $id = filter_var(
            $request->getQueryParams()['id'],
            FILTER_VALIDATE_INT
        );

        if ($id === null || $id === false) {
            $this->entityManager->persist($task);
        } else {
            var_dump($task);
            $task->setId($id);
            $this->entityManager->merge($task);
        }
        
        $this->entityManager->flush();

        return new Response(200, ['Location' => '/tasks']);
    }
}
