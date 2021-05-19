<?php

namespace Tleckie\Collection;

use Countable;
use Iterator;

/**
 * Interface Sequence
 * @package Tleckie\Collection
 */
interface SequenceInterface extends Iterator, Countable
{
    /**
     * @return mixed
     */
    public function current(): mixed;

    public function next(): void;

    /**
     * @return int|null
     */
    public function key(): null|int;

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
     * @return SequenceInterface
     */
    public function sortByKey(): SequenceInterface;

    /**
     * @return SequenceInterface
     */
    public function sortByValue(): SequenceInterface;

    /**
     * @see https://www.php.net/manual/es/function.usort.php
     * @param callable $callable function($itemPrev, $itemNext){ if($itemPrev === $itemNext){ return 0; } return ($itemPrev < $itemNext) ? -1 : 1;}
     * @return SequenceInterface
     */
    public function sort(callable$callable): SequenceInterface;

    /**
     * @return SequenceInterface
     */
    public function reverse(): SequenceInterface;

    /**
     * @param callable $filterFunction
     * @return SequenceInterface
     */
    public function filter(callable $filterFunction): SequenceInterface;

    /**
     * @param callable $findFunction
     * @return SequenceInterface
     */
    public function find(callable $findFunction): SequenceInterface;

    /**
     * @return SequenceInterface
     */
    public function empty(): SequenceInterface;

    /**
     * @param int $index
     * @return bool
     */
    public function hasKey(int $index): bool;

    /**
     * @param mixed $item
     * @return bool
     */
    public function hasValue(mixed $item): bool;

    /**
     * @param int $index
     * @return mixed
     */
    public function get(int $index): mixed;

    /**
     * @param mixed $item
     * @return SequenceInterface
     */
    public function append(mixed $item): SequenceInterface;

    /**
     * @param mixed $item
     * @return SequenceInterface
     */
    public function prepend(mixed $item): SequenceInterface;

    /**
     * @param int $index
     * @return SequenceInterface
     */
    public function remove(int $index): SequenceInterface;

    /**
     * @return SequenceInterface
     */
    public function shuffle(): SequenceInterface;

    /**
     * @return array
     */
    public function toArray(): array;
}
