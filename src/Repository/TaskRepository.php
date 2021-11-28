<?php

use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function getNextTasks($index, $limit = 20): iterable
    {
        $dql = <<<QUERY
            SELECT t
            FROM Samu\TodoList\Entity\Task t
            WHERE t.schedule > CURRENT_DATE()
            ORDER BY t.schedule
        QUERY;

         $query = $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setFirstResult($index * $limit)
            ->setMaxResults($limit);
            
        return $query->toIterable();
    }
}
