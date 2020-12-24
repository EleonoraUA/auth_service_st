<?php


namespace App\MessageHandler;

use App\Message\AnalyticEventMessage;
use App\Service\AnalyticService;
use App\Service\AnalyticServiceInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class AnalyticEventMessageHandler
 * @package App\MessageHandler
 */
class AnalyticEventMessageHandler implements MessageHandlerInterface
{
    /**
     * @var AnalyticServiceInterface
     */
    protected $analyticService;

    /**
     * AnalyticEventMessageHandler constructor.
     * @param AnalyticService $analyticService
     */
    public function __construct(AnalyticService $analyticService)
    {
        $this->analyticService = $analyticService;
    }

    /**
     * @param AnalyticEventMessage $message
     */
    public function __invoke(AnalyticEventMessage $message)
    {
        $this->analyticService->handleEvent($message);
    }
}