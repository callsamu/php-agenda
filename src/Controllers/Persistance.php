<?php

namespace Samu\TodoList\Controllers;

use DateTime;
use Samu\TodoList\Entity\Task;
use Samu\TodoList\Helper\EntityManagerCreator;

class Persistance
implements ControllerInterface
{
    private $entityManager;

    public function __construct(Pimple\Container $c) {
        $this->entityManager = EntityManagerCreator::create();
    }

    public function processRequest(string $uri) : void {
        $name = filter_input(
            INPUT_POST, 
            'description', 
            FILTER_DEFAULT
        );

        $id = filter_input(
            INPUT_GET, 
            'id', 
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
        header('Location: /tasks');
    }
}
