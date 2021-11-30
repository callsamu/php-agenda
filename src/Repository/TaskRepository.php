<?php

namespace Samu\PHPAgenda\Repository;

use Doctrine\ORM\EntityRepository;
use \DateTime;

class TaskRepository 
extends EntityRepository
{
    public function getTasksStartingBy(
        DateTime $date,
        int $index = 0, 
        int $limit = 20
    ): array
    {
        $dql = <<<QUERY
            SELECT t
            FROM Samu\TodoList\Entity\Task t
            WHERE t.schedule >= ?1 
            ORDER BY t.schedule
        QUERY;

        $query = $this
           ->getEntityManager()
           ->createQuery($dql)
           ->setParameter(1, $date)
           ->setFirstResult($index * $limit)
           ->setMaxResults($limit);
            
        return $query->getResult();
    }
}
