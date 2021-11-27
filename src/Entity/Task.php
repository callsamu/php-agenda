<?php

namespace Samu\TodoList\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
        $this->name = $name;

        if (($schedule <=> $deadline) > 0)
            throw new \DomainException(
                "Schedule cannot be more recent than Deadline."
            );
            
        $this->schedule = $schedule;
        $this->deadline = $deadline;
    }

    public function setId(int $new) {
        if ($new < 0) 
            throw new \DomainException("Id can't be negative integer.");
        if ($this->id ?? false) 
            throw new \DomainException("Id is already set.");

        $this->id = $new;
        return $this;
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




