<?php

/**
 * apparat-kernel
 *
 * @category    Apparat
 * @package     Apparat\Kernel
 * @subpackage  Apparat\Kernel\<Layer>
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

namespace Apparat\Kernel\Tests;

use Apparat\Kernel\Infrastructure\Logger;
use Apparat\Kernel\Module;
use Psr\Log\LogLevel;

/**
 * Kernel tests
 *
 * @package Apparat\Kernel
 * @subpackage Apparat\Kernel\Tests
 */
class KernelTest extends AbstractTest
{
    /**
     * Test the log-levels
     */
    public function testLogging()
    {
        Kernel::reset();

        Module::autorun();

        Kernel::emergency(LogLevel::EMERGENCY);
        Kernel::alert(LogLevel::ALERT);
        Kernel::critical(LogLevel::CRITICAL);
        Kernel::error(LogLevel::ERROR);
        Kernel::warning(LogLevel::WARNING);
        Kernel::notice(LogLevel::NOTICE);
        Kernel::info(LogLevel::INFO);
        Kernel::debug(LogLevel::DEBUG);
        Kernel::log(LogLevel::INFO, LogLevel::INFO);

        $this->assertInstanceOf(Logger::class, Kernel::create(Logger::class));
    }
}
