<?php


namespace App\Domain\User\Controller\Web;

use App\Domain\User\Entity\Vehicle;
use App\Domain\User\Form\Command\SearchUserCommand;
use App\Domain\User\Form\Type\SearchUserType;
use App\Domain\User\Manager\VehicleManager;
use App\Domain\User\Message\CreateUserCsvMessage;
use App\Domain\User\Security\UserVoter;
use App\Domain\User\Entity\User;
use App\Domain\User\Form\Type\UpdateUserType;
use App\Domain\User\Manager\UserManager;
use App\Domain\User\Form\Type\CreateUserType;
use App\Domain\VehicleModel\Entity\VehicleModel;
use App\Domain\VehicleModel\Manager\VehicleModelManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraint;
use Doctrine\Common\Collections\ArrayCollection;

class UserController extends AbstractController
{

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(SearchUserType::class, $searchUserCommand = new SearchUserCommand());
        $form->handleRequest($request);

        $page = $request->query->get('page');

        // Instantiation of manager
        $userManager = $this->get(UserManager::class);
        $users = $userManager->getPaginated($page, $searchUserCommand);

        return $this->render('web/back/user/index.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('web/back/user/detail.html.twig', [
            'user' => $user
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
        // Instantiation of user
        $user = new User();

        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);

        // user validation, send and redirecting
        if ($form->isSubmitted() && $form->isValid()) {
            // Instantiation of manager

            $userManager = $this->get(UserManager::class);

            $userManager->registerUser($user);

            return $this->redirectToRoute('user_back_index');
        }

        // form creation
        return $this->render('web/back/user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted(UserVoter::EDIT, $user);

        $form = $this->createForm(UpdateUserType::class, $user, [
            'validation_groups' => [Constraint::DEFAULT_GROUP, 'user_update']
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $userManager = $this->get(UserManager::class);
            $userManager->save($user);

            return $this->redirectToRoute('user_back_show', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('web/back/user/update.html.twig', [
            'form' => $form->createView(),
            'user' => $user->getId()
        ]);
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(User $user): RedirectResponse
    {
        $this->denyAccessUnlessGranted(UserVoter::DELETE, $user);
        $userManager = $this->get(UserManager::class);
        $userManager->delete($user);

        return $this->redirectToRoute('user_back_index');
    }

    /**
     * @return Response
     */
    public function login(): Response
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        //$user = $this->getUser();
        //$user->

        if ($this->getUser()) {
            return $this->redirectToRoute('user_back_index');
        }

        return $this->render('web/back/security/login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );
    }

    /**
     * @return Response
     */
    public function self()
    {
        return $this->render('web/back/user/self.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function selfUpdate(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UpdateUserType::class, $user, [
            'validation_groups' => [Constraint::DEFAULT_GROUP, 'user_update']
        ]);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->get(UserManager::class);
            $userManager->save($user);

            return $this->redirectToRoute('user_back_self');
        }

        return $this->render('web/back/user/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function export(Request $request)
    {
        $form = $this->createForm(SearchUserType::class, $searchUserCommand = new SearchUserCommand());
        $form->handleRequest($request);

        $this->dispatchMessage(new CreateUserCsvMessage($searchUserCommand));


        $this->addFlash('success', "L'export CSV est en cours de génération.");

        return $this->redirectToRoute('user_back_index');
    }
}