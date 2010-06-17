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
class Kohana_Sitemap {

	/**
	 * @var DOMDocument
	 */
	protected $_xml = NULL;

	/**
	 * @var DOMElement
	 */
	protected $_root = NULL;

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
	 *
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
	 * @return Sitemap
	 */
	public static function ping($sitemap)
	{
		// URL encode sitemap address.
		$sitemap = urlencode($sitemap);

		// List of ping URLs
		$urls = Kohana::config('sitemap.ping');

		foreach($urls as $key => $val)
		{
			// Replace placholder with URL
			$url = sprintf($val, $sitemap);
			
			// Send request
			$status = Remote::status($url);
			
			if (Kohana::config('sitemap.debug') OR 200 !== $status)
			{
				// Debugging or failed request
				Kohana::$log->add(Kohana::ERROR, 'Ping: [ '.$key.' => '.$url.' ] Status code: [ '.$request->status.' ]');
			}
		}

		return $this;
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
