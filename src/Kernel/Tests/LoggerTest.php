<?php

/**
 * apparat-kernel
 *
 * @category    Apparat
 * @package     Apparat\Kernel
 * @subpackage  Apparat\Kernel\Tests
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

namespace ApparatTest;

use Apparat\Kernel\Infrastructure\Logger;
use Apparat\Kernel\Module;

/**
 * Logger tests
 *
 * @package Apparat\Kernel
 * @subpackage ApparatTest
 */
class LoggerTest extends AbstractTest
{
	/**
	 * Test the syslog logger
	 */
	public function testSyslogLogger() {
		putenv('APP_LOG=syslog:test');
		$syslogLogger = new Logger('test');
		$this->assertInstanceOf(Logger::class, $syslogLogger);
		$this->assertEquals(Module::NAME, $syslogLogger->getName());
	}

	/**
	 * Test the errorlog logger
	 */
	public function testErrorlogLogger() {
		putenv('APP_LOG=errorlog');
		$errorlogLogger = new Logger('test');
		$this->assertInstanceOf(Logger::class, $errorlogLogger);
		$this->assertEquals(Module::NAME, $errorlogLogger->getName());
	}

	/**
	 * Test the stream logger
	 */
	public function testStreamLogger() {
		$logfile = $this->_createTemporaryFile();
		$randomLog = md5(microtime(true));
		putenv('APP_LOG=stream:file://'.$logfile);
		$streamLogger = new Logger('test');
		$streamLogger->info($randomLog);
		$this->assertInstanceOf(Logger::class, $streamLogger);
		$this->assertEquals(Module::NAME, $streamLogger->getName());
		$this->assertContains($randomLog, file_get_contents($logfile));
	}

	/**
	 * Test the null logger
	 */
	public function testNullLogger() {
		putenv('APP_LOG=null');
		$nullLogger = new Logger('test');
		$this->assertInstanceOf(Logger::class, $nullLogger);
		$this->assertEquals(Module::NAME, $nullLogger->getName());
	}

	/**
	 * Test invalid logger
	 *
	 * @expectedException \Apparat\Kernel\Common\RuntimeException
	 * @expectedExceptionCode 1453587845
	 */
	public function testInvalidLogger() {
		putenv('APP_LOG=invalid');
		new Logger('test');
	}
}