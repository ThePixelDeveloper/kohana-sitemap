<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tests Sitemap_Code
 *
 * @package Unittest
 * @author  Mathew Davies
 */
class Sitemap_CodeTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @return array Test data for test_set_file_type
	 */
	public function provider_set_file_type()
	{
		return array
		(
			array('bat'),
			array('basic'),
			array('awk'),
			array('c++'),
			array('Batch File', TRUE),
			array('æ', TRUE),
			array(0, TRUE),
			array(FALSE, TRUE),
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_file_type
	 * @param mixed $type
	 * @param boolean $raise_exception
	 */
	public function test_set_file_type($type, $raise_exception = FALSE)
	{
		$instance = new Sitemap_Code;

		if ($raise_exception)
		{
			try
			{
				$instance->set_file_type($type);
			}
			catch (InvalidArgumentException $e)
			{
				return;
			}

			$this->fail('The InvalidArgumentException was not raised');
		}
		else
		{
			$return = $instance->set_file_type($type);
			$this->assertSame($instance, $return);
		}
	}

	/**
	 * @return array Test data for test_set_license
	 */
	public function provider_set_license()
	{
		return array
		(
			array('gpl'),
			array('bsd'),
			array('GNU General Public License', TRUE),
			array(TRUE, TRUE),
			array('æ', TRUE),
			array(0, TRUE),
			array(FALSE, TRUE),
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_license
	 * @param mixed $license
	 * @param boolean $raise_exception
	 */
	public function test_set_license($license, $raise_exception = FALSE)
	{
		$instance = new Sitemap_Code;

		if ($raise_exception)
		{
			try
			{
				$instance->set_license($license);
			}
			catch (InvalidArgumentException $e)
			{
				return;
			}

			$this->fail('The InvalidArgumentException was not raised');
		}
		else
		{
			$return = $instance->set_license($license);
			$this->assertSame($instance, $return);
		}
	}
}