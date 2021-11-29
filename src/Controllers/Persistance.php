<?php

namespace Samu\TodoList\Controllers;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Samu\TodoList\Entity\Task;

class Persistance
implements RequestHandlerInterface
{
    private array $postParameters;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}
    
    public function error()
    {
        // TODO: Implement flash message

        return '/new-task';
        echo "hahaha";
    }
    
    public function create()
    {
        extract($this->postParameters);

        $task = new Task(
            $description,
            new DateTime($schedule), 
            new DateTime($deadline)
        );

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        echo "hahaha";
        
        return '/tasks';
    }

    public function update (int $id): string
    {
        extract($this->postParameters);

        $task = $this->entityManager->find(Task::class, $id);
        
        $task->updateName($description);
        $task->updateDates(new DateTime($schedule), new DateTime($deadline));

        $this->entityManager->flush();
        
        return '/tasks';
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->postParameters = filter_var_array(
            $request->getParsedBody(),
            FILTER_SANITIZE_STRING
        );
        
        $id = filter_var(
            $request->getQueryParams()['id'],
            FILTER_VALIDATE_INT
        );

        $redirect = match($id) {
            true => $this->update($id),
            false => $this->create(),
            null => $this->error()
        };
        
        return new Response(200, ['Location' => $redirect]);
    }
}
