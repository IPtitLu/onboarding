<?php


namespace App\Domain\Export\Entity;

use DateTime;

class Export
{
    /** @var int|null */
    private $id;

    /** @var string|null */
    private $type;

    /** @var DateTime|null */
    private $createdAt;

    /** @var DateTime|null */
    private $finishedAt;

    /** @var  string|null */
    private $filePath;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return Export
     */
    public function setType(?string $type): Export
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime|null $createdAt
     * @return Export
     */
    public function setCreatedAt(?DateTime $createdAt): Export
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getFinishedAt(): ?DateTime
    {
        return $this->finishedAt;
    }

    /**
     * @param DateTime|null $finishedAt
     * @return Export
     */
    public function setFinishedAt(?DateTime $finishedAt): Export
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @param string|null $filePath
     * @return Export
     */
    public function setFilePath(?string $filePath): Export
    {
        $this->filePath = $filePath;

        return $this;
    }



}