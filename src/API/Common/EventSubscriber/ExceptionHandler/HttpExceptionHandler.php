<?php

declare(strict_types=1);

namespace App\API\Common\EventSubscriber\ExceptionHandler;

use App\API\Common\Response\RestApiResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class HttpExceptionHandler implements ExceptionHandlerInterface
{
    public function supports(ExceptionEvent $exceptionEvent): bool
    {
        return $exceptionEvent->getThrowable() instanceof HttpExceptionInterface;
    }

    public function handle(ExceptionEvent $exceptionEvent): void
    {
        /** @var HttpExceptionInterface $exception */
        $exception = $exceptionEvent->getThrowable();
        $exceptionEvent->setResponse(RestApiResponse::error($exception->getMessage(), $exception->getStatusCode()));

    }
}
