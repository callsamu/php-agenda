<?php

namespace Samu\TodoList\Controllers;

use Exception;

class FrontController implements ControllerInterface
{
    private $table = [
        '/tasks' => TaskListController::class
    ];

    public function processRequest(string $url) {
        // Route exists?
        if (!array_key_exists($url, $this->table)) {
            echo "Page does not exists";
            throw new Exception('Page does not exists.');
        }

        $controllerName = $this->table[$url];
        $controller = new $controllerName;

        $controller->processRequest($url);
    }
}
        

