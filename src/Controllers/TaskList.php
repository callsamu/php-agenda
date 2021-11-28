<?php

namespace Samu\TodoList\Controllers;

use DateTime;
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
    private DateTime $today;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
        $this->today = new DateTime('today'); 
    }

    private function buildList($tasks): array
    {
        $list = [];
        $day = 0;
        $currentDay = $this->today;

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
        $repo = $this->entityManager->getRepository(Task::class);
        $list = $this->buildList($repo->getTasksStartingBy($this->today));

        $html = $this->loadView('tasklist', [
            'title' => 'My Tasks',
            'taskList' => $list
        ])->renderView();

        return new Response(200, [], $html);
    }
}
