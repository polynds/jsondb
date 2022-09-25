<?php

declare(strict_types=1);
/**
 * happy coding.
 */
namespace Jsondb\Cache\LRU;

class LRU
{
    protected array $keys;

    public function addKey(array $keys): void
    {
        $this->keys = $keys;
    }
}
