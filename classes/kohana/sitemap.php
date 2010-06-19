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
class Kohana_Sitemap
{
	/**
	 * @var DOMDocument
	 */
	protected $_xml;

	/**
	 * @var DOMElement
	 */
	protected $_root;

	/**
	 * Setup the XML document
	 */
	public function __construct()
	{
		// XML document
		$this->_xml = new DOMDocument('1.0', Kohana::$charset);

		// Attributes
		$this->_xml->formatOutput = TRUE;

		// Root element
		$this->_root = $this->_xml->createElement('urlset');

		// Append to XML document
		$this->_xml->appendChild($this->_root);
	}
	
	/**
	 * @param Sitemap_URL $object 
	 */
	public function add( Sitemap_URL $object )
	{
		$url = $object->create();

		// Decorate the urlset
		$object->root($this->_root);
		
		// Append URL to root element
		$this->_root->appendChild($this->_xml->importNode($url, TRUE));
	}
	
	/**
	 * Ping web services
	 * 
	 * @param string $sitemap Full website path to sitemap
	 * @return array Service key with the HTTP response code as the value.
	 */
	public static function ping($sitemap)
	{
		// Main handle
		$master = curl_multi_init();

		// List of URLs to ping
		$URLs = Kohana::config('sitemap.ping');

		$handles = array();

		// Create handles for each URL and add them to the main handle.
		foreach($URLs as $key => $val)
		{
			$handles[$key] = curl_init(sprintf($val, $sitemap));
			
			curl_setopt($handles[$key], CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($handles[$key], CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($handles[$key], CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux x86_64; en-GB; rv:1.9.2.3) Gecko/20100423 Ubuntu/10.04 (lucid) Firefox/3.6.3');

			curl_multi_add_handle($master, $handles[$key]);
		}
		
		do
		{
			curl_multi_exec($master, $still_running);
		}
		while ($still_running > 0);
		
		$info = array();

		// Build an array of the execution information.
		foreach(array_keys($URLs) as $key)
		{
			$info[$key] = curl_getinfo($handles[$key], CURLINFO_HTTP_CODE);

			// Close the handles while we're here.
			curl_multi_remove_handle($master, $handles[$key]);
		}

		// and finally close the master handle.
		curl_multi_close($master);

		return $info;
	}

	/**
	 * UTF8 encode a string
	 *
	 * @access public
	 * @param string $string
	 * @return string
	 */
	public static function encode($string)
	{
		$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

		// This is a rather ugly hack. Basically urlencode and rawurlencode use RFC 1738
		// encoding. This brings it up to date (RFC 3986); The newer RFC has a different
		// set of reserved characters. Credit goes to davis dot peixoto at gmail dot com
		// God bless PHP comments.
		$entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', 
			'%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%23', '%5B', '%5D');
		
		$replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+",
			"$", ",", "/", "?", "#", "[", "]");

		$string = str_replace($entities, $replacements, urlencode($string));
		
		return str_replace('&#039;', '&apos;', $string);
	}

	/**
	 * Format a unix timestamp into W3C Datetime
	 *
	 * @access public
	 * @see http://www.w3.org/TR/NOTE-datetime
	 * @param string $unix Unixtimestamp
	 * @return string W3C Datetime
	 */
	public static function date_format($unix)
	{
		if (is_numeric($unix) AND $unix <= PHP_INT_MAX)
		{
			return date('Y-m-d\TH:i:sP', $unix);
		}

		throw new InvalidArgumentException('Must be a unix timestamp');
	}

	/**
	 * @return string Either an XML document or a gzipped file
	 */
	public function render()
	{
		// Default uncompressed
		$response = $this->_xml->saveXML();

		$gzip = Kohana::config('sitemap.gzip');

		// If the gzip extension is provided in the URL and is enabled in the config
		// we send back a gzipped compressed file
		$uri = Request::instance()->param('gzip');
		
		if ($gzip['enabled'] AND NULL !== $uri)
		{
			// Try and gzip the file before we send it off.
			try
			{
				$response = gzencode($response, $gzip['level']);
			}
			catch (ErrorException $e)
			{
				Kohana::$log->add(Kohana::ERROR, Kohana::exception_text($e));
			}
		}
		
		return $response;
	}

	/**
	 * @return string XML output.
	 */
	public function  __toString()
	{
		return $this->render();
	}	
}