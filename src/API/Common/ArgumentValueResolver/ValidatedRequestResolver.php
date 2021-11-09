<?php

declare(strict_types=1);

namespace App\API\Common\ArgumentValueResolver;

use App\API\Common\Exception\ConstraintViolation;
use App\API\Common\Request\PreFilterRequestInterface;
use App\API\Common\Request\ValidatedRequestInterface;
use GeneratedHydrator\Configuration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ValidatedRequestResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument)
    {
        return in_array(ValidatedRequestInterface::class, class_implements($argument->getType()));
    }

    public function resolve(Request $request, ArgumentMetadata $argument)
    {
        $hydratedRequest = $this->hydrateRequest($request, $argument);

        if ($hydratedRequest instanceof PreFilterRequestInterface) {
            $hydratedRequest->preFilter();
        }

        if (count($errors = $this->validator->validate($hydratedRequest))) {
            throw new ConstraintViolation($errors);
        }

        yield $hydratedRequest;
    }

    private function hydrateRequest(Request $request, ArgumentMetadata $argument): ValidatedRequestInterface
    {
        $argType = $argument->getType();
        $config = new Configuration($argType);
        $hydratorClass = $config->createFactory()->getHydratorClass();
        $hydrator = new $hydratorClass();
        $hydratedRequest = new $argType();
        $hydrator->hydrate(
            call_user_func([$argType, 'getInput'], $request),
            $hydratedRequest
        );

        return $hydratedRequest;
    }
}
