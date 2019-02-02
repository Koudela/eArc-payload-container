# earc/payload-container

Basic [psr-11](https://www.php-fig.org/psr/psr-11/) compatible container carrier
blueprint.

This eArc component is brought to you as a standalone component mainly for 
reusage reasons. There is nothing special or ground breaking to it. In nearly
every project of medium complexity you need a container carrier class. There is 
no point in reinventing the wheel again and again. It combines the functionality 
of [earc/container](https://github.com/Koudela/eArc-container/) and
[earc/payload](https://github.com/Koudela/eArc-payload/). Have fun...

## table of contents
 
 - [installation](#installation)
 - [basic usage](#basic-usage)
 - [exceptions](#exceptions)
 - [advanced usage](#advanced-usage)
 - [releases](#releases)

## installation

```
$ composer install earc/container
```

## basic usage

```php
use eArc\PayloadContainer\PayloadContainer;

new PayloadContainer();
```

The payload container carries one object implementing the `ItemsInterface`.
The `PayloadContainerInterface` extends the `ItemsInterface` thus all things you 
can do with the [earc/container](https://github.com/Koudela/eArc-container/) can 
be done with the payload container, too. In fact it forwards all the 
`ItemsInterface` calls to the items object.

For details refer to the 
[PayloadContainerInterface](https://github.com/Koudela/eArc-payload-container/blob/master/src/Interfaces/PayloadContainerInterface.php)
and the
[ItemsInterface](https://github.com/Koudela/eArc-container/blob/master/src/Interfaces/ItemsInterface.php)
or the
[Implementation](https://github.com/Koudela/eArc-payload-container/blob/master/src/PayloadContainer.php).

## exceptions

Please refer to the 
[earc/container documentation](https://github.com/Koudela/eArc-container/) for
details.

## advanced usage

Implement the `ItemInterface` or the `PayloadContainerInterface` for yourself.
eArc encourages the use of interfaces. In all eArc components using the 
[earc/components-di](https://github.com/Koudela/eArc-component-di) component 
for dependency injection you can replace the classes used for the interfaces as 
easy as writing your own name. Yes, even in the earc component itself.

## releases

### release v0.0

The first official release.
