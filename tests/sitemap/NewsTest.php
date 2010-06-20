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
 * Tests Sitemap_News
 *
 * @package Unittest
 * @author  Mathew Davies
 */
class Sitemap_NewsTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @return array Test data for test_set_loc_good_url
	 */
	public function provider_set_lang_good()
	{
		return array
		(
			array('eng'),
			array('en'),
			array('fra'),
			array('fr'),
			array('zh-tw'),
			array('zh-cn')
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_lang_good
	 */
	public function test_set_lang_good($lang)
	{
		$instance = new Sitemap_News;
		$return = $instance->set_lang($lang);
		$this->assertSame($instance, $return);
	}

	/**
	 * @return array Test data for test_set_loc_bad_url
	 */
	public function provider_set_lang_bad()
	{
		return array
		(
			array('england'),
			array('france'),
			array('en_GB'),
			array('nl_NL')
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_lang_bad
	 * @expectedException InvalidArgumentException
	 */
	public function test_set_lang_bad($lang)
	{
		$instance = new Sitemap_News;
		$return = $instance->set_lang($lang);
	}

	/**
	 * @return array Test data for test_set_access_good
	 */
	public function provider_set_access_good()
	{
		return array
		(
			array('subscription'),
			array('registration'),
			array('ReGiStRaTiOn'),
			array('SuBsCrIpTiOn')
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_access_good
	 */
	public function test_set_access_good($access)
	{
		$instance = new Sitemap_News;
		$return = $instance->set_access($access);
		$this->assertSame($instance, $return);
	}

	/**
	 * @return array Test data for test_set_access_bad
	 */
	public function provider_set_access_bad()
	{
		return array
		(
			array('something'),
			array(TRUE),
			array(FALSE),
			array(1),
			array(0)
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_access_bad
	 * @expectedException InvalidArgumentException
	 */
	public function test_set_access_bad($lang)
	{
		$instance = new Sitemap_News;
		$return = $instance->set_access($lang);
	}

	/**
	 * @return array Test data for test_set_genre_good
	 */
	public function provider_set_genre_good()
	{
		return array
		(
			array(array('PressRelease', 'Blog', 'Satire')),
			array(array('Opinion', 'UserGenerated')),
			array(array('OpEd'))
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_genre_good
	 */
	public function test_set_genre_good($genres)
	{
		$instance = new Sitemap_News;
		$return = $instance->set_genres($genres);
		$this->assertSame($instance, $return);
	}

	/**
	 * @return array Test data for test_set_genre_bad
	 */
	public function provider_set_genre_bad()
	{
		return array
		(
			array(array('gore', 'horror', 'rollercoaster')),
			array(array('something', 'else')),
			array(array(1, 2, 3))
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_genre_bad
	 * @expectedException InvalidArgumentException
	 */
	public function test_set_genre_bad($genres)
	{
		$instance = new Sitemap_News;
		$return = $instance->set_genres($genres);
	}

	/**
	 * @return array Test data for test_set_publication_date
	 */
	public function provider_set_publication_date()
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
	 * @dataProvider provider_set_publication_date
	 * @param mixed $time
	 * @param boolean $raise_exception
	 */
	public function test_set_publication_date($time, $raise_exception = FALSE)
	{
		$instance = new Sitemap_News;

		if ($raise_exception)
		{
			try
			{
				$instance->set_publication_date($time);
			}
			catch (InvalidArgumentException $e)
			{
				return;
			}

			$this->fail('The InvalidArgumentException was not raised');
		}
		else
		{
			$return = $instance->set_publication_date($time);
			$this->assertSame($instance, $return);
		}
	}
}