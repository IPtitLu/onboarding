<?php

namespace App\Domain\User\Form\Command;

class SearchUserCommand
{

    /** @var string|null */
    private $firstName;

    /** @var string|null */
    private $lastName;

    /** @var string|null */
    private $email;

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return SearchUserCommand
     */
    public function setFirstName(?string $firstName): SearchUserCommand
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return SearchUserCommand
     */
    public function setLastName(?string $lastName): SearchUserCommand
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return SearchUserCommand
     */
    public function setEmail(?string $email): SearchUserCommand
    {
        $this->email = $email;

        return $this;
    }




}