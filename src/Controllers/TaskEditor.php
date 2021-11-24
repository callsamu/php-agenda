<?php

namespace Samu\TodoList\Controllers;

use Nyholm\Psr7\Response;
use Pimple\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Samu\TodoList\Entity\Task;
use Samu\TodoList\Helper\EntityManagerCreator;

class TaskEditor
extends ViewController
implements RequestHandlerInterface
{
    private $entityManager;

    public function __construct(Container $c) 
    {
        $this->entityManager = $c['entity-manager'];
    }
    
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
