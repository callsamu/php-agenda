<?php

namespace Samu\PHPAgenda\Controllers;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TaskCreator
extends ViewController
implements RequestHandlerInterface
{
    public function 
    handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->loadView('form', ['title' => 'New Task']);
        return new Response(200, [], $this->renderView());
    }
}
