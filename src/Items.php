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
     * @inheritdoc
     */
    public function has(string $name): bool
    {
        return isset($this->items[$name]);
    }

    /**
     * @inheritdoc
     */
    public function get(string $name)
    {
        if (!isset($this->items[$name])) {
            throw new ItemNotFoundException(
                'Item `%s` does not exist.',
                $name
            );
        }

        return $this->items[$name];
    }

    /**
     * @inheritdoc
     */
    public function call(string $name, array $arguments = [])
    {
        if (!isset($this->items[$name])) {
            throw new ItemNotFoundException(
                'Item `%s` does not exist.',
                $name
            );
        }

        if (!$this->items[$name] instanceof \Closure) {
            throw new ItemNotCallableException(
                'Item value has to be of type Closure, but was of type `%s`.',
                get_class($this->items[$name])
            );
        }

        return ($this->items[$name])(...$arguments);
    }

    /**
     * @inheritdoc
     */
    public function set(string $name, $item): void
    {
        if (isset($this->items[$name])) {
            throw new ItemOverwriteException(sprintf(
                'Item name `%s` is already used.',
                $name
            ));
        }

        $this->items[$name] = $item;
    }

    /**
     * @inheritdoc
     */
    public function overwrite(string $name, $item)
    {
        $oldItem = $this->items[$name] ?? null;
        $this->items[$name] = $item;

        return $oldItem;
    }

    /**
     * @inheritdoc
     */
    public function remove(string $name): void
    {
        unset($this->items[$name]);
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        foreach ($this->items as $name => $item) {
            yield $name => $item;
        }
    }
}
