<?php

namespace Tleckie\Collection;

use Closure;

/**
 * Interface SearchableInterface
 *
 * @package Tleckie\Collection
 * @author  Teodoro Leckie Westberg <teodoroleckie@gmail.com>ç
 */
interface SearchableInterface
{
    /**
     * @param callable|Closure $callable
     * @return CollectionInterface
     */
    public function find(callable|Closure $callable): CollectionInterface;

    /**
     * @param string|int $index
     * @return mixed
     */
    public function findIndex(string|int $index): mixed;
}
