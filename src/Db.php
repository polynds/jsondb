<?php

declare(strict_types=1);
/**
 * happy coding.
 */
namespace Jsondb;

use Exception;
use Jsondb\Exception\DbErrorException;
use Jsondb\Exception\DbNotFoundException;
use Jsondb\Exception\JsonDBException;
use Jsondb\FileSystem\FileSystem;
use Jsondb\FileSystem\Finder;
use Jsondb\Schema\Row;
use Jsondb\Schema\Schema;

class Db
{
    private string $path;

    /**
     * @var Schema[]
     */
    private array $collection;

    private string $ext = '.jsondb';

    /**
     * @throws JsonDBException
     */
    public function __construct(string $path)
    {
        $this->paserPath($path);
        $this->loadSchema();
    }

    public function getSchema(string $name): Schema
    {
        if (! array_key_exists($name, $this->collection)) {
            return $this->createSchema($name);
        }
        return $this->collection[$name];
    }

    public function loadSchema()
    {
        $files = Finder::open($this->path)->find();
        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            $json = file_get_contents($file->getPathname());
            if (! $json) {
                continue;
            }
            $json = json_decode($json);
            $data = [];
            foreach ($json['data'] as $row) {
                $data[] = new Row($row['key'], $row['data']);
            }
            $schema = (new Schema($json['name']))->setData($data);
            $this->cacheSchema($schema);
        }
    }

    private function cacheSchema(Schema $schema): void
    {
        $this->collection[$schema->getName()] = $schema;
    }

    private function createSchema(string $name): Schema
    {
        $schema = new Schema($name);
        $this->cacheSchema($schema);
        $this->flushSchema($schema);
        return $schema;
    }

    private function paserPath(string $path)
    {
        if (! $path || ! is_dir($path)) {
            throw DbNotFoundException::create('Database directory error.');
        }

        if (! is_writable($path)) {
            throw DbErrorException::create('Database directory cannot be written.');
        }

        $pathInfo = pathinfo($path);
        if (! $pathInfo || empty($pathInfo['dirname'])) {
            throw DbNotFoundException::create('Database directory parse error.');
        }

        $this->path = $pathInfo['dirname'] . DIRECTORY_SEPARATOR . 'jsonDbData';
        if (! is_dir($this->path)) {
            FileSystem::makeDirectory($this->path);
        }
    }

    private function flushSchema(Schema $schema)
    {
        try {
            file_put_contents($this->path . DIRECTORY_SEPARATOR . $schema->getName() . $this->ext, json_encode($schema));
        } catch (Exception $exception) {
            throw DbErrorException::create('Data writing failed.');
        }
    }
}
