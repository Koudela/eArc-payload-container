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
use eArc\PayloadContainer\Exceptions\PayloadOverwriteException;
use Psr\Container\ContainerInterface;

/**
 * Defines a psr compatible payload container.
 */
class PayloadContainer implements ContainerInterface
{
    /** @var Items */
    protected $items;

    /**
     * @param Items|null $items
     */
    public function __construct(Items $items = null)
    {
        $this->items = $items ?? new Items();
    }

    /**
     * Add a specific item to the container.
     *
     * @param string $name
     * @param mixed  $item
     * @param bool   $overwrite
     */
    public function set(string $name, $item, $overwrite = false): void
    {
        if (!$overwrite && $this->items->has($name)) {
            throw new PayloadOverwriteException("Item name `$name` is already used.");
        }

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
        if (!$this->items->has($name)) {
            throw new ItemNotFoundException();
        }

        return $this->items->get($name);
    }

    /**
     * Get the complete payload from the container.
     */
    public function getItems(): Items
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
     */
    public function reset(): void
    {
        $this->items = new Items();
    }
}
