<?php

declare(strict_types=1);

namespace App\API\Common\Request;

final class PropertyFilter
{
    public static function trim($value)
    {
        return is_string($value) ? trim($value) : $value;
    }

    public static function toInt($value)
    {
        return is_string($value) && ctype_digit($value) ? (int)$value : $value;
    }
}
