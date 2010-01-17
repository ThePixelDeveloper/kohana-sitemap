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
return array(
	/**
	 * Gzip can dramatically reduce the size of the sitemap. We recommend you use
	 * this option with more than 1,000 entries. Gzipped entries are computed by
	 * appending the .gz extension to the url (sitemap.xml.gz)
	 */
	'gzip' => array
	(
		'enabled' => TRUE,
		'level' => 9
	),
	/**
	 * Array of URLs to ping. This lets the provider know you have updated your
	 * sitemap. sprintf string.
	 */
	'ping' => array
	(
		'Google'	 => 'http://www.google.com/webmasters/tools/ping?sitemap=%s',
		'Yahoo'		 => 'http://search.yahooapis.com/SiteExplorerService/V1/ping?sitemap=%s',
		'Ask'			 => 'http://submissions.ask.com/ping?sitemap=%s',
		'Bing'		 => 'http://www.bing.com/webmaster/ping.aspx?siteMap=%s',
		'MoreOver' => 'http://api.moreover.com/ping?u=%s'
	),
	/**
	 * When enabled, extra detail is logged
	 *  HTTP status code from ping
	 */
	'debug' => FALSE
);
