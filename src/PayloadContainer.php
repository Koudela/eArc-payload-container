<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/payload-container
 * @link https://github.com/Koudela/eArc-payload-container/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\PayloadContainer;

use eArc\PayloadContainer\Exceptions\ItemNotFoundException;
use eArc\PayloadContainer\Exceptions\ItemOverwriteException;
use eArc\PayloadContainer\Exceptions\ItemNotCallableException;
use eArc\PayloadContainer\Interfaces\ItemsInterface;
use eArc\PayloadContainer\Interfaces\PayloadContainerInterface;
use Psr\Container\ContainerInterface;

/**
 * Defines a psr compatible payload container.
 */
class PayloadContainer implements ContainerInterface, PayloadContainerInterface, \IteratorAggregate
{
    /** @var ItemsInterface */
    protected $items;

    /**
     * @param ItemsInterface|null $items
     */
    public function __construct(ItemsInterface $items = null)
    {
        $this->items = $items ?? new Items();
    }

    /**
     * Checks whether a specific item exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name): bool
    {
        return $this->items->has($name);
    }

    /**
     * Get a specific item from the container.
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws ItemNotFoundException
     */
    public function get($name)
    {
        return $this->items->get($name);
    }

    /**
     * Calls a specific closure item.
     *
     * @param string $name
     * @param $arguments
     *
     * @return mixed
     *
     * @throws ItemNotFoundException
     * @throws ItemNotCallableException
     */
    public function call(string $name, $arguments)
    {
        return $this->items->call($name, $arguments);
    }

    /**
     * Add a specific item to the container.
     *
     * @param string $name
     * @param mixed  $item
     *
     * @throws ItemOverwriteException
     */
    public function set(string $name, $item): void
    {
        $this->items->set($name, $item);
    }

    /**
     * Overwrite a specific item of the container. Returns the old item.
     *
     * @param string $name
     * @param $item
     *
     * @return mixed
     */
    public function overwrite(string $name, $item)
    {
        return $this->items->overwrite($name, $item);
    }

    /**
     * Remove a specific item.
     *
     * @param string $name
     */
    public function remove(string $name): void
    {
        $this->items->remove($name);
    }

    /**
     * Get the complete payload from the container.
     */
    public function getItems(): ItemsInterface
    {
        return $this->items;
    }

    /**
     * Remove the old payload from the container or replace it. Returns the old
     * payload.
     *
     * @param ItemsInterface|null $items
     *
     * @return ItemsInterface
     */
    public function reset(ItemsInterface $items = null): ItemsInterface
    {
        $oldItems = $this->items;
        $class = get_class($oldItems);
        $this->items = $items ?? new $class();

        return $oldItems;
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return $this->items->getIterator();
    }
}
