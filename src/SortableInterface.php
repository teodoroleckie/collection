<?php

namespace Tleckie\Collection;

use Closure;

/**
 * Interface SortableInterface
 *
 * @package Tleckie\Collection
 * @author  Teodoro Leckie Westberg <teodoroleckie@gmail.com>
 */
interface SortableInterface
{
    /**
     * @param callable|Closure $callable
     * @return CollectionInterface
     */
    public function sort(callable|Closure $callable): CollectionInterface;

    /**
     * @return CollectionInterface
     */
    public function reverse(): CollectionInterface;

    /**
     * @return CollectionInterface
     */
    public function shuffle(): CollectionInterface;
}
