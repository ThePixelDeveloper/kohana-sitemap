<?php defined('SYSPATH') or die('No direct script access.');

abstract class Kohana_Sitemap_Mobile implements Kohana_Sitemap_Interface
{

	public function create()
	{
		// Here we need to create a new DOMDocument. This is so we can re-import the
		// DOMElement at the other end.
		$document = new DOMDocument;
		
		// Mobile element
		$mobile = $document->createElement('mobile:mobile');
		
		return $mobile;
	}

	public function root( DOMElement & $root)
	{
		$root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:mobile', 'http://www.google.com/schemas/sitemap-mobile/1.0');
	}

}