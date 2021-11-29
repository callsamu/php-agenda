<?php

namespace Samu\TodoList\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Samu\TodoList\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;
    /**
     * @ORM\Column(type="string")
     */
    private string $name;
    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $schedule;
    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $deadline;

    public function __construct(
        string $name,
        DateTime $schedule,
        DateTime $deadline
    ) {
        $this->updateName($name);
        $this->updateDates($schedule, $deadline);
    }

    public function updateName(string $name) 
    {
        $length = strlen($name);

        if ($length === 0 || $length >= 30)
            throw new \LengthException("Invalid name: maximum of 30 characters");
    
        $this->name = $name;
    }

    public function updateDates(DateTime $schedule, DateTime $deadline)
    {
        $message = "Schedule cannot be more recent than Deadline.";

        if ($schedule > $deadline)
            throw new \DomainException($message);
        
        // Reset time
        $this->schedule = $schedule->setTime(0, 0);
        $this->deadline = $deadline->setTime(0, 0);
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() : string { 
        return $this->name;
    }

    public function getSchedule() : DateTime {
        return $this->schedule;
    }

    public function getDeadline() : DateTime {
        return $this->deadline;
    }
}




