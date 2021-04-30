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

### Usage

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

### Other methods:

```php
$collection->shuffle(): CollectionInterface;

$collection->reverse(): CollectionInterface;

$collection->prepend(mixed $item): CollectionInterface;

$collection->toArray(): array;

$collection->push(mixed $item): CollectionInterface;

$collection->pull(): mixed;


```