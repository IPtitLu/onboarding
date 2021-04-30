<?php

namespace App\Domain\Concession\Manager;

use App\Common\Manager\AbstractManager;
use App\Common\Repository\AbstractRepository;
use App\Domain\Concession\Form\Command\SearchConcessionCommand;
use App\Domain\User\Entity\User;
use App\Domain\Concession\Entity\Concession;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ConcessionManager extends AbstractManager
{
    /**
     * @var PaginatorInterface
     */
    protected $paginator;
    protected $concession;
    /**
     * ConcessionManager constructor.
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
     * @param SearchConcessionCommand $searchConcessionCommand
     * @return PaginationInterface
     */
    public function getPaginated(?int $page = null, SearchConcessionCommand $searchConcessionCommand)
    {
        return $this->paginator->paginate(
            $this->repository->search($searchConcessionCommand),
            $page ?? 1,
            5
        );
    }

    /**
     * @param SearchConcessionCommand $searchConcessionCommand
     * @return mixed
     */
    public function search(SearchConcessionCommand $searchConcessionCommand)
    {
        return $this->repository->search($searchConcessionCommand, true);
    }
}