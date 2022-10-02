<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class DiscogsApiException extends Exception
{
    public static function tokenRequiredException(): static
    {
        return new static('This endpoint requires authentication. Discogs token is required.');
    }
}