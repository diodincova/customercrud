<?php

namespace App\Application\Service;

use App\Domain\Model\Customer;
use App\Domain\Model\CustomerRepositoryInterface;

final class CustomerService
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * CustomerService constructor.
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param int $customerId
     * @return array|null
     */
    public function getCustomer(int $customerId): ?array
    {
        $customer = $this->customerRepository->findById($customerId);

        return $customer ? $customer->extract() : null;
    }

    /**
     * @return array|null
     */
    public function getAllCustomers(): ?array
    {
        return $this->customerRepository->findAll();
    }

    public function addCustomer(string $name, bool $isActive, string $email): array
    {
        $customer = new Customer();

        $customer->setName($name);
        $customer->setEmail($email);
        $customer->setIsActive($isActive);

        $this->customerRepository->save($customer);

        return $customer->extract();
    }

    /**
     * @param int $customerId
     * @param string $name
     * @param bool $isActive
     * @param string $email
     * @return array|null
     */
    public function updateCustomer(int $customerId, string $name, bool $isActive, string $email): ?array
    {
        $customer = $this->customerRepository->findById($customerId);

        if (!$customer) {
            return null;
        }

        $customer->setName($name);
        $customer->setEmail($email);
        $customer->setIsActive($isActive);

        $this->customerRepository->save($customer);
        
        return $customer->extract();
    }

    /**
     * @param int $customerId
     */
    public function deleteCustomer(int $customerId): void
    {
        $customer = $this->customerRepository->findById($customerId);
        
        if ($customer) {
            $this->customerRepository->delete($customer);
        }
    }
}