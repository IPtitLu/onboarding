<?php

namespace App\Domain\Concession\Form\Command;

class SearchConcessionCommand
{
    /** @var string|null */
    private $name;

    /** @var string|null */
    private $city;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return SearchConcessionCommand
     */
    public function setName(?string $name): SearchConcessionCommand
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return SearchConcessionCommand
     */
    public function setCity(?string $city): SearchConcessionCommand
    {
        $this->city = $city;

        return $this;
    }


}