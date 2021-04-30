<?php

namespace App\Common\Repository;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

abstract class AbstractRepository extends EntityRepository
{
    /**
     * @param $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * @param $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove($entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    /**
     * @param array|Collection $entities
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function batchRemove($entities)
    {
        foreach ($entities as $entity) {
            $this->_em->remove($entity);
        }

        $this->_em->flush();
    }

    /**
     * @param array|Collection $entities
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function batchSave(array $entities)
    {
        foreach ($entities as $entity) {
            $this->_em->persist($entity);
        }

        $this->_em->flush();
    }
}