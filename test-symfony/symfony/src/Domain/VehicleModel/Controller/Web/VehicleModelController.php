<?php

namespace App\Domain\VehicleModel\Controller\Web;

use App\Domain\User\Form\Command\SearchUserCommand;
use App\Domain\User\Form\Type\SearchUserType;
use App\Domain\User\Manager\UserManager;
use App\Domain\User\Message\CreateUserCsvMessage;
use App\Domain\VehicleModel\Form\Command\SearchVehicleModelCommand;
use App\Domain\VehicleModel\Form\Type\SearchVehicleModelType;
use App\Domain\VehicleModel\Form\Type\VehicleModelType;
use App\Domain\VehicleModel\Entity\VehicleModel;
use App\Domain\VehicleModel\Manager\VehicleModelManager;
use App\Domain\VehicleModel\Message\CreateVehicleModelCsvMessage;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class VehicleModelController extends AbstractController
{
    public function index(Request $request)
    {
        $form = $this->createForm(SearchVehicleModelType::class, $searchVehicleModelCommand = new SearchVehicleModelCommand());
        $form->handleRequest($request);

        // number of page
        $page = $request->query->get('page');

        // Instantiation of Manager
        $vehicleModelManager = $this->get(VehicleModelManager::class);

        // use paginator function and add
        $vehicleModels = $vehicleModelManager->getPaginated($page, $searchVehicleModelCommand);

        return $this->Render('web/back/vehicle_model/index.html.twig', [
            'vehicle_models' => $vehicleModels,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param VehicleModel $vehicleModel
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function show(VehicleModel $vehicleModel)
    {
        $modelVehicleManager = $this->get(VehicleModelManager::class);

        $modelVehicleVideo = $modelVehicleManager->getVehicleModelVideo($vehicleModel);

        return $this->render('web/back/vehicle_model/detail.html.twig', [
            'vehicle_model' => $vehicleModel,
            'vehicle_video' => $modelVehicleVideo
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Request $request): Response
    {
        $this->isGranted('add');
        // instantiation concession
        $vehicleModel = new VehicleModel();

        // form creation
        $form = $this->createForm(VehicleModelType::class, $vehicleModel);
        $form->handleRequest($request);

        // user validation, send and redirecting
        if ($form->isSubmitted() && $form->isValid()) {
            //Instantiation concessionManager
            $vehicleModelManager = $this->get(VehicleModelManager::class);
            // send concession to concession manager function
            $vehicleModelManager->save($vehicleModel);

            return $this->redirectToRoute('vehicle_model_back_index');
        }

        //send render
        return $this->render('web/back/vehicle_model/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param VehicleModel $vehicleModel
     * @return RedirectResponse|Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Request $request, VehicleModel $vehicleModel)
    {
        $this->isGranted('edit');
        $form = $this->createForm(VehicleModelType::class, $vehicleModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicleModelManager = $this->get(VehicleModelManager::class);

            $vehicleModelManager->save($vehicleModel);

            return $this->redirectToRoute('vehicle_model_back_show', [
                'id' => $vehicleModel->getId()
            ]);
        }

        return $this->render('web/back/vehicle_model/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param VehicleModel $vehicleModel
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(VehicleModel $vehicleModel)
    {
        $this->isGranted('delete');
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');
        $vehicleModelManager = $this->get(VehicleModelManager::class);
        $vehicleModelManager->delete($vehicleModel);
        return $this->redirectToRoute('vehicle_model_back_index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function export(Request $request)
    {
        $form = $this->createForm(SearchVehicleModelType::class, $searchVehicleModelCommand = new SearchVehicleModelCommand());
        $form->handleRequest($request);

        $this->dispatchMessage(new CreateVehicleModelCsvMessage($searchVehicleModelCommand));

        $this->addFlash('success', "L'export CSV est en cours de génération");

        return $this->redirectToRoute('vehicle_model_back_index');

    }
}