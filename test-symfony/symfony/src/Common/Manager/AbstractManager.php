<?php

namespace App\Common\Manager;

use App\Common\Repository\AbstractRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

abstract class AbstractManager
{
    /** @var AbstractRepository */
    protected $repository;

    /**
     * AbstractManager constructor.
     *
     * @param AbstractRepository $repository
     */
    public function __construct(AbstractRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $entity
     *
     * @return object|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($entity)
    {
        $this->repository->save($entity);

        return $entity;
    }

    /**
     * @param $id
     *
     * @return object|null
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     *
     * @return object|null
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->repository->findOneBy($criteria, $orderBy);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param Criteria $criteria
     *
     * @return Collection
     */
    public function matching(Criteria $criteria)
    {
        return $this->repository->matching($criteria);
    }

    /**
     * @param $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete($entity)
    {
        $this->repository->remove($entity);
    }

    /**
     * @param array $keywordsNoResults
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function batchRemove(array $keywordsNoResults)
    {
        $this->repository->batchRemove($keywordsNoResults);
    }
}