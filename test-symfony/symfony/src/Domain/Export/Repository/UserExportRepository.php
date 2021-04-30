<?php


namespace App\Domain\Export\Repository;

use App\Common\Repository\AbstractRepository;

class UserExportRepository extends AbstractRepository
{
    public function getExportOrder()
    {
        return $this
            ->createQueryBuilder('e')
            ->addOrderBy('e.createdAt', 'DESC')
            ->getQuery()
            ->execute()
            ;
    }
}