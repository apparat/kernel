<?php

/**
 * apparat-kernel
 *
 * @category    Apparat
 * @package     Apparat\Kernel
 * @subpackage  Apparat\Kernel\Front
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

namespace Apparat\Kernel\Front;

use Apparat\Kernel\Domain\Contract\DependencyInjectionContainerInterface;
use Apparat\Kernel\Framework\Factory\DependencyInjectionContainerFactory;

/**
 * Kernel front
 *
 * @package Apparat\Kernel
 * @subpackage Apparat\Kernel\Front
 */
class Kernel
{
	/**
	 * Dependency injection container
	 *
	 * @var DependencyInjectionContainerInterface
	 */
	protected static $_dependencyInjectionContainer = null;
	/**
	 * Registered module namespaces
	 *
	 * @var array
	 */
	protected static $_moduleNamespaces = [];

	/*******************************************************************************
	 * PUBLIC METHODS
	 *******************************************************************************/

	/**
	 * Bootstrap the kernel
	 */
	public static function bootstrap()
	{
		// Instantiate the dependency injection container
		self::$_dependencyInjectionContainer = DependencyInjectionContainerFactory::create(getenv('APP_DIC'));
	}

	/**
	 * Register a kernel module
	 *
	 * @param string $moduleNamespace Module namespace
	 */
	public static function register($moduleNamespace)
	{
		$moduleNamespace = trim($moduleNamespace, '\\');
		self::$_moduleNamespaces[] = $moduleNamespace;

		self::$_dependencyInjectionContainer->configure($moduleNamespace);
	}

	/*******************************************************************************
	 * PRIVATE METHODS
	 *******************************************************************************/
}