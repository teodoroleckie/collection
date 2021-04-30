<?php

namespace Tleckie\Collection;

use Iterator;
use Countable;

/**
 * Interface CollectionInterface
 *
 * @package Tleckie\Collection
 * @author  Teodoro Leckie Westberg <teodoroleckie@gmail.com>
 */
interface CollectionInterface extends
    Countable,
    Iterator,
    FiltrableInterface,
    SearchableInterface,
    SortableInterface,
    QueueableInterface
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @param mixed $item
     * @return CollectionInterface
     */
    public function append(mixed $item): CollectionInterface;

    /**
     * @param mixed $item
     * @return CollectionInterface
     */
    public function prepend(mixed $item): CollectionInterface;
}
