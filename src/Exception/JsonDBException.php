<?php

declare(strict_types=1);
/**
 * happy coding.
 */
namespace Jsondb\Exception;

use Exception;

class JsonDBException extends Exception
{
    public static function create(string $message = '', int $code = 0): self
    {
        return new self($message, $code);
    }
}
