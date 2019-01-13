<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/payload-container
 * @link https://github.com/Koudela/eArc-payload-container/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\PayloadContainer\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Item is not attached to the payload container.
 */
class ItemNotFoundException extends ItemException implements NotFoundExceptionInterface
{
}
