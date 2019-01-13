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
use eArc\PayloadContainer\Exceptions\NotCallableException;
use eArc\PayloadContainer\Interfaces\ItemsInterface;

/**
 * Basic item container.
 */
class Items implements ItemsInterface
{
    /** @var array */
    protected $items;

    /**
     * @param array|null $items
     */
    public function __construct(array $items = null)
    {
        $this->items = $items ?? [];
    }

    /**
     * Check whether an item exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->items[$name]);
    }

    /**
     * Get an item.
     *
     * @param string $name
     *
     * @return mixed
     *
     * @throws ItemNotFoundException
     */
    public function get(string $name)
    {
        if (!isset($this->items[$name])) {
            throw new ItemNotFoundException();
        }

        return $this->items[$name];
    }

    /**
     * Calls an closure item.
     *
     * @param string $name
     * @param $arguments
     *
     * @return mixed
     *
     * @throws ItemNotFoundException
     * @throws NotCallableException
     */
    public function call(string $name, $arguments)
    {
        if (!isset($this->items[$name])) {
            throw new ItemNotFoundException();
        }

        if (!$this->items[$name] instanceof \Closure) {
            throw new NotCallableException();
        }

        return ($this->items[$name])(...$arguments);
    }

    /**
     * Set an item.
     *
     * @param string $name
     * @param mixed  $item
     */
    public function set(string $name, $item): void
    {
        if (isset($this->items[$name])) {
            throw new ItemOverwriteException("Item name `$name` is already used.");
        }

        $this->items[$name] = $item;
    }

    /**
     * Overwrite an item. Returns the old item.
     *
     * @param string $name
     * @param $item
     *
     * @return mixed
     */
    public function overwrite(string $name, $item)
    {
        $oldItem = $this->items[$name] ?? null;
        $this->items[$name] = $item;

        return $oldItem;
    }

    /**
     * Removes an item.
     *
     * @param string $name
     */
    public function remove(string $name): void
    {
        unset($this->items[$name]);
    }
}
