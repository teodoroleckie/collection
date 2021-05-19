<?php

namespace Tleckie\Collection;

use Countable;
use Iterator;

/**
 * Interface HashInterface
 * @package Tleckie\Collection
 */
interface HashInterface extends Iterator, Countable
{
    /**
     * @return mixed
     */
    public function current(): mixed;

    public function next(): void;

    /**
     * @return string|null
     */
    public function key(): null|string;

    /**
     * @return bool
     */
    public function valid(): bool;

    public function rewind(): void;

    /**
     * @return int
     */
    public function count(): int;

    /**
     * @return HashInterface
     */
    public function sortByKey(): HashInterface;

    /**
     * @return HashInterface
     */
    public function sortByValue(): HashInterface;

    /**
     * @see https://www.php.net/manual/es/function.usort.php
     * @param callable $callable function($itemPrev, $itemNext){ if($itemPrev === $itemNext){ return 0; } return ($itemPrev < $itemNext) ? -1 : 1;}
     * @return HashInterface
     */
    public function sort(callable$callable): HashInterface;

    /**
     * @return HashInterface
     */
    public function reverse(): HashInterface;

    /**
     * @param callable $filterFunction
     * @return HashInterface
     */
    public function filter(callable $filterFunction): HashInterface;

    /**
     * @param callable $findFunction
     * @return HashInterface
     */
    public function find(callable $findFunction): HashInterface;

    /**
     * @return HashInterface
     */
    public function empty(): HashInterface;

    /**
     * @param string $key
     * @return bool
     */
    public function hasKey(string $key): bool;

    /**
     * @param mixed $item
     * @return bool
     */
    public function hasValue(mixed $item): bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed;

    /**
     * @param string $key
     * @param mixed $item
     * @return HashInterface
     */
    public function append(string $key, mixed $item): HashInterface;

    /**
     * @param string $key
     * @param mixed $item
     * @return HashInterface
     */
    public function prepend(string $key, mixed $item): HashInterface;

    /**
     * @param string $key
     * @return HashInterface
     */
    public function remove(string $key): HashInterface;

    /**
     * @return HashInterface
     */
    public function shuffle(): HashInterface;

    /**
     * @return array
     */
    public function toArray(): array;
}
