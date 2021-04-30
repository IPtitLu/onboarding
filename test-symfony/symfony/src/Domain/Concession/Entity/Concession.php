<?php

namespace App\Domain\Concession\Entity;

use App\Domain\User\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;

class Concession {

    /** @var int */
    private $id;

    /** @var string|null */
    private $name;

    /** @var string|null */
    private $city;

    /** @var User|null */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Concession
     */
    public function setName(?string $name): Concession
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return Concession
     */
    public function setCity(?string $city): Concession
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUsers()
    {
        return $this->users;
    }
}