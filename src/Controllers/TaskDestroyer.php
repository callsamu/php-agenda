<?php

namespace Samu\TodoList\Controllers;

use Samu\TodoList\Entity\Task;
use Samu\TodoList\Helper\EntityManagerCreator;

class TaskDestroyer
implements ControllerInterface
{
    private $entityManager;

    public function __construct() {
       $this->entityManager = EntityManagerCreator::create(); 
    }

    public function processRequest(string $uri): void
    {
        $id = filter_input(
            INPUT_GET,
            'id',
            FILTER_VALIDATE_INT
        );

        if ($id === null || $id === false) {
            header('Location: /tasks');
            return;
        }

        $task = $this->entityManager->getReference(Task::class, $id);
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        header('Location: /tasks');
    }
}
