<?php


namespace App\Domain\User\Manager;

use App\Common\Manager\AbstractManager;
use App\Common\Repository\AbstractRepository;
use App\Domain\Concession\Controller\Web\ConcessionController;
use App\Domain\Concession\Entity\Concession;
use App\Domain\Concession\Manager\ConcessionManager;
use App\Domain\User\Entity\User;
use App\Domain\User\Entity\Vehicle;
use App\Domain\User\Form\Command\SearchUserCommand;
use App\Domain\VehicleModel\Entity\VehicleModel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;

class UserManager extends AbstractManager
{
    /** @var PaginatorInterface */
    private $paginator;

    /** @var UserPasswordEncoderInterface */
    private $encoder;
    private $serializer;

    /** @var EntityManager  */
    private $entityManager;

    /**
     * UserManager constructor.
     *
     * @param AbstractRepository $repository
     * @param PaginatorInterface $paginator
     * @param UserPasswordEncoderInterface $encoder
     * @param Serializer $serializer
     */
    public function __construct(AbstractRepository $repository, PaginatorInterface $paginator, UserPasswordEncoderInterface $encoder, Serializer $serializer, EntityManager $entityManager)
    {
        parent::__construct($repository);

        $this->serializer= $serializer;
        $this->paginator = $paginator;
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $entity
     *
     * @return object|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($entity)
    {
        parent::save($entity);
    }

    /**
     * @param int|null $page
     * @param SearchUserCommand $searchUserCommand
     * @return PaginationInterface
     */
    public function getPaginated(?int $page = null, SearchUserCommand $searchUserCommand)
    {
        return $this->paginator->paginate(
            $this->repository->search($searchUserCommand),
            $page ?? 1,
            5
        );
    }

    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function registerUser(User $user)
    {
        $user->setSalt(uniqid(mt_rand(), true));

        $encoded = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($encoded);
        $this->save($user);
    }

    /**
     * @param SearchUserCommand $searchUserCommand
     * @return mixed
     */
    public function search(SearchUserCommand $searchUserCommand)
    {
        return $this->repository->search($searchUserCommand, true);
    }

    /**
     * @param int|null $page
     * @param User $user
     * @return PaginationInterface
     */
    public function getVehiclePaginated(?int $page = null)
    {
        return $this->paginator->paginate(
            $this->repository->findAll(),
            $page ?? 1,
            5
        );
    }

    /**
     * @param User $user
     * @throws ORMException
     */
    public function test(User $user)
    {
        $vehicle = new Vehicle();

        $vehicle = $user->getVehicles();

        $vehicle->setUser($user);

        $this->entityManager->persist($vehicle);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}