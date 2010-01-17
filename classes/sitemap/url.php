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
class Sitemap_URL {

	private $_attributes = array
	(
		'loc'					=> NULL,
		'lastmod'			=> NULL,
		'changefreq'	=> NULL,
		'priority'		=> NULL,
	);

	/**
	 *
	 * @param <type> $loc
	 */
	public function set_loc($loc)
	{
		$this->_attributes['loc'] = $this->encode($loc);
	}

	/**
	 *
	 * @param <type> $lastmod
	 */
	public function set_last_mod($lastmod)
	{
		$this->_attributes['lastmod'] = $this->date_format($lastmod);
	}

	/**
	 *
	 * @param <type> $change_frequency
	 */
	public function set_change_frequency($change_frequency)
	{
		$this->_attributes['changefreq'] = $change_frequency;
	}

	/**
	 *
	 * @param <type> $priority 
	 */
	public function set_priority($priority)
	{
		$this->_attributes['priority'] = $priority;
	}

	private $_driver = NULL;

	private $_extra = NULL;

	/**
	 *
	 * @param <type> $extra 
	 */
	public function __construct( $extra = NULL)
	{
		if ( is_a($extra, 'Sitemap_Data') AND NULL !== $extra )
		{
			$this->_driver = $extra;
			$this->_extra = $extra->create();
		}
	}

	public function root( DOMElement $root )
	{
		// Add urlset namespace.
		$root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

		if (NULL !== $this->_driver)
		{
			$this->_driver->root( $root );
		}
	}
	
	/**
	 *
	 */
	public function create()
	{
		// Here we need to create a new DOMDocument. This is so we can re-import the
		// DOMElement at the other end.
		$document = new DOMDocument;
		
		$url = $document->createElement('url');

		foreach($this->_attributes as $name => $value)
		{
			if (NULL !== $value)
			{
				$url->appendChild(new DOMElement($name, $value));
			}
		}

		// Add additional information
		if (NULL !== $this->_driver)
		{
			$url->appendChild($document->importNode($this->_extra, TRUE));
		}

		return $url;
	}

	/**
	 * UTF8 encode a string
	 *
	 * @param string $string
	 * @return string
	 */
	public static function encode($string)
	{
		$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

		// Convert &#039; to &apos;
		return str_replace('&#039;', '&apos;', $string);
	}

	/**
	 * Format a unix timestamp into W3C Datetime
	 *
	 * @see http://www.w3.org/TR/NOTE-datetime
	 * @param string $unix Unixtimestamp
	 * @return string W3C Datetime
	 */
	public static function date_format($unix)
	{
		$date = new DateTime;

		// For unixtime stamps.
		$date->setTimestamp($unix);

		// Format to W3C standards
		return $date->format(DATE_W3C);
	}

}