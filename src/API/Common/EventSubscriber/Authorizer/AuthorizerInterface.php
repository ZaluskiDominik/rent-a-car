<?php

declare(strict_types=1);

namespace App\API\Common\EventSubscriber\Authorizer;

use Symfony\Component\HttpKernel\Event\ControllerEvent;

interface AuthorizerInterface
{
    public function supports(ControllerEvent $event): bool;

    public function authorize(ControllerEvent $event): void;
}
