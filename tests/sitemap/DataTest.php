<?php defined('SYSPATH') or die('No direct script access.');

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

	/**
	 * @test
	 * @group sitemap
	 */
	public function test_ping()
	{
		// Ping keys
		$keys = array_keys(Kohana::config('sitemap.ping'));

		$statuses = Sitemap::ping('http://example.com/sitemap.xml');

		// Make sure we get a valid HTTP code back.
		foreach($keys as $row)
		{
			$this->assertRegExp('/^[1-5][0-9]{2}$/', (string) $statuses[$row]);
		}
	}

	/**
	 * @test
	 * @group sitemap
	 */
	public function test_render_xml()
	{
		// Basic URL
		$url = new Sitemap_URL;
		$url->set_loc('http://example.com');

		// Add the sitemap url.
		$instance = new Sitemap;
		$instance->add($url);

		// Via render
		$render = simplexml_load_string($instance->render());

		// Via __toString
		$tostring = simplexml_load_string((string) $instance);
		
		$this->assertSame(TRUE, $render instanceof SimpleXMLElement);
		$this->assertSame(TRUE, $tostring instanceof SimpleXMLElement);
	}

	/**
	 * @test
	 * @group sitemap
	 */
	public function test_render_gzip()
	{
		// Basic URL
		$url = new Sitemap_URL;
		$url->set_loc('http://example.com');

		// Add the sitemap url.
		$instance = new Sitemap;
		$instance->add($url);

		// Enable gzip compression
		$instance->gzip = TRUE;
		$instance->compression = 9;

		// Via render
		$render = $instance->render();

		// Via __toString
		$tostring = (string) $instance;

		$this->assertSame(TRUE, NULL !== http_inflate($render));
		$this->assertSame(TRUE, NULL !== http_inflate($tostring));
	}
}