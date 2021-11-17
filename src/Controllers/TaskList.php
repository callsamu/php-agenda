<?php

namespace Samu\TodoList\Controllers;

use Samu\TodoList\Helper\EntityManagerCreator;
use Samu\TodoList\Entity\Task;

class TaskList 
extends ViewController
implements ControllerInterface
{
    private $repository;

    public function __construct() {
        $this->repository = 
            EntityManagerCreator::create()
                ->getRepository(Task::class);
    }

    public function processRequest(string $uri) : void {
        $taskList = $this->repository
                         ->findAll();
        
        echo $this->renderView('tasklist', [
            'title' => 'My Tasks',
            'taskList' => $taskList
        ]);
    }
}
