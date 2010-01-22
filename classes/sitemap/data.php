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
abstract class Sitemap_Data {

	/**
	 * @return DOMElement Extra sitemap information
	 */
	abstract public function create();

	/**
	 * Allows concrete classes to change the document root (urlset) attributes
	 *
	 * @param DOMElement $root Document root
	 * @return DOMElement
	 */
	abstract public function root( DOMElement & $root );
	
	/**
	 * UTF8 encode a string
	 *
	 * @access public
	 * @param string $string
	 * @return string
	 */
	protected function encode($string)
	{
		$string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');

		// Convert &#039; to &apos;
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
	protected function date_format($unix)
	{
		return date('Y-m-d\TH:i:sP', $unix);
	}
}
