<?php

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Samu\PHPAgenda\Controllers\TaskList;
use Samu\PHPAgenda\Repository\TaskRepository;

class ListControllerTest
extends TestCase
{
    public function testController()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $em = $this->createStub(EntityManagerInterface::class);
        
        $em->method('getRepository')
           ->willReturn($this->createMock(TaskRepository::class));

        $controller = new TaskList($em);
        $response = $controller->handle($request);
        
        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertEmpty($response->getHeaders());
    }
}
    
