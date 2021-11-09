<?php

declare(strict_types=1);

namespace App\API\Common\EventSubscriber\Authorizer;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class KernelControllerEventSubscriber //implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => 'onKernelController'];
    }

    public function onKernelController(ControllerEvent $event)
    {
        if (!$event->getController() instanceof ApiKeyProtectedController) {
            return;
        }
    }
}
