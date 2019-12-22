<?php

namespace App\Infrastructure\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

use App\Domain\Model\Customer;

class CustomerFixtureLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $customer = new Customer();

        $customer->setName('name');
        $customer->setEmail('email');
        $customer->setIsActive(true);

        $manager->persist($customer);
        $manager->flush();
    }
}