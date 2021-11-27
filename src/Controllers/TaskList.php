<?php

namespace Samu\TodoList\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Samu\TodoList\Entity\Task;

class TaskList 
extends ViewController
implements RequestHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )  {}

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $taskList = $this
            ->entityManager
            ->getRepository(Task::class)
            ->findAll();

        $html = $this->loadView('tasklist', [
            'title' => 'My Tasks',
            'taskList' => $taskList
        ])->renderView();

        return new Response(200, [], $html);
    }
}
