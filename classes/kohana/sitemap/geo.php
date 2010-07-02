<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Sitemap_Geo implements Kohana_Sitemap_Interface
{

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