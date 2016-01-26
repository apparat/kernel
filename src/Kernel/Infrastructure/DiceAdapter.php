<?php

/**
 * apparat-kernel
 *
 * @category    Apparat
 * @package     Apparat\Kernel
 * @subpackage  Apparat\Kernel\<Layer>
 * @author      Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @copyright   Copyright © 2016 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @license     http://opensource.org/licenses/MIT	The MIT License (MIT)
 */

/***********************************************************************************
 *  The MIT License (MIT)
 *
 *  Copyright © 2016 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy of
 *  this software and associated documentation files (the "Software"), to deal in
 *  the Software without restriction, including without limitation the rights to
 *  use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 *  the Software, and to permit persons to whom the Software is furnished to do so,
 *  subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 *  FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 *  COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 *  IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 *  CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 ***********************************************************************************/

namespace Apparat\Kernel\Infrastructure;

use Apparat\Kernel\Domain\Contract\DependencyInjectionContainerInterface;
use Apparat\Kernel\Domain\Contract\ModuleInterface;
use Dice\Dice;

/**
 * Adapter for the Dice Dependency Injection container
 *
 * @package Apparat\Kernel
 * @subpackage Apparat\Kernel\Infrastructure
 */
class DiceAdapter implements DependencyInjectionContainerInterface
{
    /**
     * Dice instance
     *
     * @var Dice
     */
    protected $_dice = null;

    /**
     * Dice adapter constructor
     */
    public function __construct()
    {
        $this->_dice = new Dice();
    }

    /**
     * Apply a module specific dependency injection configuration
     *
     * @param ModuleInterface $module Module
     */
    public function configure(ModuleInterface $module)
    {
        $module->configureDependencyInjection($this);
    }

    /**
     * Create an object instance
     *
     * @param string $name Object class name
     * @param array $args Object constructor arguments
     * @return object Object instance
     */
    public function create($name, array $args = [])
    {
        return $this->_dice->create($name, $args);
    }
}