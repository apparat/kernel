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

use Apparat\Kernel\Common\RuntimeException;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogHandler;
use Monolog\Logger;

/**
 * Abstract logger
 *
 * @package Apparat\Kernel
 * @subpackage Apparat\Kernel\Infrastructure
 */
abstract class AbstractLogger extends Logger
{
	/**
	 * Logger constructor
	 *
	 * @param string $name The logging channel
	 * @throws RuntimeException If the log handler is unsupported
	 */
	public function __construct($name)
	{
		$handlers = [];
		list($handler, $config) = array_pad(explode(':', getenv('APP_LOG'), 2), 2, '');

		// Instantiate the configured logger
		switch ($handler) {

			// Syslog handler
			case 'syslog':
				$arguments = strlen($config) ? explode('|', $config) : [];
				$handlers[] = new SyslogHandler(...$arguments);
				break;

			// ErrorLog handler
			case 'errorlog':
				$arguments = strlen($config) ? explode('|', $config) : [];
				$handlers[] = new ErrorLogHandler(...$arguments);
				break;

			// Stream handler
			case 'stream':
				$arguments = strlen($config) ? explode('|', $config) : [];
				$handlers[] = new StreamHandler(...$arguments);
				break;

			// Null handler
			case 'null':
				$arguments = strlen($config) ? explode('|', $config) : [];
				$handlers[] = new NullHandler(...$arguments);
				break;

			// Unsupported handler
			default:
				throw new RuntimeException(sprintf('Unsupported log handler "%s"', $handler),
					RuntimeException::UNSUPPORTED_LOG_HANDLER);
				break;
		}

		parent::__construct($name, $handlers);
	}
}