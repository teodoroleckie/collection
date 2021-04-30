<?php

namespace Tleckie\Collection;

use Closure;

/**
 * Interface FiltrableInterface
 *
 * @package Tleckie\Collection
 * @author  Teodoro Leckie Westberg <teodoroleckie@gmail.com>
 */
interface FiltrableInterface
{
    /**
     * @param callable|Closure $callable
     * @return CollectionInterface
     */
    public function filter(callable|Closure $callable): CollectionInterface;

    /**
     * @param callable|Closure $callable
     * @return CollectionInterface
     */
    public function filterNot(callable|Closure $callable): CollectionInterface;
}
