<?php

namespace App\Domain\Model;

/**
 * Interface CustomerRepositoryInterface
 * @package App\Domain\Model\Customer
 */
interface CustomerRepositoryInterface
{
    public function findById(int $customerId): ?Customer;

    public function findAll(): array;

    public function save(Customer $customer): void;

    public function delete(Customer $customer): void;
}