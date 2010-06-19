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
			array('fr')
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_lang_good
	 */
	public function test_set_lang_good($lang)
	{
		$instance = new Sitemap_Url_News;
		$return = $instance->set_lang($lang);
		$this->assertSame($return, TRUE);
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
		$instance = new Sitemap_Url_News;
		$return = $instance->set_lang($lang);
	}

	/**
	 * @return array Test data for test_set_loc_good_access
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
		$instance = new Sitemap_Url_News;
		$return = $instance->set_access($access);
		$this->assertSame($return, TRUE);
	}
}