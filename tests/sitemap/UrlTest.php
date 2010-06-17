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
 * Tests Sitemap_URL
 *
 * @package Unittest
 * @author  Mathew Davies
 */
class Sitemap_UrlTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 * @group sitemap
	 * @expectedException LengthException
	 */
	public function test_set_loc_long()
	{
		$url = new Sitemap_URL;
		$url->set_loc
		(
			'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
			Integer nec nisl ut sapien ullamcorper euismod vel euismod risus. Fusce
			suscipit placerat dolor eget rutrum. Pellentesque lacinia dignissim porta.
			Duis nec diam a dolor molestie sodales eget eget orci. Maecenas dapibus,
			dolor in condimentum commodo, arcu libero blandit tellus, eget gravida leo
			erat a risus. Nullam vel molestie justo. Ut lobortis dictum aliquam. Integer
			mi nisi, tincidunt in mollis eu, ultricies eget eros. Maecenas posuere tristique
			mi, et ullamcorper mi laoreet ullamcorper. Mauris rhoncus, justo quis
			pellentesque tempor, risus enim porttitor lacus, ut ultricies mi quam ac
			dolor. Nullam nec odio ligula. Praesent sed leo dui, nec lobortis turpis.
			Aenean imperdiet laoreet ligula eu mollis. Ut euismod porta sem, sed aliquam
			nibh vehicula ut. Class aptent taciti sociosqu ad litora torquent per conubia
			nostra, per inceptos himenaeos.Lorem ipsum dolor sit amet, consectetur
			adipiscing elit. Integer nec nisl ut sapien ullamcorper euismod vel euismod
			risus. Fusce suscipit placerat dolor eget rutrum. Pellentesque lacinia
			dignissim porta. Duis nec diam a dolor molestie sodales eget eget orci.
			Maecenas dapibus, dolor in condimentum commodo, arcu libero blandit tellus,
			eget gravida leo erat a risus. Nullam vel molestie justo. Ut lobortis dictum
			aliquam. Integer mi nisi, tincidunt in mollis eu, ultricies eget eros.
			Maecenas posuere tristique mi, et ullamcorper mi laoreet ullamcorper. Mauris
			rhoncus, justo quis pellentesque tempor, risus enim porttitor lacus, ut
			ultricies mi quam ac dolor. Nullam nec odio ligula. Praesent sed leo dui,
			nec lobortis turpis. Aenean imperdiet laoreet ligula eu mollis. Ut euismod
			porta sem, sed aliquam nibh vehicula ut. Class aptent taciti sociosqu ad
			litora torquent per conubia nostra, per inceptos himenaeos.Lorem ipsum dolor
			sit amet, consectetur adipiscing elit. Integer nec nisl ut sapien ullamcorper
			euismod vel euismod risus. Fusce suscipit placerat dolor eget rutrum. Pellentesque
			lacinia dignissim porta. Duis nec diam a dolor molestie sodales eget eget orci.
			Maecenas dapibus, dolor in condimentum commodo, arcu libero blandit tellus,
			eget gravida leo erat a risus. Nullam vel molestie justo. Ut lobortis dictum
			aliquam. Integer mi nisi, tincidunt in mollis eu, ultricies eget eros.
			Maecenas posuere tristique mi, et ullamcorper mi laoreet ullamcorper. Mauris
			rhoncus, justo quis pellentesque tempor, risus enim porttitor lacus, ut
			ultricies mi quam ac dolor. Nullam nec odio ligula. Praesent sed leo dui.'
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @expectedException InvalidArgumentException
	 */
	public function test_set_loc_bad_url()
	{
		$url = new Sitemap_URL;
		$url->set_loc('failure-is-an-option');
	}

	/**
	 * @return array Test data for test_set_loc_good_url
	 */
	public function provider_set_loc_good_url()
	{
		return array
		(
			array('http://www.example.com'),
			array('http://example.com'),
			array('http://www.example.com/folder/'),
			array('http://example.com/folder'),
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_loc_good_url
	 */
	public function test_set_loc_good_url($url)
	{
		$instance = new Sitemap_URL;
		$return = $instance->set_loc($url);
		$this->assertSame($return, $instance);
	}

	/**
	 * @return array Test data for test_set_last_mod
	 */
	public function provider_set_last_mod()
	{
		return array
		(
			array(1276811183),
			array('17-06-2010', TRUE),
			array('2010-06-16T17:07:56-05:00', TRUE)
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_last_mod
	 * @param mixed $time
	 * @param boolean $raise_exception
	 */
	public function test_set_last_mod($time, $raise_exception = FALSE)
	{
		$instance = new Sitemap_URL;

		if ($raise_exception)
		{
			try
			{
				$instance->set_last_mod($time);
			}
			catch (InvalidArgumentException $e)
			{
				return;
			}

			$this->fail('The InvalidArgumentException was not raised');
		}
		else
		{
			$return = $instance->set_last_mod($time);
			$this->assertSame($return, $instance);
		}
	}

	/**
	 * @return array Test data for test_set_change_frequency
	 */
	public function provider_set_change_frequency()
	{
		return array
		(
			// Pass
			array('always'),
			array('hourly'),
			array('daily'),
			array('weekly'),
			array('monthly'),
			array('yearly'),
			array('never'),
			// Fail
			array('bi-monthly', TRUE),
			array('annually', TRUE),
			array(100, TRUE),
			array(1, TRUE),
			array(0, TRUE),
			array(TRUE, TRUE),
			array(FALSE, TRUE),
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_change_frequency
	 * @param mixed $change_frequency
	 * @param boolean $raise_exception
	 */
	public function test_set_change_frequency($change_frequency, $raise_exception = FALSE)
	{
		$instance = new Sitemap_URL;

		if ($raise_exception)
		{
			try
			{
				$instance->set_change_frequency($change_frequency);
			}
			catch (InvalidArgumentException $e)
			{
				return;
			}

			$this->fail('The InvalidArgumentException was not raised');
		}
		else
		{
			$return = $instance->set_change_frequency($change_frequency);
			$this->assertSame($return, $instance);
		}
	}

	/**
	 * @return array Test data for test_set_priority
	 */
	public function provider_set_priority()
	{
		return array
		(
			// Pass
			array(0),
			array(0.1),
			array(0.2),
			array(1),
			array('0'),
			array('0.1'),
			array('0.2'),
			array('1'),
			// Fail
			array(1.1, TRUE),
			array(-0.1, TRUE),
			array('1.1', TRUE),
			array('-0.1', TRUE),
			array(TRUE, TRUE),
			array(FALSE, TRUE),
			array(1.1, TRUE),
			array(-0.1, TRUE),
			array('disallowed', TRUE),
			array('content', TRUE),
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_priority
	 * @param mixed $priority
	 * @param boolean $raise_exception
	 */
	public function test_set_priority($priority, $raise_exception = FALSE)
	{
		$instance = new Sitemap_URL;

		if ($raise_exception)
		{
			try
			{
				$instance->set_priority($priority);
			}
			catch (RangeException $e)
			{
				return;
			}

			$this->fail('The RangeException was not raised');
		}
		else
		{
			$return = $instance->set_priority($priority);
			$this->assertSame($return, $instance);
		}
	}
}