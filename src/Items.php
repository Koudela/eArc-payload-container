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

/**
 * Basic item container.
 */
class Items
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
     * Set an item.
     *
     * @param string $name
     * @param mixed  $item
     */
    public function set(string $name, $item): void
    {
        if (isset($this->items[$name])) {
            $this->items[$name] = $item;
            throw new ItemOverwriteException("Item name `$name` is already used.");
        }

        $this->items[$name] = $item;
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
        if (!isset($this->items)) {
            throw new ItemNotFoundException();
        }

        return $this->items[$name];
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
