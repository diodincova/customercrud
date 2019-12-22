<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Customer;
use App\Domain\Model\CustomerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class CustomerRepository
 * @package App\Infrastructure\Repository
 */
final class CustomerRepository implements CustomerRepositoryInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ObjectRepository */
    private $objectRepository;

    /** CustomerRepository constructor. */
    public function __construct()
    {
        $this->entityManager = app(EntityManagerInterface::class);
        $this->objectRepository = $this->entityManager->getRepository(Customer::class);
    }

    /**
     * @param int $customerId
     * @return Customer|null
     */
    public function findById(int $customerId): ?Customer
    {
        return $this->objectRepository->find($customerId);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }

    /**
     * @param Customer $customer
     */
    public function save(Customer $customer): void
    {
        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

    /**
     * @param Customer $customer
     */
    public function delete(Customer $customer): void
    {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }
}