<?php

/**
 * apparat-object
 *
 * @category    Apparat
 * @package     Apparat\Object
 * @subpackage  Apparat\Object\Infrastructure
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

/**
 * Basic tests for generic files
 *
 * @package     Apparat\Object
 * @subpackage  Apparat\Object\Infrastructure
 */
abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Temporary FILES
	 *
	 * @var array
	 */
	protected $_tmpFiles = array();

	/**
	 * Tears down the fixture
	 */
	protected function tearDown()
	{
		foreach ($this->_tmpFiles as $tmpFile) {
			@is_file($tmpFile) ? @unlink($tmpFile) : @rmdir($tmpFile);
		}
	}

	/**
	 * Prepare and register a temporary file
	 *
	 * @return string Temporary file name
	 */
	protected function _createTemporaryFile()
	{
		return $this->_tmpFiles[] = tempnam(sys_get_temp_dir(), 'apparat_test_');
	}

	/**
	 * Prepare and register a temporary file name
	 *
	 * @return string Temporary file name
	 */
	protected function _createTemporaryFileName()
	{
		$tempFileName = $this->_createTemporaryFile();
		@unlink($tempFileName);
		return $tempFileName;
	}

	/**
	 * Tests if two arrays equal in their keys and values
	 *
	 * @param array $expected Expected result
	 * @param array $actual Actual result
	 * @param string $message Message
	 */
	public function assertArrayEquals(array $expected, array $actual, $message = '')
	{
		$this->assertEquals($this->_sortArrayForComparison($expected), $this->_sortArrayForComparison($actual),
			$message);
	}

	/*******************************************************************************
	 * PRIVATE METHODS
	 *******************************************************************************/

	/**
	 * Recursively sort an array for comparison with another array
	 *
	 * @param array $array Array
	 * @return array                Sorted array
	 */
	protected function _sortArrayForComparison(array $array)
	{

		// Tests if all array keys are numeric
		$allNumeric = true;
		foreach (array_keys($array) as $key) {
			if (!is_numeric($key)) {
				$allNumeric = false;
				break;
			}
		}

		// If not all keys are numeric: Sort the array by key
		if (!$allNumeric) {
			ksort($array, SORT_STRING);
			return $this->_sortArrayRecursive($array);
		}

		// Sort them by data type and value
		$array = $this->_sortArrayRecursive($array);
		usort($array, function ($first, $second) {
			$aType = gettype($first);
			$bType = gettype($second);
			if ($aType === $bType) {
				switch ($aType) {
					case 'array':
						return strcmp(implode('', array_keys($first)), implode('', array_keys($second)));
						break;
					case 'object':
						return strcmp(spl_object_hash($first), spl_object_hash($second));
						break;
					default:
						return strcmp(strval($first), strval($second));
						break;
				}
			}

			return strcmp($aType, $bType);
		});

		return $array;
	}

	/**
	 * Recursively sort an array for comparison
	 *
	 * @param array $array Original array
	 * @return array Sorted array
	 */
	protected function _sortArrayRecursive(array $array) {

		// Run through all elements and sort them recursively if they are an array
		reset($array);
		while (list($key, $value) = each($array)) {
			if (is_array($value)) {
				$array[$key] = $this->_sortArrayForComparison($value);
			}
		}

		return $array;
	}

	/**
	 * Normalize HTML contents
	 *
	 * @param string $html Original HTML
	 * @return string Normalized HTML
	 */
	protected function _normalizeHtml($html)
	{
		$htmlDom = new \DOMDocument();
		$htmlDom->preserveWhiteSpace = false;
		$htmlDom->formatOutput = false;
		$htmlDom->loadXML("<html><head><title>apparat</title></head><body>$html</body></html>");
		return $htmlDom->saveXML();
	}
}