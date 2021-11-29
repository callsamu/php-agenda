<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Samu\TodoList\Helper\EntityManagerCreator;

$entityManager = EntityManagerCreator::create();
return ConsoleRunner::createHelperSet($entityManager);
