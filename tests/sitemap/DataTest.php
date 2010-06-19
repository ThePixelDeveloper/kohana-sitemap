<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sitemap generation class
 *
 * Copyright (C) 2009 Mathew Leigh Davies
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * @author Mathew Leigh Davies <thepixeldeveloper@googlemail.com>
 */

/**
 * Tests Sitemap_Data
 *
 * @package Unittest
 * @author  Mathew Davies
 */
class Sitemap_DataTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @return array Test data for test_encode.
	 */
	public function provider_encode()
	{
		return array
		(
			array('http://example.com/<element>', 'http://example.com/&lt;element&gt;'),
			array('http://example.com/"something-weird"', 'http://example.com/&quot;something-weird&quot;'),
			array("http://example.com/'sample-url'", "http://example.com/&apos;sample-url&apos;"),
			array('http://example.com?param=one&param=two', 'http://example.com?param=one&amp;param=two'),
			array('http://example.com/ümlat.php&q=name', 'http://example.com/%C3%BCmlat.php&amp;q=name'),
			array('http://example.com/hello%encoding', 'http://example.com/hello%25encoding')
		);
	}
	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_encode
	 */
	public function test_encode($string, $expected)
	{
		$return = Sitemap::encode($string);
		$this->assertSame($expected, $return);
	}

	/**
	 * @return array Test data for test_date_format.
	 */
	public function provider_date_format()
	{
		date_default_timezone_set('Europe/London');
		
		return array
		(
			array(0, '1970-01-01T01:00:00+01:00'),
			array(1276912781, '2010-06-19T02:59:41+01:00'),
			array('invalid', FALSE),
			array(TRUE, FALSE)
		);
	}
	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_date_format
	 */
	public function test_date_format($date, $expected)
	{
		if ( ! $expected)
		{
			try
			{
				Sitemap::date_format($date);
			}
			catch (InvalidArgumentException $e)
			{
				return;
			}

			$this->fail('The InvalidArgumentException was not raised');
		}

		$return = Sitemap::date_format($date);
		$this->assertSame($expected, $return);
	}
}