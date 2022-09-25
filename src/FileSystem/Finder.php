<?php

declare(strict_types=1);
/**
 * happy coding.
 */
namespace Jsondb\FileSystem;

use SplFileInfo;

class Finder
{
    protected string $path;

    protected string $ext = '.kjson';

    private function __construct(string $path)
    {
        $this->path = $path;
    }

    public static function open(string $path): Finder
    {
        return new static($path);
    }

    /**
     * 返回包含所有文件的一维数组.
     */
    public function find(string $path = null): array
    {
        $path = $path ?? $this->path;
        $result = [];
        $files = scandir($path);
        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $_file = $path . DIRECTORY_SEPARATOR . $file;

            if (is_dir($_file)) {
                $result = array_merge($result, ...$this->find($_file));
            } else {
                $result[] = new SplFileInfo($_file);
            }
        }

        return $result;
    }

    /**
     * 返回一颗目录树数组.
     */
    public function tree(string $path = null): array
    {
        $path = $path ?? $this->path;
        $result = [];
        $files = scandir($path);
        foreach ($files as $key => $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $_file = $path . DIRECTORY_SEPARATOR . $file;

            if (is_dir($_file)) {
                $result[$key]['child'] = array_merge($result, ...$this->tree($_file));
            } else {
                $result[$key] = new SplFileInfo($_file);
            }
        }

        return $result;
    }
}
