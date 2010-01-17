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
class Sitemap_Data_Code implements Sitemap_Data {

	private $_attributes = array
	(
		'filetype' => NULL,
		'license' => NULL,
		'filename' => NULL,
		'packageurl' => NULL,
		'packagemap' => NULL
	);

	public function set_file_type($type)
	{
		$this->_attributes['filetype'] = $type;
	}

	public function set_license($license)
	{
		$this->_attributes['license'] = $license;
	}

	public function set_file_name($file_name)
	{
		$this->_attributes['filename'] = $file_name;
	}

	public function set_package_url($package_url)
	{
		$this->_attributes['packageurl'] = $package_url;
	}

	public function set_package_map($package_map)
	{
		$this->_attributes['packagemap'] = $package_map;
	}

	public function create()
	{
		// Here we need to create a new DOMDocument. This is so we can re-import the
		// DOMElement at the other end.
		$document = new DOMDocument;

		// Mobile element
		$code = $document->createElement('codesearch:codesearch');

		// Append attributes
		foreach($this->_attributes as $name => $value)
		{
			if (NULL !== $value)
			{
				$code->appendChild($document->createElement('codesearch:'.$name, $value));
			}
		}

		return $code;
	}

	public function root($root)
	{
		return $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:codesearch', 'http://www.google.com/codesearch/schemas/sitemap/1.0');
	}

}
