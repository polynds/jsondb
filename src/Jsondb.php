<?php

declare(strict_types=1);
/**
 * happy coding.
 */
namespace Jsondb;

use Jsondb\Exception\MethodNotFoundException;
use Jsondb\Exception\SchemaNotFoundException;

/**
 * @method get(string $name, string $key)
 * @method set(string $name, string $key, $data)
 * @method del(string $name, string $key):bool
 */
final class Jsondb
{
    private Db $db;

    private function __construct(string $dbPath)
    {
        $this->db = (new Db($dbPath));
    }

    public function __call($method, $arguments)
    {
        $schema = $arguments[0] ?? null;
        if (! $schema) {
            throw new SchemaNotFoundException($schema);
        }
        unset($arguments[0]);
        if (! method_exists($this->db->getSchema($schema), $method)) {
            throw MethodNotFoundException::create(sprintf('The database does not support method %s.', $method));
        }
        return $this->db->getSchema($schema)->{$method}(...$arguments);
    }

    public static function open(string $dbPath): Jsondb
    {
        return new static($dbPath);
    }
}
