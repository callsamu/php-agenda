<?php

namespace Samu\TodoList\Controllers;

use DateTime;
use Samu\TodoList\Entity\Task;
use Samu\TodoList\Helper\EntityManagerCreator;

class Persistance
implements ControllerInterface
{
    private $entityManager;

    public function __construct() {
        $this->entityManager = EntityManagerCreator::create();
    }

    public function processRequest(string $uri) : void {
        $name = filter_input(
            INPUT_POST, 
            'description', 
            FILTER_DEFAULT);

        $task = new Task();
        $task->setName($name)
             ->setDate(new DateTime());
        
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        header('Location: /tasks');
    }
}
