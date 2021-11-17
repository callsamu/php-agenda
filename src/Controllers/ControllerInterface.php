<?php

namespace Samu\TodoList\Controllers;

interface ControllerInterface
{
    public function processRequest(string $uri) : void;
}
