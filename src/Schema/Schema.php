<?php

declare(strict_types=1);
/**
 * happy coding.
 */
namespace Jsondb\Schema;

class Schema implements \JsonSerializable
{
    protected string $name;

    /**
     * @var Row[]
     */
    protected array $data = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param Row[] $data
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function get(string $key)
    {
        /** @var ?Row $row */
        $row = $this->data[$key] ?? null;
        if (is_null($row)) {
            return null;
        }
        return $row->getData();
    }

    /**
     * 1、如果name不存在的话，就先创建，然后再写入数据
     * 2、如果name已存在，就写入数据.
     * @param mixed $data
     */
    public function set(string $key, $data)
    {
        $this->data[$key] = new Row($key, $data);
    }

    public function del(string $key): bool
    {
        if (isset($this->data[$key])) {
            unset($this->data[$key]);
            return true;
        }
        return false;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'data' => $this->data,
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }
}
