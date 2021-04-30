<?php

namespace App\Domain\Concession\Controller\Web;

use App\Domain\Concession\Entity\Concession;
use App\Domain\Concession\Form\Command\SearchConcessionCommand;
use App\Domain\Concession\Message\CreateConcessionCSVMessage;
use App\Domain\User\Message\CreateUserCsvMessage;
use App\Domain\Concession\Form\Type\ConcessionType;
use App\Domain\Concession\Form\Type\SearchConcessionType;
use App\Domain\Concession\Manager\ConcessionManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraint;

class ConcessionController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $form = $this->createForm(SearchConcessionType::class, $searchConcessionCommand = new SearchConcessionCommand());
        $form->handleRequest($request);
        // number of page
        $page = $request->query->get('page');

        // instantiation concession
        $concessionManager = $this->get(ConcessionManager::class);

        // data
        $concessions = $concessionManager->getPaginated($page, $searchConcessionCommand);

        // send content to view
        return $this->render('web/back/concession/index.html.twig', [
            'concessions' => $concessions,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Concession $concession
     * @return Response
     */
    public function show(Concession $concession)
    {
        $test = $concession;
        return $this->render('web/back/concession/detail.html.twig', [
            'concessions' => $concession
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
        // instantiation concession
        $concession = new Concession();

        // form creation
        $form = $this->createForm(ConcessionType::class, $concession);
        $form->handleRequest($request);

        // user validation, send and redirecting
        if ($form->isSubmitted() && $form->isValid()) {
            //Instantiation concessionManager
            $concessionManager = $this->get(ConcessionManager::class);
            // send concession to concession manager function
            $concessionManager->save($concession);

            return $this->redirectToRoute('concession_back_index');
        }

        //send render
        return $this->render('web/back/concession/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Concession $concession
     * @return RedirectResponse|Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Request $request, Concession $concession)
    {
        $form = $this->createForm(ConcessionType::class, $concession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concessionManager = $this->get(ConcessionManager::class);

            $concessionManager->save($concession);

            return $this->redirectToRoute('concession_back_show', [
                'id' => $concession->getId()
            ]);
        }

        return $this->render('web/back/concession/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Concession $concession
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Concession $concession)
    {
        $concessionManager = $this->get(ConcessionManager::class);
        $concessionManager->delete($concession);
        return $this->redirectToRoute('concession_back_index');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function export(Request $request)
    {
        $form = $this->createForm(SearchConcessionType::class, $searchConcessionCommand = new SearchConcessionCommand());
        $form->handleRequest($request);

        $this->dispatchMessage(new CreateConcessionCsvMessage($searchConcessionCommand));

        $this->addFlash('success', "L'export CSV est en cours de génération");

        return $this->redirectToRoute('concession_back_index');
    }
}