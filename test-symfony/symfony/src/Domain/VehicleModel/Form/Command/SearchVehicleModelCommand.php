<?php

namespace App\Domain\VehicleModel\Form\Command;


class SearchVehicleModelCommand
{
    /** @var string|null */
    private $brand;

    /** @var string|null */
    private $name;

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     * @return SearchVehicleModelCommand
     */
    public function setBrand(?string $brand): SearchVehicleModelCommand
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
     * @return SearchVehicleModelCommand
     */
    public function setName(?string $name): SearchVehicleModelCommand
    {
        $this->name = $name;

        return $this;
    }


}