<?php

use PHPUnit\Framework\TestCase;
use Samu\TodoList\Entity\Task;
use Samu\TodoList\Helper\EntityManagerCreator;
use Samu\TodoList\Repository\TaskRepository;

class TaskRepositoryTest
extends TestCase
{
    /** @test */
    public function repositoryIsOfTasks()
    {
        $em = EntityManagerCreator::create();
        $repository = $em->getRepository(Task::class);
        $this->assertInstanceOf(TaskRepository::class, $repository);
    }

    public function testGetTasksStartingBy()
    {
        $em = EntityManagerCreator::create();
        $repository = $em->getRepository(Task::class);

        $today = new DateTime('Today');
        $results = $repository->getTasksStartingBy($today, 0, 10);

        $this->assertLessThan(10, count($results));
        
        $this->assertContainsOnly(Task::class, $results);

        foreach ($results as $task) {
            $schedule = $task->getSchedule();
            $this->assertGreaterThanOrEqual($today, $schedule);
        }
    }
}
        
        
