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
class Sitemap_Url_Geo extends Sitemap_Data {

	private $_format = NULL;

	private $_allowed_formats = array
	(
		'kml', 'georss'
	);

	/**
	 * @param string $format Case-insensitive. Specifies the format of the geo content.
	 * Examples include "kml" and "georss". Only supported formats will be indexed.
	 *
	 * @see http://www.google.com/support/webmasters/bin/answer.py?answer=94556
	 */
	public function set_format($format)
	{
		if (in_array($format, $this->_allowed_formats))
		{
			$this->_format = $format;
		}
	}

	public function create()
	{
		// Here we need to create a new DOMDocument. This is so we can re-import the
		// DOMElement at the other end.
		$document = new DOMDocument;

		// Mobile element
		$geo = $document->createElement('geo:geo');

		// Add format
		$format = $document->createElement('geo:format', $this->_format);

		return $geo;
	}

	public function root( DOMElement & $root)
	{
		$root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:geo', 'http://www.google.com/geo/schemas/sitemap/1.0');
	}

}