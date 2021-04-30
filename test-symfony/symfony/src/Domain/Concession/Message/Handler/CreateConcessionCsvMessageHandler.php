<?php

namespace App\Domain\Concession\Message\Handler;

use App\Domain\Concession\Manager\ConcessionManager;
use App\Domain\Concession\Message\CreateConcessionCsvMessage;
use App\Domain\Export\Entity\Export;
use App\Domain\Export\Manager\ExportManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use SplTempFileObject;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraints\Date;

class CreateConcessionCsvMessageHandler implements MessageHandlerInterface
{
    /** @var ExportManager */
    private $exportManager;

    /** @var ConcessionManager */
    private $concessionManager;

    /** @var Translator  */
    private $translator;

    /**
     * CreateConcessionCsvMessageHandler constructor.
     * @param ExportManager $exportManager
     * @param ConcessionManager $concessionManager
     * @param Translator $translator
     */
    public function __construct(ExportManager $exportManager, ConcessionManager $concessionManager, Translator $translator)
    {
        $this->exportManager = $exportManager;
        $this->concessionManager = $concessionManager;
        $this->translator = $translator;
    }

    /**
     * @param CreateConcessionCsvMessage $message
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws CannotInsertRecord
     */
    public function __invoke(CreateConcessionCsvMessage $message)
    {
        $export = new Export();

        $export->setCreatedAt(new \DateTime());
        $export->setType('concession');

        $this->exportManager->save($export);

        $data = $this->concessionManager->search($message->getSearchConcessionCommand());
        //$data = $this->vehicleModelManager->search($message->getSearchVehicleModelCommand());

        $csv = Writer::createFromFileObject(new SplTempFileObject());

        $csv->insertOne([
                $this->translator->trans('app.concession.id'),
                $this->translator->trans('app.concession.name'),
                $this->translator->trans('app.concession.city')
        ]);

        foreach ($data as $concession) {
            $csv->insertOne([
                $concession->getId(),
                $concession->getName(),
                $concession->getCity()
            ]);
        }

        $filesystem = new Filesystem();

        try {
            $filePath = 'files/uploads/export_' . (new \DateTime())->getTimestamp() . '.csv';

            if (!$filesystem->exists('public/' . $filePath)) {
                $filesystem->dumpFile('public/' . $filePath, $csv->getContent());

                $filesystem->dumpFile($filePath, $csv->getContent());

                $export->setFilePath($filePath);
                $export->setFinishedAt(new \DateTime());

                $this->exportManager->save($export);
            }
        } catch (IOExceptionInterface $exception) {
            echo "Error creating file at" . $exception->getPath();
        }

    }
}