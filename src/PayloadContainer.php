<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/payload-container
 * @link https://github.com/Koudela/eArc-payload-container/
 * @copyright Copyright (c) 2018 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\PayloadContainer;

use eArc\PayloadContainer\Exceptions\ItemNotFoundException;
use eArc\PayloadContainer\Exceptions\ItemOverwriteException;
use Psr\Container\ContainerInterface;

/**
 * Defines a psr compatible payload container.
 */
class PayloadContainer implements ContainerInterface
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
     * Get the complete payload from the container.
     */
    public function getItems(): ItemsInterface
    {
        return $this->items;
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
     * Remove a specific item.
     *
     * @param string $name
     */
    public function remove(string $name): void
    {
        $this->items->remove($name);
    }

    /**
     * Remove the old payload from the container.
     *
     * @param ItemsInterface|null $items
     */
    public function reset(ItemsInterface $items = null): void
    {
        $this->items = $items ?? new Items();
    }
}
