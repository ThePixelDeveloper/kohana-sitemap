<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tests Sitemap_Geo
 *
 * @package Unittest
 * @author  Mathew Davies
 */
class Sitemap_GeoTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @return array Test data for test_set_format
	 */
	public function provider_set_format()
	{
		return array
		(
			array('kml'),
			array('kmz'),
			array('georss'),
			array(1, TRUE),
			array(TRUE, TRUE),
			array(0, TRUE),
			array('something', TRUE),
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_format
	 * @param <type> $format
	 * @param <type> $raise_exception 
	 */
	public function test_set_format($format, $raise_exception = FALSE)
	{
		$instance = new Sitemap_Geo;
		
		if ($raise_exception)
		{
			try
			{
				$instance->set_format($format);
			}
			catch (InvalidArgumentException $e)
			{
				return;
			}

			$this->fail('The InvalidArgumentException was not raised');
		}
		else
		{
			$return = $instance->set_format($format);
			$this->assertSame($instance, $return);
		}
	}
}