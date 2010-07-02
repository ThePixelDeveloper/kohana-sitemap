<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Sitemap index, links to all other sitemaps (next route)
 */
Route::set('sitemap_index', 'sitemap.xml(<gzip>)', array('gzip' => '\.gz'))
	->defaults(array(
		'controller' => 'sitemap',
		'action' => 'index'
	));

/**
 * Individual sitemaps use the following format http://localhost/<action>-<number>.xml
 *
 * Example
 *	http://localhost/files-0.xml would use action_files in the sitemap controller
 *  and have an offset of 0 (first 50,000).
 */
Route::set('sitemap', '<action>-<number>.xml(<gzip>)', array('action' => '[a-z]++' ,'number' => '[0-9]++', 'gzip' => '\.gz'))
	->defaults(array(
		'controller' => 'sitemap'
	));