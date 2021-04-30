<?php


namespace App\Domain\Export\Manager;

use App\Common\Manager\AbstractManager;
use App\Common\Repository\AbstractRepository;
use App\Domain\Export\Entity\Export;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use League\Csv\Reader;

class ExportManager extends AbstractManager
{
    protected $paginator;

    /**
     * UserManager constructor.
     *
     * @param AbstractRepository $repository
     * @param PaginatorInterface $paginator
     */
    public function __construct(AbstractRepository $repository, PaginatorInterface $paginator)
    {
        parent::__construct($repository);

        $this->paginator = $paginator;
    }

    /**
     * @param int|null $page
     * @return PaginationInterface
     */
    public function getPaginated(?int $page = null)
    {
        return $this->paginator->paginate(
            $this->repository->getExportOrder(),
            $page ?? 1,
            10
        );
    }
}