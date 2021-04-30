<?php

namespace App\Domain\VehicleModel\Repository;

use App\Common\Repository\AbstractRepository;
use App\Domain\VehicleModel\Form\Command\SearchVehicleModelCommand;

class VehicleModelRepository extends AbstractRepository
{
    public function search(SearchVehicleModelCommand $searchVehicleModelCommand , bool $returnResult = false)
    {
        $qb = $this->createQueryBuilder('v');

        if($searchVehicleModelCommand->getBrand())
        {
            $qb->andWhere('v.brand LIKE :brand');
            $qb->setParameter('brand', '%'. $searchVehicleModelCommand->getBrand().'%');
        }

        if($searchVehicleModelCommand->getName())
        {
            $qb->andWhere('v.brand LIKE :name');
            $qb->setParameter('name', '%'.$searchVehicleModelCommand->getName().'%');
        }

        return $returnResult ? $qb->getQuery()->getResult() : $qb;
    }
}