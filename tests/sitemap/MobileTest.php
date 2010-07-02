<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tests Sitemap_URL
 *
 * @package Unittest
 * @author  Mathew Davies
 */
class Sitemap_MobileTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 * @group sitemap
	 */
	public function test_create()
	{
		// Pass in the sitemap class
		$url = new Sitemap_URL(new Sitemap_Mobile);
		$url->set_loc('http://google.com');

		// Should have a <mobile:mobile/>
		$result = $url->create();
		$xml = simplexml_import_dom($result);
		$this->assertSame(TRUE, property_exists($xml, 'mobile:mobile'));
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
		$instance = new Sitemap_URL(new Sitemap_Mobile);
		$instance->set_loc('http://google.com');
		$sitemap->add($instance);

		// Load the end XML
		$xml = new SimpleXMLElement($sitemap->render());

		// Namespaces.
		$namespaces = $xml->getDocNamespaces();

		$this->assertSame(TRUE, isset($namespaces['mobile']));
		$this->assertSame('http://www.google.com/schemas/sitemap-mobile/1.0', $namespaces['mobile']);
	}
}