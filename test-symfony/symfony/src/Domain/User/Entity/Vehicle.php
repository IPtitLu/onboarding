<?php


namespace App\Domain\User\Entity;

use App\Domain\VehicleModel\Entity\VehicleModel;

class Vehicle
{
    /** @var int */
    private $id;

    /**
     * @var User|null
     */
    private $user;

    /**
     * @var VehicleModel|null
     */
    private $vehicleModel;

    /** @var string|null */
    private $color;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return Vehicle
     */
    public function setUser(?User $user): Vehicle
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return VehicleModel|null
     */
    public function getVehicleModel(): ?VehicleModel
    {
        return $this->vehicleModel;
    }

    /**
     * @param VehicleModel|null $vehicleModel
     * @return Vehicle
     */
    public function setVehicleModel(?VehicleModel $vehicleModel): Vehicle
    {
        $this->vehicleModel = $vehicleModel;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @param string|null $color
     * @return Vehicle
     */
    public function setColor(?string $color): Vehicle
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @param User $users
     */
    /**
    public function addUser(User $users): void
    {
        // for a many-to-one association:
        $users->setVehicles($this);

        $this->user->addVehicle($users);
    }
    **/
    /**
     * @param VehicleModel $vehicleModel
     */
    /**
    public function addVehicleModel(VehicleModel $vehicleModel): void
    {
        // for a many-to-many association:

        // for a many-to-one association:
        $vehicleModel->setVehicles($this);

        $this->vehicleModel->addVehicle($vehicleModel);
    }
    **/
}