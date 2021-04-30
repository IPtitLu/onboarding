<?php


namespace App\Domain\User\Repository;

use App\Common\Repository\AbstractRepository;
use App\Domain\User\Form\Command\SearchUserCommand;

class UserRepository extends AbstractRepository
{
    public function search(SearchUserCommand $searchUserCommand, bool $returnResult = false)
    {
        $qb = $this->createQueryBuilder('u');

        if($searchUserCommand->getFirstName())
        {
            $qb->andWhere('u.firstName LIKE :firstName');
            $qb->setParameter('firstName', '%'.$searchUserCommand->getFirstName().'%');
        }

        if($searchUserCommand->getLastName())
        {
            $qb->andWhere('u.lastName LIKE :lastName');
            $qb->setParameter('lastName', '%'.$searchUserCommand->getLastName().'%');
        }
        if($searchUserCommand->getEmail())
        {
            $qb->andWhere('u.email LIKE :email');
            $qb->setParameter('email', '%'.$searchUserCommand->getEmail().'%');
        }

        return $returnResult ? $qb->getQuery()->getResult() : $qb;
    }
}