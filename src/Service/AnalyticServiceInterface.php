<?php


namespace App\Service;


use App\Message\AnalyticEventMessage;

/**
 * Interface AnalyticServiceInterface
 * @package App\Service
 */
interface AnalyticServiceInterface
{
    /**
     * @param AnalyticEventMessage $message
     */
    public function handleEvent(AnalyticEventMessage $message): void;
}