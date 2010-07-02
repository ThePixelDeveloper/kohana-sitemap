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
	 * @param mixed $format
	 * @param boolean $raise_exception
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

	/**
	 * @test
	 * @group sitemap
	 */
	public function test_create()
	{
		$geo = new Sitemap_Geo();
		$geo->set_format('kml');

		// Pass in the sitemap class
		$instance = new Sitemap_URL($geo);
		$instance->set_loc('http://google.com');

		// Should have a <geo:geo/>
		$result = $instance->create();
		$xml = simplexml_import_dom($result);
		$this->assertSame(TRUE, property_exists($xml, 'geo:geo'));
		$this->assertSame(TRUE, property_exists($xml->{"geo:geo"}, 'geo:format'));
	}

	/**
	 * @test
	 * @group sitemap
	 */
	public function test_root()
	{
		// Base Sitemap
		$sitemap = new Sitemap;

		// Create basic Mobile Sitemap
		$instance = new Sitemap_URL(new Sitemap_Geo);
		$instance->set_loc('http://google.com');
		$sitemap->add($instance);

		// Load the end XML
		$xml = new SimpleXMLElement($sitemap->render());

		// Namespaces.
		$namespaces = $xml->getDocNamespaces();

		$this->assertSame(TRUE, isset($namespaces['geo']));
		$this->assertSame('http://www.google.com/geo/schemas/sitemap/1.0', $namespaces['geo']);
	}
}