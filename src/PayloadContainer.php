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

namespace eArc\PayloadContainer;

use eArc\Container\Interfaces\ItemsInterface;
use eArc\PayloadContainer\Interfaces\PayloadContainerInterface;
use eArc\PayloadContainer\Traits\PayloadContainerTrait;

/**
 * Defines a psr-11 compatible payload container.
 */
class PayloadContainer implements PayloadContainerInterface
{
    use PayloadContainerTrait;
    /**
     * @param ItemsInterface|null $items
     */
    public function __construct(ItemsInterface $items = null)
    {
        $this->initPayloadContainerTrait($items);
    }
}
