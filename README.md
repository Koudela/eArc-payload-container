# earc/payload-container

Basic item container and a [psr-11](https://www.php-fig.org/psr/psr-11/) 
compatible item container carrier.

This eArc component is brought to you as a standalone component mainly for 
reusage reasons. There is nothing special or ground breaking to it. In nearly
every project of medium complexity you need a bag or carrier class. There is no
point in reinventing the wheel again and again. Just use the 
earc/payload-container or parts of it.

## table of contents
 
 - [installation](#installation)
 - [basic usage item container](#basic-usage-item-container)
 - [basic usage payload container](#basic-usage-payload-container)
 - [exceptions](#exceptions)
 - [advanced usage](#advanced-usage)
 - [releases](#releases)

## installation

```
$ composer install earc/di
```

## basic usage item container

```php
use eArc\PayloadContainer\Items;
use eArc\PayloadContainer\Exceptions\

$itemBag = new Items();

$name = 'some string as key';

if (!$itemBag->has($name)) {
    $item->set($name, 'all kinds of types can be used as value');
}

$itemBag->set('my callable', function () {
    echo 'Hello World';
});

$itemBag->call('my callable');

$itemBag->set('fun with closures', function ($salutation, $name) use ($itemBag) {
    echo $salutation . ' ' . $itemBag->call($name);
}

$itemBag->set('our planet', 'World');

$itemBag->call('fun with closures', ['Hello', 'our planet']);

try {
    $itemBag->set('our planet', 'blue world');
} catch (ItemOverwriteException $e) {
    $itemBag->overwrite('our planet', 'blue world');
} finally {
    $itemBag->remove('our planet');
    $itemBag->set('our planet', 'the last will be the first');
}

foreach($itemBag as $name => $item) {
    $itemBag->remove($name);
}
```

For details refer to the 
[ItemsInterface](https://github.com/Koudela/eArc-payload-container/blob/master/src/Interfaces/ItemsInterface.php) 
or its implementation.

## basic usage payload container

The payload container carries one items object. The `PayloadContainerInterface` 
extends the `ItemsInterface` thus all things you can do with the
items container can be done with the payload container, too. In fact it forwards
the calls to the items object.

```php
use eArc\PayloadContainer\PayloadContainer;

$carrier = new PayloadContainer();

$carrier->set('Say hello!', 'Why should I?');

// is equivalent to

$carrier->getItems->set('Say hello!', 'Why should I?');

// and 

foreach ($carrier as $name => $item) { ... }

// is equivalent to

foreach ($carrier->getItems as $name => item) { ... }
```

The carrier can also use a new bag.

```php
$carrier->reset();
```

Or replace it.

```php
$items = $producer->getItems();

$oldItems = $carrier->reset($items)

// ... thousands of executed lines later ...

$consumer->getItems($carrier->getItems());
```

For details refer to the 
[PayloadContainerInterface](https://github.com/Koudela/eArc-payload-container/blob/master/src/Interfaces/PayloadContainerInterface.php) 
or its implementation.

## exceptions

 * An `ItemNotCallableException` is thrown if an item is called that is no 
 instance of Closure.

 * An `ItemNotFoundException` is thrown if you get or call an item that does not 
 exist.

 * An `ItemOverwriteException` is thrown if an item is set, but its name exists 
 already. `overwrite` does not trigger this exception. 
 
 * All three exceptions inherit from the `ItemException`.

## advanced usage

Implement the `ItemInterface` or the `PayloadContainerInterface` on your own.
eArc encourages the use of interfaces. In all eArc components using the 
[earc/components-di](https://github.com/Koudela/eArc-component-di) component 
for dependency injection you can replace the classes used for the interfaces as 
easy as writing your own name. Yes, even in the earc component itself.

## releases

### release v0.0 (BETA)

The first official release will be released soon.
