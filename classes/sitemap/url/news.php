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
class Sitemap_Url_News extends Sitemap_Data {

	private $_publication = NULL;

	private $_lang = NULL;

	private $_attributes = array
	(
		'access'					 => NULL,
		'genres'					 => NULL,
		'publication_date' => NULL,
		'title'						 => NULL,
		'keywords'				 => NULL,
		'stock_tickers'		 => NULL,
	);

	/**
	 * @param string $publication name of the news publication. It must exactly
	 * match the name as it appears on your articles in news.google.com, omitting
	 * any trailing parentheticals.
	 */
	public function set_publication($publication)
	{
		$this->_publication = $publication;
	}

	/**
	 * @param string $lang hould be an ISO 639 Language Code (either 2 or 3 letters).
	 * Exception: For Chinese, please use zh-cn for Simplified Chinese or zh-tw for
	 * Traditional Chinese.
	 *
	 * @see http://www.loc.gov/standards/iso639-2/php/code_list.php
	 */
	public function set_lang($lang)
	{
		$this->_lang = $lang;
	}

	/**
	 * @param string $access Possible values include "Subscription" or "Registration",
	 * describing the accessibility of the article. If the article is accessible to
	 * Google News readers without a registration or subscription, this tag should
	 * be omitted.
	 */
	public function set_access($access)
	{
		$this->_attributes['access'] = $access;
	}

	/**
	 * @param string $genres A comma-separated list of properties characterizing the
	 * content of the article, such as "PressRelease" or "UserGenerated." See Google
	 * News content properties for a list of possible values. Your content must be
	 * labeled accurately, in order to provide a consistent experience for our users.
	 *
	 * @see http://www.google.com/support/webmasters/bin/answer.py?answer=93992
	 */
	public function set_genres($genres)
	{
		$this->_attributes['genres'] = $genres;
	}

	/**
	 * @param integer $date Article publication date in unixtimestamp format
	 */
	public function set_publication_date($date)
	{
		$this->_attributes['publication_date'] = $this->date_format($date);
	}

	/**
	 * @param string $title The title of the news article. Note: The title may be
	 * truncated for space reasons when shown on Google News.
	 */
	public function set_title($title)
	{
		$this->_attributes['title'] = $title;
	}

	/**
	 * @param string $keywords A comma-separated list of keywords describing the
	 * topic of the article. Keywords may be drawn from, but are not limited to,
	 * the list of existing Google News keywords.
	 * 
	 * @see http://www.google.com/support/webmasters/bin/answer.py?answer=116037
	 */
	public function set_keywords($keywords)
	{
		$this->_attributes['keywords'] = $keywords;
	}

	/**
	 * @param string $tickers A comma-separated list of up to 5 stock tickers of
	 * the companies, mutual funds, or other financial entities that are the main
	 * subject of the article.
	 *
	 * @see http://finance.google.com/
	 */
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

	public function root( DOMElement & $root )
	{
		$root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:n', 'http://www.google.com/schemas/sitemap-news/0.9');
	}

}