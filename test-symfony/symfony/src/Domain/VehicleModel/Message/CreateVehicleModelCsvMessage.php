<?php


namespace App\Domain\VehicleModel\Message;


use App\Domain\VehicleModel\Form\Command\SearchVehicleModelCommand;

class CreateVehicleModelCsvMessage
{
    /** @var SearchVehicleModelCommand */
    private $searchVehicleModelCommand;

    public function __construct(SearchVehicleModelCommand $searchVehicleModelCommand)
    {
        $this->searchVehicleModelCommand = $searchVehicleModelCommand;
    }

    /**
     * @return SearchVehicleModelCommand
     */
    public function getSearchVehicleModelCommand(): SearchVehicleModelCommand
    {
        return $this->searchVehicleModelCommand;
    }


}