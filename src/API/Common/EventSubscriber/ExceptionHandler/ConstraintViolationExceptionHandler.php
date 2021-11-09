<?php

declare(strict_types=1);

namespace App\API\Common\EventSubscriber\ExceptionHandler;

use App\API\Common\Exception\ConstraintViolation;
use App\API\Common\Response\RestApiResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

final class ConstraintViolationExceptionHandler implements ExceptionHandlerInterface
{
    public function supports(ExceptionEvent $exceptionEvent): bool
    {
        return $exceptionEvent->getThrowable() instanceof ConstraintViolation;
    }

    public function handle(ExceptionEvent $exceptionEvent): void
    {
        $exception = $exceptionEvent->getThrowable();
        $constraintViolationList = unserialize($exception->getMessage());
        $exceptionEvent->setResponse(RestApiResponse::fromConstraintViolationList($constraintViolationList));
    }
}
