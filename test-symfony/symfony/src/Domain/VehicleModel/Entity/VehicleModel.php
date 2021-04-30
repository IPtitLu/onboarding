<?php

namespace App\Domain\VehicleModel\Entity;

use App\Domain\User\Entity\Vehicle;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

class VehicleModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $brand;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @ORM\OneToMany (cascade={"persist"}, "remove" )
     * @var Vehicle|null
     */
    private $vehicles;

    public function __construct() {
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
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     * @return VehicleModel
     */
    public function setBrand(?string $brand): VehicleModel
    {
        $this->brand = $brand;

        return $this;
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
     * @return VehicleModel
     */
    public function setName(?string $name): VehicleModel
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    /**
     * @param Collection $vehicles
     * @return VehicleModel
     */
    public function setVehicles(Collection $vehicles): VehicleModel
    {
        $this->vehicles = $vehicles;

        return $this;
    }

    /**
    public function addVehicle(Vehicle $vehicle)
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
        }
    }
    **/
}