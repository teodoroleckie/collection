<?php

namespace Tleckie\Collection;

use function current;
use function next;
use function key;
use function reset;
use function ksort;
use function asort;
use function array_reverse;
use function array_key_exists;

/**
 * Class Hash
 *
 * Hash objects must be used if the key is a string.
 *
 * @package Tleckie\Collection
 */
class Hash implements HashInterface
{
    /**
     * @var array
     */
    protected array $items;

    /**
     * Hash constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = [];

        foreach ($items as $key => $item) {
            $this->append($key, $item);
        }
    }

    /**
     * @inheritdoc
     */
    public function current(): mixed
    {
        return current($this->items);
    }

    /**
     * @inheritdoc
     */
    public function next(): void
    {
        next($this->items);
    }

    /**
     * @inheritdoc
     */
    public function key(): null|string
    {
        return key($this->items);
    }

    /**
     * @inheritdoc
     */
    public function valid(): bool
    {
        return $this->key() !== null;
    }

    /**
     * @inheritdoc
     */
    public function rewind(): void
    {
        reset($this->items);
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @inheritdoc
     */
    public function sortByKey(): HashInterface
    {
        $items = $this->items;

        ksort($items);

        return new Hash($items);
    }

    /**
     * @inheritdoc
     */
    public function sortByValue(): HashInterface
    {
        $items = $this->items;

        asort($items);

        return new Hash($items);
    }

    /**
     * @see https://www.php.net/manual/es/function.usort.php
     * @param callable $callable function($itemPrev, $itemNext){ if($itemPrev === $itemNext){ return 0; } return ($itemPrev < $itemNext) ? -1 : 1;}
     * @return HashInterface
     */
    public function sort(callable $callable): HashInterface
    {
        $items = $this->items;

        uasort($items, $callable);

        return new Hash($items);
    }

    /**
     * @inheritdoc
     */
    public function reverse(): HashInterface
    {
        return new self(
            array_reverse($this->items, true)
        );
    }

    /**
     * @inheritdoc
     */
    public function filter(callable $filterFunction): HashInterface
    {
        $items = [];
        $copy = $this->items;

        foreach ($copy as $key => $value) {
            if ($filterFunction($key, $value)) {
                $items[$key] = $value;
            }
        }

        return new Hash($items);
    }

    /**
     * @inheritdoc
     */
    public function find(callable $findFunction): HashInterface
    {
        return $this->filter($findFunction);
    }

    /**
     * @inheritdoc
     */
    public function empty(): HashInterface
    {
        $this->items = [];

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasKey(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * @inheritdoc
     */
    public function hasValue(mixed $item): bool
    {
        return false !== array_search($item, $this->items, true);
    }

    /**
     * @inheritdoc
     */
    public function get(string $key): mixed
    {
        return $this->items[$key] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function append(string $key, mixed $item): HashInterface
    {
        $this->items[$key] = $item;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prepend(string $key, mixed $item): HashInterface
    {
        $this->items = [$key => $item] + $this->items;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function remove(string $key): HashInterface
    {
        if ($this->hasKey($key)) {
            unset($this->items[$key]);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function shuffle(): HashInterface
    {
        $items = $this->items;

        shuffle($items);

        return new Hash($items);
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->items;
    }
}
