<?php

declare(strict_types=1);
/**
 * happy coding.
 */
namespace Jsondb\FileSystem;

class FileSystem
{


    public static function isWriteable(string $file): bool
    {
        return true;
    }

    public static function isReadable(string $file): bool
    {
        return true;
    }

    public static function makeDirectory(string $name)
    {
    }

    public static function removeDirectory(string $name)
    {
    }
}
