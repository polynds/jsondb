<?php

declare(strict_types=1);
/**
 * happy coding.
 */
namespace Jsondb\Schema;

class Row implements \JsonSerializable
{
    protected string $key;

    protected string $data = '';

    public function __construct(string $key, string $data)
    {
        $this->key = $key;
        $this->data = serialize($data);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return unserialize($this->data);
    }

    public function jsonSerialize(): array
    {
        return [
            'key' => $this->getKey(),
            'data' => $this->getData(),
        ];
    }
}
