<?php

namespace Tleckie\Collection;

use Closure;
use function array_push;
use function array_reverse;
use function array_shift;
use function array_unshift;
use function current;
use function key;
use function next;
use function reset;
use function shuffle;
use function usort;

/**
 * Class Collection
 *
 * @package Tleckie\Collection
 * @author  Teodoro Leckie Westberg <teodoroleckie@gmail.com>
 */
class Collection implements CollectionInterface
{
    /**
     * @var array
     */
    protected array $items;

    /**
     * Collection constructor.
     *
     * @param array|CollectionInterface $items
     */
    public function __construct(array|CollectionInterface $items = [])
    {
        $this->items = ($items instanceof CollectionInterface) ? $items->toArray() : $items;
    }

    /**
     * @param callable|Closure $callable
     * @return CollectionInterface
     */
    public function filter(callable|Closure $callable): CollectionInterface
    {
        return $this->internalFilter($callable);
    }

    /**
     * @param callable|Closure $callable
     * @param bool             $keep
     * @return CollectionInterface
     */
    private function internalFilter(callable|Closure $callable, bool $keep = true): CollectionInterface
    {
        $items = [];
        $copy = $this->items;

        foreach ($copy as $key => $value) {
            if ($keep === $callable($key, $value)) {
                $items[$key] = $value;
            }
        }

        return new Collection($items);
    }

    /**
     * @param callable|Closure $callable
     * @return CollectionInterface
     */
    public function filterNot(callable|Closure $callable): CollectionInterface
    {
        return $this->internalFilter($callable, false);
    }

    /**
     * @param callable|Closure $callable
     * @return CollectionInterface
     */
    public function find(callable|Closure $callable): CollectionInterface
    {
        $items = [];
        $copy = $this->items;

        foreach ($copy as $key => $value) {
            if ($callable($key, $value) === true) {
                $items[$key] = $value;
            }
        }

        return new Collection($items);
    }

    /**
     * @param string|int $index
     * @return mixed
     */
    public function findIndex(string|int $index): mixed
    {
        foreach ($this->items as $key => $value) {
            if ($key === $index) {
                return $value;
            }
        }

        return false;
    }

    /**
     * @param callable|Closure $callable
     * @return CollectionInterface
     */
    public function sort(callable|Closure $callable): CollectionInterface
    {
        $items = $this->items;

        usort($items, $callable);

        return new Collection($items);
    }

    /**
     * @return CollectionInterface
     */
    public function shuffle(): CollectionInterface
    {
        $items = $this->items;
        shuffle($items);

        return new Collection($items);
    }

    /**
     * @return CollectionInterface
     */
    public function reverse(): CollectionInterface
    {
        return new Collection(
            array_reverse($this->items, true)
        );
    }

    /**
     * @param mixed $item
     * @return CollectionInterface
     */
    public function prepend(mixed $item): CollectionInterface
    {
        array_unshift($this->items, $item);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
        return current($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return $this->key() !== null;
    }

    /**
     * @return string|float|int|bool
     */
    public function key(): string|float|int|bool
    {
        return key($this->items);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return mixed
     */
    public function rewind(): mixed
    {
        return reset($this->items);
    }

    /**
     * @param mixed $item
     * @return CollectionInterface
     */
    public function push(mixed $item): CollectionInterface
    {
        return $this->append($item);
    }

    /**
     * @param mixed $item
     * @return CollectionInterface
     */
    public function append(mixed $item): CollectionInterface
    {
        array_push($this->items, $item);

        return $this;
    }

    /**
     * @return mixed
     */
    public function pull(): mixed
    {
        return array_shift($this->items);
    }
}
