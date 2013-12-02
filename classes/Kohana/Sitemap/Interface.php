<?php defined('SYSPATH') or die('No direct script access.');

interface Kohana_Sitemap_Interface
{
	/**
	 *
	 */
	public function create();

	/**
	 * 
	 */
	public function root(DOMElement & $root);
}