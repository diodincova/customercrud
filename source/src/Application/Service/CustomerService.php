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
     */
    public function __construct()
    {
        $this->customerRepository = app(CustomerRepositoryInterface::class);
    }

    /**
     * @param int $customerId
     * @return Customer|null
     */
    public function getCustomer(int $customerId): ?Customer
    {
        return $this->customerRepository->findById($customerId);
    }

    /**
     * @return array|null
     */
    public function getAllCustomers(): ?array
    {
        return $this->customerRepository->findAll();
    }

    /**
     * @param string $name
     * @param bool $isActive
     * @param string $email
     * @return Customer
     */
    public function addCustomer(string $name, bool $isActive, string $email): Customer
    {
        $customer = new Customer();

        $customer->setName($name);
        $customer->setEmail($email);
        $customer->setIsActive($isActive);

        $this->customerRepository->save($customer);

        return $customer;
    }

    /**
     * @param int $customerId
     * @param string $name
     * @param bool $isActive
     * @param string $email
     * @return Customer|null
     */
    public function updateCustomer(int $customerId, string $name, bool $isActive, string $email): ?Customer
    {
        $customer = $this->customerRepository->findById($customerId);

        if (!$customer) {
            return null;
        }

        $customer->setName($name);
        $customer->setEmail($email);
        $customer->setIsActive($isActive);

        $this->customerRepository->save($customer);
        
        return $customer;
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