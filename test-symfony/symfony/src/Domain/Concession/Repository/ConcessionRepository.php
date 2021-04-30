<?php

namespace App\Domain\Concession\Repository;

use ApiPlatform\Core\Hal\Serializer\ObjectNormalizer;
use App\Common\Repository\AbstractRepository;
use App\Domain\Concession\Form\Command\SearchConcessionCommand;
use App\Domain\Concession\Entity\Concession;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class ConcessionRepository extends AbstractRepository
{
    public function search(SearchConcessionCommand $searchConcessionCommand, bool $returnResult = false)
    {
        $qb = $this->createQueryBuilder('c');

        if($searchConcessionCommand->getName())
        {
            $qb->andWhere('c.name LIKE :name');
            $qb->setParameter('name', '%'.$searchConcessionCommand->getName().'%');
        }

        if($searchConcessionCommand->getCity())
        {
            $qb->andWhere('c.city LIKE :city');
            $qb->setParameter('city', '%'.$searchConcessionCommand->getCity().'%');
        }

        return $returnResult ? $qb->getQuery()->getResult() : $qb;
    }
}
