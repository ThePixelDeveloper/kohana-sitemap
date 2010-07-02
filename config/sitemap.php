<?php defined('SYSPATH') or die('No direct script access.');

return array(
	/**
	 * Gzip can dramatically reduce the size of the sitemap. We recommend you use
	 * this option with more than 1,000 entries. Gzipped entries are computed by
	 * appending the .gz extension to the url (sitemap.xml.gz)
	 */
	'gzip' => array
	(
		'enabled' => TRUE,
		/*
		 * From 1-9
		 */
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
