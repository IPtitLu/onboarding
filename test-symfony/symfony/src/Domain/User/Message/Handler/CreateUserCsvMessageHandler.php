<?php

namespace App\Domain\User\Message\Handler;

use App\Domain\Export\Entity\Export;
use App\Domain\Export\Manager\ExportManager;
use App\Domain\User\Manager\UserManager;
use App\Domain\User\Message\CreateUserCsvMessage;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use SplTempFileObject;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\Translation\TranslatorInterface;


class CreateUserCsvMessageHandler implements MessageHandlerInterface
{
    /** @var UserManager */
    private $userManager;

    /** @var ExportManager */
    private $exportManager;

    /** @var TranslatorInterface  */
    private $translator;

    /**
     * CreateUserCsvMessageHandler constructor.
     * @param UserManager $userManager
     * @param ExportManager $exportManager
     * @param TranslatorInterface $translator
     */
    public function __construct(UserManager $userManager, ExportManager $exportManager, TranslatorInterface $translator)
    {
        $this->userManager = $userManager;
        $this->exportManager = $exportManager;
        $this->translator = $translator;
    }

    /**
     * @param CreateUserCsvMessage $message
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws CannotInsertRecord
     */
    public function __invoke(CreateUserCsvMessage $message)
    {
        // Instantiation of UserExport -> export of a file csv

        $export = new Export();

        $export->setCreatedAt(new \DateTime());
        $export->setType('user');

        $this->exportManager->save($export);

        $data = $this->userManager->search($message->getSearchUserCommand());

        $csv = Writer::createFromFileObject(new SplTempFileObject());

        $csv->insertOne([
            $this->translator->trans('app.user.id'),
            $this->translator->trans('app.user.first_name'),
            $this->translator->trans('app.user.last_name'),
            $this->translator->trans('app.user.email'),
            $this->translator->trans('app.user.role')
        ]);

        foreach ($data as $user) {
            $csv->insertOne([
                $user->getId(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getEmail(),
                current($user->getRoles())
            ]);
        }

        //create new file with content var ( csv content )
        $filesystem = new Filesystem();

        // create a new file and add contents
        // file name -> base : export + random number | TimeStamp
        // dossier -> public/files/uploads | save files her
        try {
            $filePath = 'files/uploads/export_' . (new DateTime())->getTimestamp() . '.csv';

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