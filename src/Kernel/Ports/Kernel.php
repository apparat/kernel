<?php

/**
 * apparat-kernel
 *
 * @category    Apparat
 * @package     Apparat\Kernel
 * @subpackage  Apparat\Kernel\Ports
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

namespace Apparat\Kernel\Ports;

use Apparat\Kernel\Domain\Contract\ModuleInterface;
use Apparat\Kernel\Infrastructure\DependencyInjection\DiceAdapter;
use Apparat\Kernel\Infrastructure\Log\Logger;

/**
 * Kernel facade
 *
 * @package Apparat\Kernel
 * @subpackage Apparat\Kernel\Ports
 */
class Kernel
{
	/**
	 * Kernel instance
	 *
	 * @var \Apparat\Kernel\Domain\Model\Kernel
	 */
	protected static $_kernel = null;

	/*******************************************************************************
	 * PUBLIC METHODS
	 *******************************************************************************/

	/**
	 * Register an apparat module
	 *
	 * @param ModuleInterface $module Apparat module
	 */
	public static function register(ModuleInterface $module)
	{
		self::_kernel()->register($module);
	}

	/**
	 * Create an object instance
	 *
	 * @param string $className Object class name
	 * @param array $args Object constructor arguments
	 * @return object Object instanceq
	 */
	public static function create($name, array $args = [])
	{
		return self::_kernel()->create($name, $args);
	}

	/*******************************************************************************
	 * PRIVATE METHODS
	 *******************************************************************************/

	/**
	 * Return the kernel instance
	 *
	 * @return \Apparat\Kernel\Domain\Model\Kernel Kernel instance
	 */
	protected static function _kernel()
	{
		if (self::$_kernel === null) {
			self::$_kernel = new \Apparat\Kernel\Domain\Model\Kernel(new DiceAdapter(), new Logger());
		}

		return self::$_kernel;
	}
}