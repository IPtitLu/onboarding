<?php


namespace App\Domain\Export\Controller\Web;

use App\Domain\Export\Entity\Export;
use App\Domain\Export\Manager\ExportManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends AbstractController
{

    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $page = $request->query->get('page');

        // Instantiation of manager
        $exportManager = $this->get(ExportManager::class);

        // Call manager's method which find all users
        $exports = $exportManager->getPaginated($page);

        return $this->render('web/back/export/index.html.twig', [
            'exports' => $exports
        ]);
    }

    public function download(Export $export)
    {
        $response = new BinaryFileResponse($export->getFilePath());

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            basename($export->getFilePath())
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}