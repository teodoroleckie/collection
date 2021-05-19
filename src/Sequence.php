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
 * Class Sequence
 * @package Tleckie\Collection
 */
class Sequence implements SequenceInterface
{
    /**
     * @var array
     */
    protected array $items;

    /**
     * Sequence constructor.
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = [];

        foreach ($items as $index => $item) {
            $this->append($item);
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
    public function key(): null|int
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
    public function sortByKey(): SequenceInterface
    {
        $items = $this->items;

        ksort($items);

        return new Sequence($items);
    }

    /**
     * @inheritdoc
     */
    public function sortByValue(): SequenceInterface
    {
        $items = $this->items;

        sort($items);

        return new Sequence($items);
    }

    /**
     * @see https://www.php.net/manual/es/function.usort.php
     * @param callable $callable function($itemPrev, $itemNext){ if($itemPrev === $itemNext){ return 0; } return ($itemPrev < $itemNext) ? -1 : 1;}
     * @return SequenceInterface
     */
    public function sort(callable $callable): SequenceInterface
    {
        $items = $this->items;

        usort($items, $callable);

        return new Sequence($items);
    }

    /**
     * @inheritdoc
     */
    public function reverse(): SequenceInterface
    {
        $items = $this->items;

        return new self(
            array_reverse($items)
        );
    }

    /**
     * @inheritdoc
     */
    public function filter(callable $filterFunction): SequenceInterface
    {
        $items = [];
        $copy = $this->items;

        foreach ($copy as $index => $value) {
            if ($filterFunction($index, $value)) {
                $items[$index] = $value;
            }
        }

        return new Sequence($items);
    }

    /**
     * @inheritdoc
     */
    public function find(callable $findFunction): SequenceInterface
    {
        return $this->filter($findFunction);
    }

    /**
     * @inheritdoc
     */
    public function empty(): SequenceInterface
    {
        $this->items = [];

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hasKey(int $index): bool
    {
        return array_key_exists($index, $this->items);
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
    public function get(int $index): mixed
    {
        return $this->items[$index] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function append(mixed $item): SequenceInterface
    {
        array_push($this->items, $item);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function prepend(mixed $item): SequenceInterface
    {
        array_unshift($this->items, $item);

        return new self($this->items);
    }

    /**
     * @inheritdoc
     */
    public function remove(int $index): SequenceInterface
    {
        if ($this->hasKey($index)) {
            unset($this->items[$index]);
        }

        return new self($this->items);
    }

    /**
     * @inheritdoc
     */
    public function shuffle(): SequenceInterface
    {
        $items = $this->items;

        shuffle($items);

        return new self($items);
    }

    /**
     * @inheritdoc
     */
    public function toArray(): array
    {
        return $this->items;
    }
}
