<?php

declare(strict_types=1);

namespace App\API\Common\EventSubscriber\ExceptionHandler;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

interface ExceptionHandlerInterface
{
    public function supports(ExceptionEvent $exceptionEvent): bool;

    public function handle(ExceptionEvent $exceptionEvent): void;
}
