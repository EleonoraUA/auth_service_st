<?php


namespace App\Service;


use App\Message\AnalyticEventMessage;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class AnalyticEventDispatcher
 * @package App\Service
 */
class AnalyticEventDispatcher
{
    /**
     * @var MessageBusInterface
     */
    protected $messageBus;

    /**
     * AnalyticEventDispatcher constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @param string $sourceLabel
     * @param string $userId
     */
    public function dispatch(string $sourceLabel, string $userId): void
    {
        $this->messageBus->dispatch(new AnalyticEventMessage($userId, $sourceLabel, time()));
    }
}