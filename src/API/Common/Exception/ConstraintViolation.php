<?php

declare(strict_types=1);

namespace App\API\Common\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ConstraintViolation extends RuntimeException
{
    public function __construct(ConstraintViolationListInterface $constraintViolationList)
    {
        parent::__construct(serialize($constraintViolationList));
    }
}
