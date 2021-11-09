<?php

declare(strict_types=1);

namespace App\API\Common\EventSubscriber\ExceptionHandler;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ExceptionEventSubscriber implements EventSubscriberInterface
{
    private iterable $exceptionHandlers;

    public function __construct(iterable $exceptionHandlers)
    {
        $this->exceptionHandlers = $exceptionHandlers;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException'],
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        /** @var ExceptionHandlerInterface $exceptionHandler */
        foreach ($this->exceptionHandlers as $exceptionHandler) {
            if ($exceptionHandler->supports($event)) {
                $exceptionHandler->handle($event);
            }
        }
    }
}
