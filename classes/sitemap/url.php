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
class Sitemap_URL extends Sitemap_Data
{
	private $_attributes = array
	(
		'loc'        => NULL,
		'lastmod'    => NULL,
		'changefreq' => NULL,
		'priority'   => NULL,
	);

	/**
	 * URL of the page. This URL must begin with the protocol (such as http) and end
	 * with a trailing slash, if your web server requires it. This value must be
	 * less than 2,048 characters.
	 * @see http://www.sitemaps.org/protocol.php
	 * @param string $location
	 */
	public function set_loc($location)
	{
		if ( ! Validate::max_length($location, 2048))
		{
			throw new LengthException('The location was too long, maximum length of 2,048 characters.');
		}

		if ( ! Validate::url($location))
		{
			throw new InvalidArgumentException('The location was not a valid URL');
		}
		
		$this->_attributes['loc'] = $this->encode($location);
	}

	/**
	 * The date of last modification of the file.
	 * @param integer $lastmod Unix timestamp
	 */
	public function set_last_mod($lastmod)
	{
		if (is_int($lastmod) AND $lastmod >= PHP_INT_SIZE AND $lastmod <= PHP_INT_MAX)
		{
			$this->_attributes['lastmod'] = $this->date_format($lastmod);
		}
		else
		{
			throw new InvalidArgumentException('Must be a unix timestamp');
		}
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

	/**
	 *
	 * @param <type> $driver
	 */
	public function __construct( $driver = NULL)
	{
		if ( $driver instanceof Sitemap_Data )
		{
			$this->_driver = $driver;
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
			$url->appendChild($document->importNode($this->_driver->create(), TRUE));
		}

		return $url;
	}

	public function root( DOMElement & $root )
	{
		// Add urlset namespace.
		$root->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

		if (NULL !== $this->_driver)
		{
			$this->_driver->root($root);
		}
	}
}
