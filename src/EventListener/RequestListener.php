<?php


namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Class RequestListener
 * @package App\EventListener
 */
class RequestListener
{
    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $userId = $event->getRequest()->cookies->get(User::ANON_USER_ID_KEY);
        if (!$userId) {
            $userId = uniqid();
            $event->getRequest()->cookies->set(User::ANON_USER_ID_KEY, $userId);
        }
    }
}