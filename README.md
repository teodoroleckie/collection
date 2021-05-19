# Simple and powerful library for collections in PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tleckie/collection.svg?style=flat-square)](https://packagist.org/packages/tleckie/collection)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/teodoroleckie/collection/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/teodoroleckie/collection/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/teodoroleckie/collection/badges/build.png?b=main)](https://scrutinizer-ci.com/g/teodoroleckie/collection/build-status/main)
[![Total Downloads](https://img.shields.io/packagist/dt/tleckie/collection.svg?style=flat-square)](https://packagist.org/packages/tleckie/collection)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/teodoroleckie/collection/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)

### Installation

You can install the package via composer:

```bash
composer require tleckie/collection
```

## Usage

# Hash
Hash collections should be used when you need the keys to be strings.
```php
<?php

use Tleckie\Collection\Hash;

// Create your own collection type
class UserCollection extends Hash {}

$users = [
    'user1' => new User('John'),
    'user2' => new User('Pedro'),
    'user3' => new User('Mario'),
    'user4' => new User('Walter'),
    'user5' => new User('Mario')
];

$userCollection = new UserCollection($users);

/**
 * @param Hash $userCollection
 */
public function addCollection(Hash $userCollection){ ... }

/**
 * @param UserCollection $userCollection
 */
public function addCollection(UserCollection $userCollection){ ... }

```

```php
use Tleckie\Collection\Hash;

$collection = new Hash(['key' => 'value']);
$collection->append('otherKey', 'other value');
```

# Hash methods:

```php
public function current(): mixed;

public function next(): void;

public function key(): null|string;

public function valid(): bool;

public function rewind(): void;

public function count(): int;

public function sortByKey(): HashInterface;

public function sortByValue(): HashInterface;

public function sort(callable$callable): HashInterface;

public function reverse(): HashInterface;

public function filter(callable $filterFunction): HashInterface;

public function find(callable $findFunction): HashInterface;

public function empty(): HashInterface;

public function hasKey(string $key): bool;

public function hasValue(mixed $item): bool;

public function get(string $key): mixed;

public function append(string $key, mixed $item): HashInterface;

public function prepend(string $key, mixed $item): HashInterface;

public function remove(string $key): HashInterface;

public function shuffle(): HashInterface;

public function toArray(): array;
```

# Sequence:
The sequences are used when the key of the collection is not important besides being ordered. Many of its methods are immutable.

If you want you can create your own type of collection

```php
<?php

use Tleckie\Collection\Sequence;

// Create your own collection type
class UserCollection extends Sequence {}

$users = [
    new User('John'),
    new User( 'Pedro'),
    new User('Mario'),
    new User('Walter'),
    new User('Mario')
];

$userCollection = new UserCollection($users);

/**
 * @param Sequence $userCollection
 */
public function addCollection(Sequence $userCollection){ ... }

/**
 * @param UserCollection $userCollection
 */
public function addCollection(UserCollection $userCollection){ ... }
```

```php
use Tleckie\Collection\Sequence;

$collection = new Sequence(['value', 'value2']);
$collection->append('other value');

```
# Sequence methods:
```php
public function current(): mixed;

public function next(): void;

public function key(): null|int;

public function valid(): bool;

public function rewind(): void;

public function count(): int;

public function sortByKey(): SequenceInterface;

public function sortByValue(): SequenceInterface;

public function sort(callable$callable): SequenceInterface;

public function reverse(): SequenceInterface;

public function filter(callable $filterFunction): SequenceInterface;

public function find(callable $findFunction): SequenceInterface;

public function empty(): SequenceInterface;

public function hasKey(int $index): bool;

public function hasValue(mixed $item): bool;

public function get(int $index): mixed;

public function append(mixed $item): SequenceInterface;

public function prepend(mixed $item): SequenceInterface;

public function remove(int $index): SequenceInterface;

public function shuffle(): SequenceInterface;

public function toArray(): array;

```

# Collection:
Use the collection when you have numeric and string keys.

```php
<?php

use Tleckie\Collection\Collection;

// Create your own collection type
class UserCollection extends Collection {}

$users = [
    new User(1, 'John'),
    new User(2, 'Pedro'),
    new User(3, 'Mario'),
    new User(4, 'Walter'),
    new User(5, 'Mario')
];

$collection = new UserCollection($users);



// iterate
foreach($collection as $user){
    $user->name();
}


// count elements
$collection->count();   //5
count($collection);     //5


// filter
$collection = $collection->filter(function (int $key, User $user) {
    return $user->id() > 4;
}); // UserCollection( [ User(5) ] );


// filterNot
$collection = $collection->filterNot(function (int $key, User $user) {
    return $user->id() > 4;
}); // UserCollection( [ User(1),User(2),User(3),User(4) ] );


// find
$collection = $collection->find(function (int $key, User $user) {
    return $user->name() === 'Mario';
}); // UserCollection( [ User(3), User(5) ] );


// findIndex
$collection = $collection->find(function (int $key, User $user) {
    return $key === 1;
}); // UserCollection( [ User(2) ] );


// sort
$collection = $collection->sort(function (User $current, User $next) {
    if ($current->id() === $next->id()) {
        return 0;
    }
    return ($current->id() > $next->id()) ? -1 : 1;
}); // UserCollection( [ User(5), User(4), User(3), User(2), User(1) ] );
```

## Other methods:

```php
$collection->shuffle(): CollectionInterface;

$collection->reverse(): CollectionInterface;

$collection->prepend(mixed $item): CollectionInterface;

$collection->append(mixed $item): CollectionInterface;

$collection->toArray(): array;

$collection->push(mixed $item): CollectionInterface;

$collection->pull(): mixed;


```