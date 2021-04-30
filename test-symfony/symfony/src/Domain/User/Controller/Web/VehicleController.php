<?php


namespace App\Domain\User\Controller\Web;


use App\Domain\User\Entity\User;
use App\Domain\User\Form\Type\CreateVehicleType;
use App\Domain\User\Manager\UserManager;
use App\Domain\User\Entity\Vehicle;
use App\Domain\User\Manager\VehicleManager;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VehicleController extends AbstractController
{


    /**
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function index(User $user, Request $request)
    {
        $page = $request->query->get('page');

        // Instantiation of manager
        $userManager = $this->get(UserManager::class);
        $users = $userManager->getVehiclePaginated($page);

        return $this->render('web/back/user/vehicle.html.twig', [
            'users' => $users,
            'user' => $user
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(User $user, Request $request): Response
    {
        $vehicle = new Vehicle();

        $form = $this->createForm(CreateVehicleType::class, $vehicle);
        $form->handleRequest($request);

        // user validation, send and redirecting
        if ($form->isSubmitted() && $form->isValid()) {
            // Instantiation of manager

            $vehicleManager = $this->get(VehicleManager::class);

            $vehicle->setUser($user);

            $vehicleManager->save($vehicle);

            return $this->redirectToRoute('vehicle_back_index', ['id'=> $user->getId()]);
        }


        return $this->render('web/back/user/vehicleCreate.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @param User $user
     * @param Vehicle $vehicle
     * @return RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     * @ParamConverter("user", options={"id" = "user_id"})
     */
    public function delete(User $user, Vehicle $vehicle): RedirectResponse
    {
        $userId = $user->getId();
        $userManager = $this->get(VehicleManager::class);
        $userManager->delete($vehicle);

        return $this->redirectToRoute('vehicle_back_index', ['id'=> $userId]);
    }
}