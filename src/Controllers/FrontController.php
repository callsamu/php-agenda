<?php

namespace Samu\TodoList\Controllers;

use Exception;

class FrontController 
implements ControllerInterface
{
    private $table = [
        '/tasks' => TaskList::class,
        '/new-task' => TaskCreator::class,
        '/delete' => TaskDestroyer::class,
        '/save' => Persistance::class
    ];

    public function processRequest(string $uri) : void {
        if (!array_key_exists($uri, $this->table)) {
            http_response_code(404);
            exit();
        }

        $controllerName = $this->table[$uri];
        $controller = new $controllerName;

        $controller->processRequest($uri);
    }
}
        

