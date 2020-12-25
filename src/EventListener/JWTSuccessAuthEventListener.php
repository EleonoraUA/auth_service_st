<?php


namespace App\EventListener;


use App\Service\AnalyticEventDispatcher;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

/**
 * Class JWTSuccessAuthEventListener
 * @package App\EventListener
 */
class JWTSuccessAuthEventListener
{
    /**
     * @var AnalyticEventDispatcher
     */
    protected $analyticEventDispatcher;

    /**
     * JWTSuccessAuthEventListener constructor.
     * @param AnalyticEventDispatcher $analyticEventDispatcher
     */
    public function __construct(AnalyticEventDispatcher $analyticEventDispatcher)
    {
        $this->analyticEventDispatcher = $analyticEventDispatcher;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event)
    {
        $this->analyticEventDispatcher->dispatch('auth_success', $event->getUser()->getId());
    }
}