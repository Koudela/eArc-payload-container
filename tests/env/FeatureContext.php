<?php
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/payload-container
 * @link https://github.com/Koudela/eArc-payload-container/
 * @copyright Copyright (c) 2018-2019 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\PayloadContainerTests\env;

use Behat\Behat\Context\Context;
use eArc\PayloadContainer\Exceptions\ItemNotFoundException;
use eArc\PayloadContainer\Interfaces\ItemsInterface;
use eArc\PayloadContainer\Interfaces\PayloadContainerInterface;
use eArc\PayloadContainer\Items;
use eArc\PayloadContainer\PayloadContainer;

require_once __DIR__ . '/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

function assertException(string $exceptionClass, \Closure $closure) {

    try {
        $closure();
    } catch (\Exception $exception) {
        if ($exception instanceof $exceptionClass) {
            return;
        }
    }

    throw new \RuntimeException("$exceptionClass was not thrown.");
}

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /** @var ItemsInterface */
    protected $items;

    /** @var PayloadContainerInterface */
    protected $payloadContainer;

    /**
     * @Given an items object is defined
     */
    public function anItemsObjectIsDefined()
    {
        $this->items = new Items();
    }

    /**
     * @Given a payload container is defined
     */
    public function aPayloadContainerIsDefined()
    {
        $this->payloadContainer = new PayloadContainer();
    }

    /**
     * @Given item :name has value :value
     *
     * @param string $name
     * @param string $value
     */
    public function itemHasValue(string $name, string $value)
    {
        $value = $this->mapValue($value);
        $this->items->overwrite($name, $value);
    }

    /**
     * @Then iteration over items has :count steps
     *
     * @param string $count
     */
    public function iterationOverItemsHasSteps(string $count)
    {
        $cnt = 0;

        /** @noinspection PhpUnusedLocalVariableInspection */
        foreach ($this->items as $item) {
            $cnt++;
        }

        assertSame(intval($count), $cnt);
    }

    /** 
     * @Then items has :name returns false
     *
     * @param string $name
     */
    public function itemsHasReturnsFalse(string $name)
    {
        assertFalse($this->items->has($name));
    }

    /**
     * @Then items get :name throws an ItemNotFoundException
     *
     * @param string $name
     */
    public function itemsGetThrowsAnItemNotFoundException(string $name)
    {
        assertException(ItemNotFoundException::class, function() use ($name) {
            $this->items->get($name);
        });
    }

    /**
     * @Then items get :name returns :value
     *
     * @param string $name
     * @param string $value
     */
    public function itemsGetReturns(string $name, string $value)
    {
        $value = $this->mapValue($value);
        assertSame($value, $this->items->get($name));
    }

    /**
     * @Then items call :name throws an ItemNotFoundException
     *
     * @param string $name
     */
    public function itemsCallThrowsAnItemNotFoundException(string $name)
    {
        assertException(ItemNotFoundException::class, function() use ($name) {
            $this->items->call($name);
        });
    }

    /**
     * @Given items set :name :value does not throw an exception
     *
     * @param string $name
     * @param string $value
     */
    public function itemsSetDoesNotThrowAnException(string $name, string $value)
    {
        $value = $this->mapValue($value);
        $this->items->set($name, $value);
    }

    /**
     * @Given items overwrite :name :value returns null
     *
     * @param string $name
     * @param string $value
     */
    public function itemsOverwriteReturnsNull(string $name, string $value)
    {
        $value = $this->mapValue($value);
        assertNull($this->items->overwrite($name, $value));
    }

    /**
     * @Given items remove :name does not throw an exception
     *
     * @param string $name
     */
    public function itemRemoveDoesNotThrowAnException(string $name)
    {
        $this->items->remove($name);
    }

    protected function mapValue(string $value)
    {
        if ('null' === $value) {
            return null;
        }

        if ('false' === $value) {
            return false;
        }

        if ('true' === $value) {
            return true;
        }

        return $value;
    }

}
