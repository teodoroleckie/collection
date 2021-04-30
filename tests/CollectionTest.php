<?php

use PHPUnit\Framework\TestCase;
use Tleckie\Collection\Collection;

/**
 * Class CollectionTest
 *
 * @author Teodoro Leckie Westberg <teodoroleckie@gmail.com>
 */
class CollectionTest extends TestCase
{
    /** @var Collection */
    private Collection $collection;

    /** @var array  */
    private array $data;

    public function setUp(): void
    {
        $this->data = [
            'name' => 'Marcos',
            'age' => 25,
            0 => 5555,
            1 => 'Juan',
            'other' => 'Marcos',
        ];

        $this->collection = new Collection($this->data);
    }

    /**
     * @test
     */
    public function filter(): void
    {
        $collection = $this->collection->filter(static function ($key, $value) {
            return is_int($value);
        });

        $this->assertEquals(new Collection(['age' => 25, 0 => 5555]), $collection);
    }

    /**
     * @test
     */
    public function filterNot(): void
    {
        $collection = $this->collection->filterNot(static function ($key, $value) {
            return is_int($value);
        });

        $this->assertEquals(new Collection(['name' => 'Marcos', 1 => 'Juan', 'other' => 'Marcos']), $collection);
    }

    /**
     * @test
     */
    public function find(): void
    {
        $collection = $this->collection->find(static function ($key, $value) {
            return $value === 'Marcos';
        });

        $this->assertEquals(new Collection(['name' => 'Marcos', 'other' => 'Marcos']), $collection);
    }

    /**
     * @test
     */
    public function findIndex(): void
    {
        $this->assertEquals('Marcos', $this->collection->findIndex('other'));
        $this->assertEquals(false, $this->collection->findIndex('NONE'));
    }

    /**
     * @test
     */
    public function sort(): void
    {
        $this->collection = new Collection(new Collection([9, 7, 2, 8, 5, 3, 6, 1, 4]));

        $collection = $this->collection->sort(static function (mixed $prev, mixed $next) {
            if ($prev === $next) {
                return 0;
            }

            return ($prev > $next) ? -1 : 1;
        });
        $this->assertEquals(new Collection([9, 8, 7, 6, 5, 4, 3, 2, 1]), $collection);
    }

    /**
     * @test
     */
    public function shuffle(): void
    {
        $this->collection = new Collection(new Collection([9, 8, 7, 6, 5, 4, 3, 2, 1]));

        $collection = $this->collection->shuffle();
        $this->assertNotEquals(new Collection([9, 8, 7, 6, 5, 4, 3, 2, 1]), $collection);
    }

    /**
     * @test
     */
    public function reverse(): void
    {
        $this->collection = new Collection(new Collection([9, 8, 7, 6, 5, 4, 3, 2, 'test' => 1]));

        $collection = $this->collection->reverse();
        $this->assertTrue(['test'=>1,7=>2,6=>3,5=>4,4=>5,3=>6,2=>7,1=>8,0=>9] === $collection->toArray());
    }

    /**
     * @test
     */
    public function prepend(): void
    {
        $this->collection->prepend('NONE');
        $this->assertEquals('NONE', $this->collection->pull());
        $this->assertEquals(5, $this->collection->count());
        $this->assertEquals($this->collection, $this->collection->push('value'));
        $this->assertEquals(6, $this->collection->count());
    }

    /**
     * @test
     */
    public function next(): void
    {
        foreach ($this->data as $key => $value) {
            static::assertTrue($this->collection->valid());
            static::assertEquals($key, $this->collection->key());
            static::assertEquals($value, $this->collection->current());
            static::assertEquals(5, $this->collection->count());
            $this->collection->next();
        }

        foreach ($this->collection as $key => $value) {
            static::assertEquals($this->data[$key], $value);
        }

        static::assertEquals('Marcos', $this->collection->rewind());
    }
}
