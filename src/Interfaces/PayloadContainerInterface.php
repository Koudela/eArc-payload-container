<?php declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 * psr-11 compatible container carrier blueprint
 *
 * @package earc/payload-container
 * @link https://github.com/Koudela/eArc-payload-container/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\PayloadContainer\Interfaces;

use eArc\Container\Interfaces\ItemsInterface;

/**
 * Payload container interface.
 */
interface PayloadContainerInterface extends ItemsInterface
{
    /**
     * Get the complete payload from the container.
     */
    public function getItems(): ItemsInterface;

    /**
     * Remove the old payload from the container or replace it. Returns the old
     * payload.
     *
     * @param ItemsInterface|null $items
     *
     * @return ItemsInterface
     */
    public function resetItems(ItemsInterface $items = null): ItemsInterface;
}
