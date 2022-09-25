<?php

declare(strict_types=1);
/**
 * happy coding.
 */
namespace Jsondb\Exception;

class SchemaNotFoundException extends JsondbException
{
    public function __construct(string $name)
    {
        $message = sprintf('Schema %s not found in jsondb.', $name);
        parent::__construct($message);
    }
}
