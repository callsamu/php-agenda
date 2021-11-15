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
    private DateTime $creationDate;

    public function getName() : string { 
        return $this->name;
    }

    public function setName(string $new) { 
        $this->name = $new;
        return $this;
    }

    public function getDate() : DateTime {
        return $this->creationDate;
    }

    public function setDate(DateTime $new)  {
        $this->creationDate = $new;
        return $this;
    }
}




