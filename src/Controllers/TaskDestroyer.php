<?php

namespace Samu\TodoList\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Samu\TodoList\Entity\Task;

class TaskDestroyer
implements RequestHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $header = [];
        $header['Location'] = '/tasks';
        
        $id = filter_var(
            $request->getQueryParams()['id'],
            FILTER_VALIDATE_INT
        );

        if ($id === null || $id === false) {
            return new Response(200, $header);
        }

        $task = $this->entityManager->getReference(Task::class, $id);
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return new Response(200, $header);
    }
}
