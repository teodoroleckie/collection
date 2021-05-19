<?php

namespace Tleckie\Collection\Tests;

use Tleckie\Collection\Sequence;
use PHPUnit\Framework\TestCase;

/**
 * Class SequenceTest
 * @package Tleckie\Collection\Tests
 */
class SequenceTest extends TestCase
{
    /**
     * @var Sequence
     */
    private Sequence $sequence;

    private array $items = [
        'item0',
        'item1',
        'item2',
    ];

    protected function setUp(): void
    {
        $this->sequence = new Sequence($this->items);
    }

    /**
     * @test
     */
    public function iterator(): void
    {
        $count = 0;
        foreach ($this->sequence as $key => $item) {
            static::assertEquals(sprintf('%s', $count), $key);

            static::assertEquals(sprintf('item%s', $count), $item);

            $count++;
        }

        static::assertCount(3, $this->sequence);
        static::assertEquals(3, $count);
        static::assertEquals(null, $this->sequence->key());

        $count = 0;
        foreach ($this->sequence as $key => $item) {
            static::assertEquals(sprintf('%s', $count), $key);

            static::assertEquals(sprintf('item%s', $count), $item);

            $count++;
        }

        static::assertCount(3, $this->sequence);
        static::assertEquals(3, $count);
        static::assertEquals(null, $this->sequence->key());
    }

    /**
     * @test
     */
    public function reverse(): void
    {
        $reversed = $this->sequence->reverse();
        static::assertInstanceOf(Sequence::class, $reversed);

        static::assertTrue(['item2', 'item1', 'item0'] === $reversed->toArray());
    }

    /**
     * @test
     */
    public function sortByKey(): void
    {
        $sequence = $this->sequence->reverse()->sortByKey();


        static::assertInstanceOf(Sequence::class, $sequence);

        static::assertTrue([0 =>'item2', 1 =>'item1', 2 =>'item0'] === $sequence->toArray());
    }

    /**
     * @test
     */
    public function sortByValue(): void
    {
        $sequence = $this->sequence->reverse()->sortByValue();

        static::assertInstanceOf(Sequence::class, $sequence);

        static::assertTrue([0 =>'item0', 1 =>'item1', 2 =>'item2'] === $sequence->toArray());
    }

    /**
     * @test
     */
    public function sort(): void
    {
        $sequence = $this->sequence->reverse()->sort(static function ($prev, $next) {
            if ($prev === $next) {
                return 0;
            }
            return ($prev < $next) ? -1 : 1;
        });

        static::assertTrue([0 => 'item0', 1 => 'item1', 2 => 'item2'] === $sequence->toArray());
    }

    /**
     * @test
     */
    public function find(): void
    {
        $items = $this->sequence->find(static function ($key, $value) {
            if (filter_var($value, FILTER_SANITIZE_NUMBER_INT) > 0) {
                return true;
            }
            return false;
        });

        static::assertTrue([0 => 'item1', 1 => 'item2'] === $items->toArray());
    }

    /**
     * @test
     */
    public function prepend(): void
    {
        $this->sequence->prepend('value9');

        static::assertTrue([
                0 => 'value9',
                1 => 'item0',
                2 => 'item1',
                3 => 'item2'
            ] === $this->sequence->toArray());
    }

    /**
     * @test
     */
    public function shuffle(): void
    {
        foreach (range(0, 20) as $item) {
            $this->sequence->append($item);
        }

        $sequence = $this->sequence->shuffle();

        static::assertFalse($sequence->get(0) === 'item0');
        static::assertTrue($sequence->get(999) === null);
    }

    /**
     * @test
     */
    public function remove(): void
    {
        $sequence = $this->sequence->remove(0);

        static::assertTrue([
                0 => 'item1',
                1 => 'item2'
            ] === $sequence->toArray());
    }

    /**
     * @test
     */
    public function hasValue(): void
    {
        static::assertTrue($this->sequence->hasValue('item2'));
        static::assertFalse($this->sequence->hasValue('item299999'));
    }

    /**
     * @test
     */
    public function empty(): void
    {
        $sequence = $this->sequence->empty();

        static::assertTrue([] === $sequence->toArray());
    }
}
