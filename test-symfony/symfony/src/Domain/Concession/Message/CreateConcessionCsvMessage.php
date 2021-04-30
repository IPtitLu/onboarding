<?php

namespace App\Domain\Concession\Message;

use App\Domain\Concession\Form\Command\SearchConcessionCommand;

class CreateConcessionCsvMessage
{
    /** @var SearchConcessionCommand */
    private $searchConcessionCommand;

    /**
     * CreateConcessionCSVMessage constructor.
     * @param SearchConcessionCommand $searchConcessionCommand
     */
    public function __construct(SearchConcessionCommand $searchConcessionCommand)
    {
        $this->searchConcessionCommand = $searchConcessionCommand;
    }

    /**
     * @return SearchConcessionCommand
     */
    public function getSearchConcessionCommand(): SearchConcessionCommand
    {
        return $this->searchConcessionCommand;
    }
}