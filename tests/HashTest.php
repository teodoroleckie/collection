<?php

namespace Tleckie\Collection\Tests;

use Tleckie\Collection\Hash;
use PHPUnit\Framework\TestCase;

/**
 * Class HashTest
 * @package Tleckie\Collection\Tests
 */
class HashTest extends TestCase
{
    /**
     * @var Hash
     */
    private Hash $hash;

    private array $items = [
        'key0' => 'item0',
        'key1' => 'item1',
        'key2' => 'item2',
    ];

    protected function setUp(): void
    {
        $this->hash = new Hash($this->items);
    }

    /**
     * @test
     */
    public function iterator(): void
    {
        $count = 0;
        foreach ($this->hash as $key => $item) {
            static::assertEquals(sprintf('key%s', $count), $key);

            static::assertEquals(sprintf('item%s', $count), $item);

            $count++;
        }

        static::assertCount(3, $this->hash);
        static::assertEquals(3, $count);
        static::assertEquals(null, $this->hash->key());

        $count = 0;
        foreach ($this->hash as $key => $item) {
            static::assertEquals(sprintf('key%s', $count), $key);

            static::assertEquals(sprintf('item%s', $count), $item);

            $count++;
        }

        static::assertCount(3, $this->hash);
        static::assertEquals(3, $count);
        static::assertEquals(null, $this->hash->key());
    }

    /**
     * @test
     */
    public function reverse(): void
    {
        $reversed = $this->hash->reverse();
        static::assertInstanceOf(Hash::class, $reversed);

        $count = 2;
        foreach ($reversed as $key => $item) {
            static::assertEquals(sprintf('key%s', $count), $key);

            static::assertEquals(sprintf('item%s', $count), $item);

            $count--;
        }

        static::assertCount(3, $reversed);
        static::assertEquals(-1, $count);
        static::assertEquals(null, $reversed->key());


        $hash = $reversed->sortByKey();

        static::assertInstanceOf(Hash::class, $hash);

        $count = 0;
        foreach ($hash as $key => $item) {
            static::assertEquals(sprintf('key%s', $count), $key);

            static::assertEquals(sprintf('item%s', $count), $item);

            $count++;
        }

        static::assertCount(3, $hash);
        static::assertEquals(3, $count);
        static::assertEquals(null, $hash->key());
    }

    /**
     * @test
     */
    public function sortByValue(): void
    {
        $sorted = $this->hash->reverse()->sortByValue();
        static::assertInstanceOf(Hash::class, $sorted);

        $count = 0;
        foreach ($sorted as $key => $item) {
            static::assertEquals(sprintf('key%s', $count), $key);

            static::assertEquals(sprintf('item%s', $count), $item);

            $count++;
        }

        static::assertCount(3, $sorted);
        static::assertEquals(3, $count);
        static::assertEquals(null, $sorted->key());
    }

    /**
     * @test
     */
    public function sort(): void
    {
        $reversed = $this->hash->reverse();
        $sorted = $reversed->sort(static function ($prev, $next) {
            if ($prev === $next) {
                return 0;
            }
            return ($prev < $next) ? -1 : 1;
        });

        static::assertTrue($this->items === $sorted->toArray());
        static::assertTrue($sorted->hasValue('item0'));
        static::assertEquals('item0', $sorted->get('key0'));


        static::assertFalse($sorted->hasValue('item9'));
        static::assertEquals(null, $sorted->get('key9'));

        static::assertTrue(['key2' => 'item2', 'key1' => 'item1', 'key0' => 'item0'] === $reversed->toArray());
    }

    /**
     * @test
     */
    public function find(): void
    {
        $items = $this->hash->find(static function ($key, $value) {
            if (filter_var($value, FILTER_SANITIZE_NUMBER_INT) > 0) {
                return true;
            }
            return false;
        });

        static::assertTrue(['key1' => 'item1', 'key2' => 'item2'] === $items->toArray());
    }

    /**
     * @test
     */
    public function prepend(): void
    {
        $this->hash->prepend('key9', 'value9');

        static::assertTrue([
                'key9' => 'value9',
                'key0' => 'item0',
                'key1' => 'item1',
                'key2' => 'item2'
            ] === $this->hash->toArray());
    }

    /**
     * @test
     */
    public function shuffle(): void
    {
        $hash = $this->hash->shuffle();

        static::assertTrue([
                'key0' => 'item0',
                'key1' => 'item1',
                'key2' => 'item2'
            ] !== $hash->toArray());
    }

    /**
     * @test
     */
    public function remove(): void
    {
        $hash = $this->hash->remove('key0');

        static::assertTrue([
                'key1' => 'item1',
                'key2' => 'item2'
            ] === $hash->toArray());
    }

    /**
     * @test
     */
    public function empty(): void
    {
        $hash = $this->hash->empty();

        static::assertTrue([] === $hash->toArray());
    }
}
