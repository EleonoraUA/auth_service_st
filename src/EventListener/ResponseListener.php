<?php


namespace App\EventListener;

use App\Entity\User;
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
        $userId = $event->getRequest()->cookies->get(User::ANON_USER_ID_KEY);
        $event->getResponse()->headers->setCookie(Cookie::create(User::ANON_USER_ID_KEY, $userId));
    }
}