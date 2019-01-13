<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/payload-container
 * @link https://github.com/Koudela/eArc-payload-container/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\PayloadContainer\Interfaces;

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
    public function reset(ItemsInterface $items = null): ItemsInterface;
}
