<?php

namespace Tleckie\Collection;

use Iterator;
use Countable;

/**
 * Interface QueueableInterface
 *
 * @package Tleckie\Collection
 * @author  Teodoro Leckie Westberg <teodoroleckie@gmail.com>
 */
interface QueueableInterface
{
    /**
     * @param mixed $item
     * @return CollectionInterface
     */
    public function push(mixed $item): CollectionInterface;

    /**
     * @return mixed
     */
    public function pull(): mixed;
}
