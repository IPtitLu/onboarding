<?php


namespace App\Domain\VehicleModel\Message\Handler;


use App\Domain\Export\Entity\Export;
use App\Domain\Export\Manager\ExportManager;
use App\Domain\VehicleModel\Manager\VehicleModelManager;
use App\Domain\VehicleModel\Message\CreateVehicleModelCsvMessage;
use League\Csv\Writer;
use SplTempFileObject;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Translation\Translator;

class CreateVehicleModelCsvMessageHandler
{
    private $vehicleModelManager;

    private $exportManager;

    private $translator;

    public function __construct(VehicleModelManager $vehicleModelManager, ExportManager $exportManager, Translator $translator)
    {
        $this->vehicleModelManager = $vehicleModelManager;
        $this->exportManager = $exportManager;
        $this->translator = $translator;
    }

    public function __invoke(CreateVehicleModelCsvMessage $message)
    {
        $export = new Export();

        $export->setCreatedAt(new \DateTime());
        $export->setType('vehicle_model');

        $this->exportManager->save($export);

        $data = $this->vehicleModelManager->search($message->getSearchVehicleModelCommand());

        $csv = Writer::createFromFileObject(new SplTempFileObject());

        $csv->insertOne([
            $this->translator->trans('app.vehicle_model.id'),
            $this->translator->trans('app.vehicle_model.brand'),
            $this->translator->trans('app.vehicle_model.name')
        ]);

        foreach ($data as $vehicleModel) {
            $csv->insertOne([
                $vehicleModel->getId(),
                $vehicleModel->getBrand(),
                $vehicleModel->getName()
            ]);
        }

        $filesystem = new Filesystem();

        try {
            $filePath = 'files/uploads/export_' . (new \DateTime())->getTimestamp() . '.csv';

            if (!$filesystem->exists('public/' . $filePath)) {
                $filesystem->dumpFile('public/' . $filePath, $csv->getContent());

                $export->setFilePath($filePath);
                $export->setFinishedAt(new \DateTime());

                $this->exportManager->save($export);
            }
        } catch (IOExceptionInterface $exception) {
            echo "Error creating file at" . $exception->getPath();
        }
    }
}