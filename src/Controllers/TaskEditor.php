<?php

namespace Samu\PHPAgenda\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Samu\PHPAgenda\Entity\Task;

class TaskEditor
extends ViewController
implements RequestHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = filter_var(
            $request->getQueryParams()['id'],
            FILTER_VALIDATE_INT
        );
            
        if ($id === null || $id === false) {
            return new Response(200, ['Location' => '/tasks']);
        }

        $task = $this->entityManager->find(Task::class, $id);
        
        $this->loadView('form', [
            'title' => 'Edit Task',
            'task' => $task
        ]);
        
        return new Response(200, [], $this->renderView());
    }
}
