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
class Kohana_Sitemap_Mobile implements Kohana_Sitemap_Interface
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