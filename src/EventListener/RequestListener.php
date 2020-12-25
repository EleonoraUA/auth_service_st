<?php


namespace App\EventListener;

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
        $userId = $event->getRequest()->cookies->get('anon_user_id');
        if (!$userId) {
            $userId = uniqid();
            $event->getRequest()->cookies->set('anon_user_id', $userId);
        }

        dump($event->getRequest()->cookies->get('anon_user_id'));
    }
}