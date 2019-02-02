<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * psr-11 compatible container carrier
 *
 * @package earc/payload-container
 * @link https://github.com/Koudela/eArc-payload-container/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\PayloadContainer;

use eArc\Container\Exceptions\ItemNotFoundException;
use eArc\Container\Exceptions\ItemOverwriteException;
use eArc\Container\Exceptions\ItemNotCallableException;
use eArc\Container\Interfaces\ItemsInterface;
use eArc\Container\Items;
use eArc\PayloadContainer\Interfaces\PayloadContainerInterface;
use Psr\Container\ContainerInterface;
use Throwable;

/**
 * Defines a psr-11 compatible payload container.
 */
class PayloadContainer implements ContainerInterface, PayloadContainerInterface
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
     * Check whether a specific item exists.
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
     * Call a specific item.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     *
     * @throws ItemNotFoundException
     * @throws ItemNotCallableException
     */
    public function call(string $name, array $arguments = [])
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
     * @inheritdoc
     */
    public function getItems(): ItemsInterface
    {
        return $this->items;
    }

    /**
     * @inheritdoc
     */
    public function resetItems(ItemsInterface $items = null): ItemsInterface
    {
        $oldItems = $this->items;

        $this->items = $items ?? $this->getNewItemsInstance();

        return $oldItems;
    }

    /**
     * Get a new items instance.
     *
     * @return mixed
     */
    protected function getNewItemsInstance()
    {
        $class = get_class($this->items);

        try {
            return new $class();
        } catch (Throwable $e) {
            return clone $this->items;
        }
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return $this->items->getIterator();
    }
}
