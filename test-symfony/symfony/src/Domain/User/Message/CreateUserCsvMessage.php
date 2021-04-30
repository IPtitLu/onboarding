<?php

namespace App\Domain\User\Message;

use App\Domain\User\Form\Command\SearchUserCommand;

class CreateUserCsvMessage
{
    /** @var SearchUserCommand */
    private $searchUserCommand;

    /**
     * CreateUserCsvMessage constructor.
     * @param SearchUserCommand $searchUserCommand
     */
    public function __construct(SearchUserCommand $searchUserCommand)
    {
        $this->searchUserCommand = $searchUserCommand;
    }

    /**
     * @return SearchUserCommand
     */
    public function getSearchUserCommand(): SearchUserCommand
    {
        return $this->searchUserCommand;
    }
}