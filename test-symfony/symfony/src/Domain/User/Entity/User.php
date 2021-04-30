<?php


namespace App\Domain\User\Entity;

use App\Domain\Concession\Entity\Concession;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /** @var int */
    private $id;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $salt;

    /**
     * @internal not mapped.
     * @var string
     */
    private $plainPassword;

    /** @var array */
    private $roles;

    /** @var Concession|null */
    private $concession;

    /**
     * @var Vehicle|null
     */
    private $vehicles;

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->vehicles = new ArrayCollection();
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
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return User
     */
    public function setFirstName(?string $firstName): User
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
     * @param string $lastName
     * @return User
     */
    public function setLastName(?string $lastName): User
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array|null $roles
     * @return User
     */
    public function setRoles(?array $roles): User
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return User
     */
    public function setEmail(?string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword(string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     * @return User
     */
    public function setSalt(string $salt): User
    {
        $this->salt = $salt;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function supportsClass($class): bool
    {
        return User::class === $class;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Concession|null
     */
    public function getConcession(): ?Concession
    {
        return $this->concession;
    }

    /**
     * @param Concession|null $concession
     * @return User
     */
    public function setConcession(?Concession $concession): User
    {
        $this->concession = $concession;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getVehicles()
    {
        return $this->vehicles;
    }

    /**
     * @param Collection $vehicles
     * @return User
     */
    public function setVehicles(Collection $vehicles): User
    {
        $this->vehicles = $vehicles;

        return $this;
    }

    public function addVehicle(Vehicle $vehicle): User
    {
        if (!$this->vehicles->contains($vehicle)) {
            $vehicle->setUser($this);
            $this->vehicles->add($vehicle);
        }

        return $this;
    }

    /**
     * @param Vehicle $vehicle
     * @return User
     */
    public function removeVehicle(Vehicle $vehicle): User
    {
        $this->vehicles->removeElement($vehicle);

        return $this;
    }
}