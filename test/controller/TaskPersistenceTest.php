<?php

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Samu\TodoList\Controllers\Persistance;
use Samu\TodoList\Entity\Task;

class TaskPersistenceTest
extends TestCase
{
    private function mockEntityManager()
    {
        $mock = $this->createMock(EntityManagerInterface::class);
        $mock->expects($this->once())
            ->method('flush');

        return $mock;
    }

    private function mockRequest(?string $id, array $postParameterValues)
    {
        $parameterNames = ['description', 'schedule', 'deadline'];
        $postParameters = array_combine($parameterNames, $postParameterValues);

        $mock = $this->createMock(ServerRequestInterface::class);

        $mock->expects($this->once())
            ->method('getParsedBody')
            ->willReturn($postParameters);
        
        $queryParams = $id === null ? null : ['id' => $id];

        $mock->expects($this->once())
            ->method('getQueryParams')
            ->willReturn($queryParams);
        
        return $mock;
    }

    public function testCreating()
    {
        $entityManager = $this->mockEntityManager();
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Task::class));

        $request = $this->mockRequest(null, ['Test', '03-07-2022', '05-07-2022']);

        $controller = new Persistance($entityManager);
        $response = $controller->handle($request);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/tasks', $response->getHeaderLine('Location'));
    }
    
    public function testUpdating()
    {
        $postParameters = ['Test', '03-07-2022', '04-07-2069'];
        [$name, $schedule, $deadline] = $postParameters;
        $task = new Task($name, new DateTime($schedule), new DateTime($deadline));

        $entityManager = $this->mockEntityManager();
        $entityManager->expects($this->once())
            ->method('find')
            ->willReturn($task);

        $controller = new Persistance($entityManager);
        $response = $controller->handle($this->mockRequest('2', $postParameters));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/tasks', $response->getHeaderLine('Location'));
    }

    public function testInvalidation()
    {
        $postParameters =  ['Test', '03-07-2022', '04-07-2069'];
        $id = '2; DROP TABLE';
 
        $controller = new Persistance($this->mockEntityManager());
        $response = $controller->handle($this->mockRequest($id, $postParameters));
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('/new-task', $response->getHeaderLine('Location'));
    }
}
