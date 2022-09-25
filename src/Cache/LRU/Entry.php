<?php

declare(strict_types=1);
/**
 * happy coding.
 */
namespace Jsondb\Cache\LRU;

class Entry
{
    protected string $key;

    protected int $lastVisit;
}
