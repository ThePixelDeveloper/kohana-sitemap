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
			array(),
			array()
		);
	}
	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_encode
	 */
	public function test_encode($timestamp, $expected)
	{
		$instance = new Sitemap_Data;
		$return = $instance->encode($timestamp);
		$this->assertSame($return, $expected);
	}

	/**
	 * @return array Test data for test_date_format.
	 */
	public function provider_date_format()
	{
		return array
		(
			array(),
			array()
		);
	}
	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_date_format
	 */
	public function test_date_format($date, $expected)
	{
		$instance = new Sitemap_Data;
		$return = $instance->date_format($timestamp);
		$this->assertSame($return, $expected);
	}
}