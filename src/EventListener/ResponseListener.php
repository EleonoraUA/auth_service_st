<?php


namespace App\EventListener;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Class ResponseListener
 * @package App\EventListener
 */
class ResponseListener
{
    /**
     * @param ResponseEvent $event
     */
    public function onKernelResponse(ResponseEvent $event): void
    {
        $userId = $event->getRequest()->cookies->get('anon_user_id');
        $event->getResponse()->headers->setCookie(Cookie::create('anon_user_id', $userId));
    }
}