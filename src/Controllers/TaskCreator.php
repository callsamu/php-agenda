<?php

namespace Samu\TodoList\Controllers;

class TaskCreator
extends ViewController
implements ControllerInterface
{
    public function processRequest(string $uri) : void {
        echo $this->renderView('form', [
            'title' => 'New Task' 
        ]);
    }
}
