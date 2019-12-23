<?php

namespace App\Infrastructure\Fixture;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

use App\Domain\Model\Customer;

class CustomerFixtureLoader implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->dataProvider() as $item) {
            $customer = new Customer();

            $customer->setName($item[0]);
            $customer->setEmail($item[1]);
            $customer->setIsActive($item[2]);

            $manager->persist($customer);
            $manager->flush();
        }
    }

    private function dataProvider()
    {
        return [
            ['Alduin Dragon', 'alduinfire@example.com', true],
            ['Ulfric Stormcloak', 'stormheart2000@example.com', true],
            ['General Tullius', 'gtullius@example.com', false],
        ];
    }
}