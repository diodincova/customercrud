<?php

use App\Application\Service\CustomerService;
use App\Domain\Model\CustomerRepositoryInterface;
use App\Infrastructure\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

return [
    EntityManagerInterface::class => [
        'class' => EntityManager::class,
        'method' => 'create',
        'constructorArgs' => [
            ['url' => 'mysql://crud:secret@db/crud'],
            Setup::createAnnotationMetadataConfiguration([dirname(__DIR__)."/src/Domain/Model"], true, null, null, false)
        ],
    ],
    CustomerRepositoryInterface::class => [
        'class' => CustomerRepository::class,
        'constructorArgs' => ['@' . EntityManagerInterface::class],
    ],
    CustomerService::class => [
        'class' => CustomerService::class,
        'constructorArgs' => ['@' . CustomerRepositoryInterface::class],
    ],
];