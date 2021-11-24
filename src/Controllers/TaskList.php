<?php

namespace Samu\TodoList\Controllers;

use Nyholm\Psr7\Response;
use Pimple\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Samu\TodoList\Entity\Task;

class TaskList 
extends ViewController
implements RequestHandlerInterface
{
    private $entityManager;

    public function __construct(Container $container) {
        $this->entityManager = $container['entity-manager'];
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $taskList = $this->entityManager
                        ->getRepository(Task::class)
                        ->findAll();
                        
        $html = $this->loadView('tasklist', [
            'title' => 'My Tasks',
            'taskList' => $taskList
        ])->renderView();

        return new Response(200, [], $html);
    }
}
