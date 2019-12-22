<?php

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 * @package App\Domain\Model\Customer
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $name;
    /**
     * @ORM\Column(type="boolean")
     */
    protected $isActive;
    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /** @return mixed */
    public function getId()
    {
        return $this->id;
    }

    /** @return mixed */
    public function getName()
    {
        return $this->name;
    }

    /** @param mixed $name */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** @return mixed */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /** @param mixed $isActive */
    public function setIsActive(int $isActive): void
    {
        $this->isActive = $isActive;
    }

    /** @return mixed */
    public function getEmail()
    {
        return $this->email;
    }

    /** @param mixed $email */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function extract(): array
    {
        return [
            'name' => $this->getName(),
            'email' => $this->getEmail(),
            'active' => $this->getIsActive()
        ];
    }
}