<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 * psr-11 compatible container carrier blueprint
 *
 * @package earc/payload-container
 * @link https://github.com/Koudela/eArc-payload-container/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\PayloadContainer\Traits;

use eArc\Container\Exceptions\ItemNotCallableException;
use eArc\Container\Exceptions\ItemNotFoundException;
use eArc\Container\Exceptions\ItemOverwriteException;
use eArc\Container\Interfaces\ItemsInterface;
use eArc\Container\Items;
use Throwable;

/**
 * Generic payload container trait. Always use the payload container interface,
 * too.
 */
trait PayloadContainerTrait
{
    /** @var ItemsInterface */
    protected $payloadContainerItems;

    /**
     * @param ItemsInterface|null $items
     */
    protected function initPayloadContainerTrait(ItemsInterface $items = null)
    {
        $this->payloadContainerItems = $items ?? new Items();
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
        return $this->payloadContainerItems->has($name);
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
        return $this->payloadContainerItems->get($name);
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
        return $this->payloadContainerItems->call($name, $arguments);
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
        $this->payloadContainerItems->set($name, $item);
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
        return $this->payloadContainerItems->overwrite($name, $item);
    }

    /**
     * Remove a specific item.
     *
     * @param string $name
     */
    public function remove(string $name): void
    {
        $this->payloadContainerItems->remove($name);
    }

    /**
     * @inheritdoc
     */
    public function getItems(): ItemsInterface
    {
        return $this->payloadContainerItems;
    }

    /**
     * @inheritdoc
     */
    public function resetItems(ItemsInterface $items = null): ItemsInterface
    {
        $oldItems = $this->payloadContainerItems;

        $this->payloadContainerItems = $items ?? $this->getNewItemsInstance();

        return $oldItems;
    }

    /**
     * Get a new items instance.
     *
     * @return mixed
     */
    protected function getNewItemsInstance()
    {
        $class = get_class($this->payloadContainerItems);

        try {
            return new $class();
        } catch (Throwable $e) {
            return clone $this->payloadContainerItems;
        }
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return $this->payloadContainerItems->getIterator();
    }

}