<?php

namespace Samu\TodoList\Helper;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;

class EntityManagerCreator 
{
    public static function create() : EntityManagerInterface {
        $root = __DIR__ . '/../..';

        $connection = [
            'driver' => 'pdo_sqlite',
            'path' => $root . '/var/data/database.sqlite'
        ];

        $config = Setup::createAnnotationMetadataConfiguration(
            [$root . '/src'],
            true,
            null,
            null,
            false
        );

        return EntityManager::create($connection, $config);
    }
}

