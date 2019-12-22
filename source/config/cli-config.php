<?php

use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\EntityManagerInterface;

require dirname(__DIR__).'/vendor/autoload.php';
require dirname(__DIR__).'/helpers.php';

$entityManager = app(EntityManagerInterface::class);
return new HelperSet([
    'em' => new EntityManagerHelper($entityManager),
    'db' => new ConnectionHelper($entityManager->getConnection()),
]);

