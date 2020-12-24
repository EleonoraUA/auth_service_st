<?php

namespace App\Message;


/**
 * Class AnalyticEventMessage
 * @package App\Message
 */
class AnalyticEventMessage
{
    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $sourceLabel;

    /**
     * @var int
     */
    protected $dateCreated;

    /**
     * AnalyticEventMessage constructor.
     * @param string $userId
     * @param string $sourceLabel
     * @param int $dateCreated
     */
    public function __construct(string $userId, string $sourceLabel, int $dateCreated)
    {
        $this->userId = $userId;
        $this->sourceLabel = $sourceLabel;
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return $this
     */
    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getSourceLabel(): string
    {
        return $this->sourceLabel;
    }

    /**
     * @param string $sourceLabel
     * @return $this
     */
    public function setSourceLabel(string $sourceLabel): self
    {
        $this->sourceLabel = $sourceLabel;

        return $this;
    }

    /**
     * @return int
     */
    public function getDateCreated(): int
    {
        return $this->dateCreated;
    }

    /**
     * @param int $dateCreated
     * @return $this
     */
    public function setDateCreated(int $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
}