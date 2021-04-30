<?php

namespace App\Domain\VehicleModel\Manager;

use App\Common\Manager\AbstractManager;
use App\Common\Repository\AbstractRepository;
use App\Domain\VehicleModel\Entity\VehicleModel;
use App\Domain\VehicleModel\Form\Command\SearchVehicleModelCommand;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class VehicleModelManager extends AbstractManager {

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    private $client;

    /**
     * VehicleModelManager constructor.
     * @param HttpClientInterface $client
     * @param AbstractRepository $repository
     * @param PaginatorInterface $paginator
     */
    public function __construct(AbstractRepository $repository, PaginatorInterface $paginator, HttpClientInterface $client)
    {
        parent::__construct($repository);

        $this->paginator = $paginator;

        $this->client = $client;
    }

    /**
     * @param int|null $page
     * @param SearchVehicleModelCommand $searchVehicleCommand
     * @return PaginationInterface
     */
    public function getPaginated(?int $page = null, SearchVehicleModelCommand $searchVehicleCommand)
    {
        return $this->paginator->paginate(
            $this->repository->search($searchVehicleCommand),
            $page ?? 1,
            5
        );
    }

    /**
     * @param VehicleModel $vehicleModel
     * @return mixed|null
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function getVehicleModelVideo(VehicleModel $vehicleModel)
    {

        $url = HttpClient::createForBaseUri('https://api.dailymotion.com/videos');

        $brand = $vehicleModel->getBrand();

        $name = $vehicleModel->getName();

        $videoJson = $this->client->request('GET', 'https://api.dailymotion.com/videos', [
            // these values are automatically encoded before including them in the URL
            'query' => [
                'fields' => 'embed_url',
                'limit' => 1,
                'search' => $brand .' '. $name
            ],
        ]);

        $videoArray = $videoJson->toArray();

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $response = $propertyAccessor->getValue($videoArray, '[list]');
        return $propertyAccessor->getValue($response, '[0]');
    }

    public function search(SearchVehicleModelCommand $searchVehicleModelCommand)
    {
        return $this->repository->search($searchVehicleModelCommand, true);
    }

}