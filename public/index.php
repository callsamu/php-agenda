<?php

require_once __DIR__.'/../vendor/autoload.php';
use Samu\TodoList\Controllers\FrontController;

$uri = $_SERVER['PATH_INFO'];
(new FrontController)->processRequest($uri);



    

    



