<?php

namespace App\Tests\Application\Service;

use App\Application\Service\CustomerService;
use App\Domain\Model\Customer;
use App\Infrastructure\Repository\CustomerRepository;
use PHPUnit\Framework\TestCase;

class CustomerServiceTest extends TestCase
{
    /**
     * @param $name
     * @param $email
     * @param $isActive
     * @param $id
     * @dataProvider getProvider
     */
    public function testGetCustomer($name, $email, $isActive, $id)
    {
        $customer = $this->createCustomer($name, $email, $isActive);
        $customerService = $this->createCustomerService('findById', [$id], $customer);

        $this->assertEquals(["name" => $name, "email" => $email, "active" => $isActive], $customerService->getCustomer($id));
    }

    /**
     * @param $name
     * @param $email
     * @param $isActive
     * @dataProvider addProvider
     */
    public function testAddCustomer($name, $email, $isActive)
    {
        $customer = $this->createCustomer($name, $email, $isActive);
        $customerService = $this->createCustomerService('save', [$customer], null);

        $this->assertEquals(
            ["name" => $name, "email" => $email, "active" => $isActive],
            $customerService->addCustomer($name, $isActive, $email)
        );
    }

    /**
     * @param $id
     * @param $name
     * @param $email
     * @param $isActive
     * @dataProvider updateProvider
     */
    public function testUpdateCustomer($id, $name, $isActive, $email)
    {
        $customer = $this->createCustomer($name, $email, $isActive);

        $repository = $this->getMockBuilder(CustomerRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($customer);

        $repository->expects($this->once())
            ->method('save')
            ->with($customer)
            ->willReturn(null);

        $customerService = new CustomerService($repository);

        $this->assertEquals(
            ["name" => $name, "email" => $email, "active" => $isActive],
            $customerService->updateCustomer($id, $name, $isActive, $email)
        );
    }

    /**
     * @param $id
     * @param $name
     * @param $email
     * @param $isActive
     * @dataProvider deleteProvider
     */
    public function testDeleteCustomer($id, $name, $isActive, $email)
    {
        $customer = $this->createCustomer($name, $email, $isActive);

        $repository = $this->getMockBuilder(CustomerRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($customer);

        $repository->expects($this->once())
            ->method('delete')
            ->with($customer)
            ->willReturn(null);

        $customerService = new CustomerService($repository);

        $this->assertEquals(
            null,
            $customerService->deleteCustomer($id)
        );
    }

    public function getProvider()
    {
        return [
            ['foo', 'foo@bar', true, 1]
        ];
    }

    public function addProvider()
    {
        return [
            ['foo', 'foo@bar', true]
        ];
    }

    public function updateProvider()
    {
        return [
            [1, 'foo', true, 'foo@bar']
        ];
    }

    public function deleteProvider()
    {
        return [
            [1, 'foo', true, 'foo@bar']
        ];
    }

    private function createCustomerService($method, $with, $willReturn)
    {
        return new CustomerService($this->createCustomerRepository($method, $with, $willReturn));
    }

    private function createCustomerRepository($method, $with, $willReturn)
    {
        $repository = $this->getMockBuilder(CustomerRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->once())
            ->method($method)
            ->with(...$with)
            ->willReturn($willReturn);

        return $repository;
    }

    private function createCustomer(string $name, string $email, bool $isActive): Customer
    {
        $customer = new Customer();
        $customer->setName($name);
        $customer->setEmail($email);
        $customer->setIsActive($isActive);

        return $customer;
    }
}