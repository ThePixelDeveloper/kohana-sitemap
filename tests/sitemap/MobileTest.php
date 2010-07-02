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
}