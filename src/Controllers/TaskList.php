<?php

namespace Samu\TodoList\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Samu\TodoList\Entity\Task;

class TaskList 
extends ViewController
implements RequestHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    private function buildList($tasks): array
    {
        $list = [];
        $day = 0;
        $currentDay = \DateTime::createFromFormat('d-m-Y', 'now');

        foreach ($tasks as $task) {
            $schedule = $task->getSchedule();

            if ($currentDay < $schedule) {
                $day += 1;
                $currentDay = $schedule;
            }

            $list[$day][] = $task;
        }

        return $list;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $results = $this
            ->entityManager
            ->createQuery('
                SELECT t
                FROM Samu\TodoList\Entity\Task t
                WHERE t.schedule > CURRENT_DATE()
                ORDER BY t.schedule
            ')->toIterable();

        $html = $this->loadView('tasklist', [
            'title' => 'My Tasks',
            'taskList' => $this->buildList($results)
        ])->renderView();

        return new Response(200, [], $html);
    }
}
