<?php

use Samu\PHPAgenda\Controllers\{
    Persistance,
    TaskCreator,
    TaskDestroyer,
    TaskEditor,
    TaskList
};

return [
    '/' => TaskList::class,
    '/tasks' => TaskList::class,
    '/new-task' => TaskCreator::class,
    '/delete' => TaskDestroyer::class,
    '/edit' => TaskEditor::class,
    '/save' => Persistance::class
];

 
