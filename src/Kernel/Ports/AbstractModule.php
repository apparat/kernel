<?php

/**
 * apparat-kernel
 *
 * @category    Apparat
 * @package     Apparat\Kernel
 * @subpackage  Apparat\Kernel\Ports
 * @author      Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @copyright   Copyright © 2016 Joschi Kuphal <joschi@kuphal.net> / @jkphl
 * @license     http://opensource.org/licenses/MIT The MIT License (MIT)
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

use Apparat\Kernel\Ports\Contract\ModuleInterface;
use Apparat\Kernel\Ports\Contract\DependencyInjectionContainerInterface;
use Dotenv\Dotenv;

/**
 * Abstract base module
 *
 * @package Apparat\Kernel
 * @subpackage Apparat\Kernel\Ports
 */
abstract class AbstractModule implements ModuleInterface
{
    /**
     * Module name
     *
     * @var string
     */
    const NAME = 'abstract';

    /*******************************************************************************
     * PUBLIC METHODS
     *******************************************************************************/

    /**
     * Configure the dependency injection container
     *
     * @param DependencyInjectionContainerInterface $diContainer Dependency injection container
     * @return void
     */
    public function configureDependencyInjection(DependencyInjectionContainerInterface $diContainer)
    {
        // Overwrite in module implementations
    }

    /**
     * Return the module name
     *
     * @return string Module name
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * Auto-run
     *
     * @return void
     */
    public static function autorun()
    {
        // Validate the environment
        $reflectionClass = new \ReflectionClass(static::class);
        static::validateEnvironment(static::environment(dirname($reflectionClass->getFileName())));

        // Register the module
        Kernel::register(new static);
    }

    /*******************************************************************************
     * PRIVATE METHODS
     *******************************************************************************/

    /**
     * Instantiate the environment
     *
     * @param string $directory Directory with .env file
     * @return Dotenv Environment instance
     */
    protected static function environment($directory)
    {
        // Find a valid environment file
        $envDirectory = $directory;
        while (!@is_file($envDirectory.DIRECTORY_SEPARATOR.'.env')) {
            $upEnvDirectory = dirname($envDirectory);
            if (!strlen($upEnvDirectory) || ($upEnvDirectory == $envDirectory)) {
                $envDirectory = null;
                break;
            }
            $envDirectory = $upEnvDirectory;
        }

        // Instantiate the environment abstraction
        $dotenv = new Dotenv($envDirectory ?: $directory);
        if ($envDirectory && (getenv('APP_ENV') === 'development')) {
            $dotenv->load();
        }

        return $dotenv;
    }

    /**
     * Validate the environment
     *
     * @param Dotenv $environment Environment
     */
    protected static function validateEnvironment(Dotenv $environment)
    {
        // Overwrite in module implementations
    }
}
