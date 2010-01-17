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
class Sitemap_Data_News implements Sitemap_Data {

	private $_publication = NULL;

	private $_lang = NULL;

	private $_attributes = array
	(
		'access' => NULL,
		'genres' => NULL,
		'publication_date' => NULL,
		'title'	=> NULL,
		'keywords' => NULL,
		'stock_tickers' => NULL,
	);

	public function set_publication($publication)
	{
		$this->_publication = $publication;
	}

	public function set_lang($lang)
	{
		$this->_lang = $lang;
	}

	public function set_access($access)
	{
		$this->_attributes['access'] = $access;
	}

	public function set_genres($genres)
	{
		$this->_attributes['genres'] = $genres;
	}

	public function set_publication_date($date)
	{
		$this->_attributes['publication_date'] = Sitemap_URL::date_format($date);
	}

	public function set_title($title)
	{
		$this->_attributes['title'] = $title;
	}

	public function set_keywords($keywords)
	{
		$this->_attributes['keywords'] = $keywords;
	}

	public function set_stock_tickers($tickers)
	{
		$this->_attributes['stock_tickers'] = $tickers;
	}

	public function create()
	{
		// Here we need to create a new DOMDocument. This is so we can re-import the
		// DOMElement at the other end.
		$document = new DOMDocument;

		$news = $document->createElement('n:news');

		// Publication 
		$publication = $document->createElement('n:publication');

		$news->appendChild($publication);

		// Publication attributes
		$publication->appendChild($document->createElement('n:name', $this->_publication));
		$publication->appendChild($document->createElement('n:lang', $this->_lang));

		// Append attributes
		foreach($this->_attributes as $name => $value)
		{
			if (NULL !== $value)
			{
				$news->appendChild($document->createElement('n:'.$name, $value));
			}
		}

		return $news;
	}

	public function root($root)
	{
		return $root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:n', 'http://www.google.com/schemas/sitemap-news/0.9');
	}

}
