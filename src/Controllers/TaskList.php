<?php

namespace Samu\TodoList\Controllers;

use Samu\TodoList\Helper\EntityManagerCreator;
use Samu\TodoList\Controllers\ControllerInterface;
use Samu\TodoList\Entity\Task;

class TaskList implements ControllerInterface
{
    private $entityManager;

    public function __construct() {
        $this->entityManager = EntityManagerCreator::create();
    }

    public function processRequest($uri) {
        $title = "Tasks";
        $taskList = $this->entityManager
                         ->getRepository(Task::class)
                         ->findAll();
        require_once __DIR__ . '/../../view/tasklist.html';
    }
}
