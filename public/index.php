<?php

require_once __DIR__.'/../vendor/autoload.php';
use Samu\TodoList\Controllers\FrontController;

$uri = $_SERVER['REQUEST_URI'];
(new FrontController)->processRequest($uri);



    

    



