<?php

namespace Samu\PHPAgenda\Controllers;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Samu\PHPAgenda\Entity\Task;

class Persistance
implements RequestHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}
    
    public function error()
    {
        // TODO: Implement flash message

        return '/new-task';
    }
    
    public function create(array $parameters)
    {
        [
         'description' => $n, 
         'schedule' => $s, 
         'deadline' => $d
        ] = $parameters;

        $task = new Task($n, new DateTime($s), new DateTime($d));

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return '/tasks';
    }

    public function update (int $id, array $parameters): string
    {
        [
         'description' => $n, 
         'schedule' => $s, 
         'deadline' => $d
        ] = $parameters;

        $task = $this->entityManager->find(Task::class, $id);
        
        $task->updateName($n);
        $task->updateDates(new DateTime($s), new DateTime($d));

        $this->entityManager->flush();
        
        return '/tasks';
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $postParameters = filter_var_array(
            $request->getParsedBody(),
            FILTER_SANITIZE_STRING
        );
        
        if (array_search(false, $postParameters)) {
            // TODO: Implement flash message.
            return new Response(200, ['Location' => '/new-task']);
        }
        
        $queryParams = $request->getQueryParams();
        $id = $queryParams['id'] ?? null;

        if ($id !== null) {
            $id = filter_var($id, FILTER_VALIDATE_INT);
        }

        $redirect = match($id) {
            false => $this->error(),
            null => $this->create($postParameters),
            default => $this->update($id, $postParameters)
        };
        
        return new Response(200, ['Location' => $redirect]);
    }
}
