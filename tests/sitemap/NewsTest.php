<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Tests Sitemap_News
 *
 * @package Unittest
 * @author  Mathew Davies
 */
class Sitemap_NewsTest extends PHPUnit_Framework_TestCase
{
	public function test_set_publication()
	{
		$instance = new Sitemap_News;
		$return = $instance->set_publication('News of the World');
		$this->assertSame($instance, $return);
	}

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

	/**
	 * @test
	 * @group sitemap
	 */
	public function test_set_title()
	{
		$instance = new Sitemap_News;
		$return = $instance->set_title('The Guardian');
		$this->assertSame($instance, $return);
	}

	/**
	 * @test
	 * @group sitemap
	 */
	public function test_set_keywords()
	{
		$instance = new Sitemap_News;
		$return = $instance->set_keywords(array('hello', 'world', 'how', 'are', 'you'));
		$this->assertSame($instance, $return);
	}

	/**
	 * @return array Test data for test_set_stock_tickers
	 */
	public function provider_set_stock_tickers_good()
	{
		return array
		(
			array(array('hello:world', 'how:are', 'you:today')),
			array(array('hello:world')),
			array(array('hello:world', 'how:are', 'you:today', 'how:are', 'you:today'))
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_set_stock_tickers_good
	 * @param array $tickers
	 */
	public function test_stock_tickers_good($tickers)
	{
		$instance = new Sitemap_News;
		$return = $instance->set_stock_tickers($tickers);
		$this->assertSame($instance, $return);
	}

	/**
	 * @test
	 * @group sitemap
	 * @expectedException OutOfRangeException
	 */
	public function test_stock_tickers_range()
	{
		$instance = new Sitemap_News;
		$instance->set_stock_tickers(array('stock:ticker', 'stock:ticker', 'stock:ticker', 'stock:ticker', 'stock:ticker', 'stock:ticker'));
	}

	/**
	 * @test
	 * @group sitemap
	 * @expectedException InvalidArgumentException
	 */
	public function test_stock_tickers_invalid()
	{
		$instance = new Sitemap_News;
		$instance->set_stock_tickers(array('invalid', 'stock:ticker', 'stock:ticker', 'stock:ticker', 'stock:ticker'));
	}

	/**
	 * @return array Test data for test_create
	 */
	public function provider_create()
	{
		return array
		(
			// Publication - Language - Access - Genre - Publication Date - Title - Tags
			array('The Times', 'eng', 'subscription', array('PressRelease'), 1276811183, 'Nolimits 2 has been released', array('nolimits', 'coaster', 'rollercoaster')),
			array('The Guardian', 'eng', 'registration', array('Blog', 'Opinion'), 1276811183, 'Charlie Brooker is funny', array('brooker', 'charlie', 'great'))
		);
	}

	/**
	 * @test
	 * @group sitemap
	 * @dataProvider provider_create
	 * @covers Sitemap_News::create
	 * @param <type> $pub
	 * @param <type> $lang
	 * @param <type> $access
	 * @param <type> $genre
	 * @param <type> $date
	 * @param <type> $title
	 * @param <type> $tags
	 */
	public function test_create($pub, $lang, $access, $genre, $date, $title, $tags)
	{
		$instance = new Sitemap_News;

		$instance
			->set_publication($pub)
			->set_lang($lang)
			->set_access($access)
			->set_genres($genre)
			->set_publication_date($date)
			->set_title($title)
			->set_keywords($tags);

		$return = $instance->create();

		$xml = simplexml_import_dom($return);
		$this->assertEquals($pub, (string) $xml->{'news:publication'}->{'news:name'});
		$this->assertEquals($lang, (string) $xml->{'news:publication'}->{'news:lang'});
		$this->assertEquals($access, (string) $xml->{'news:access'});
		$this->assertEquals(implode(',', $genre), (string) $xml->{'news:genres'});
		$this->assertEquals(Sitemap::date_format($date), (string) $xml->{'news:publication_date'});
		$this->assertEquals($title, (string) $xml->{'news:title'});
		$this->assertEquals(implode(',', $tags), (string) $xml->{'news:keywords'});
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
		$instance = new Sitemap_URL(new Sitemap_News);
		$instance->set_loc('http://google.com');
		$sitemap->add($instance);

		// Load the end XML
		$xml = new SimpleXMLElement($sitemap->render());

		// Namespaces.
		$namespaces = $xml->getDocNamespaces();

		$this->assertSame(TRUE, isset($namespaces['news']));
		$this->assertSame('http://www.google.com/schemas/sitemap-news/0.9', $namespaces['news']);
	}
}