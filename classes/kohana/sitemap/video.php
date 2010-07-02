<?php defined('SYSPATH') or die('No direct script access.');

abstract class Kohana_Sitemap_Video implements Kohana_Sitemap_Interface
{

	// Attributes
	private $_attributes = array
	(
		'player_loc'			 => NULL,
		'content_loc'			 => NULL,
		'thumbnail_loc'		 => NULL,
		'title'						 => NULL,
		'description'			 => NULL,
		'rating'					 => NULL,
		'view_count'			 => NULL,
		'publication_date' => NULL,
		'tag'							 => NULL,
		'category'				 => NULL,
		'family_friendly'  => NULL,
		'duration'				 => NULL,
		'expiration_date'	 => NULL
	);

	/**
	 * @param string $thumbnail_loc A URL pointing to the URL for the video
	 * thumbnail image file. We can accept most image sizes/types but recommend
	 * your thumbs are at least 160x120 in .jpg, .png, or. gif formats.
	 */
	public function set_thumbnail_loc($thumbnail_loc)
	{
		$this->_attributes['thumnail_loc'] = $thumbnail_loc;
	}

	/**
	 * @param string $title The title of the video. Limited to 100 characters.
	 */
	public function set_title($title)
	{
		$this->_attributes['title'] = $title;
	}

	/**
	 * @param string $description The description of the video. Descriptions
	 * longer than 2048 characters will be truncated.
	 */
	public function set_description($description)
	{
		$this->_attributes['description'] = $description;
	}

	/**
	 * @param float $rating The rating of the video. The value must be float
	 * number in the range 0.0-5.0.
	 */
	public function set_rating($rating)
	{
		$this->_attributes['rating'] = $rating;
	}

	/**
	 * @param string $view_count The number of times the video has been viewed
	 */
	public function set_view_count($view_count)
	{
		$this->_attributes['view_count'] = $view_count;
	}

	/**
	 * @param integer $publication_date The date the video was first published,
	 * in unixtimestamp format.
	 */
	public function set_publication_date($publication_date)
	{
		$this->_attributes['publication_date'] = $this->date_format($publication_date);
	}

	/**
	 * @param array $tag Array of tags, a maximum of 32 tags is permitted
	 */
	public function set_tag( array $tag )
	{
		if (count($tag) <= 32)
		{
			$this->_attributes['tag'] = $tag;
		}
	}

	/**
	 * @param string $category The video's category. For example, cooking. The
	 * value should be a string no longer than 256 characters. In general,
	 * categories are broad groupings of content by subject. Usually a video will
	 * belong to a single category. For example, a site about cooking could have
	 * categories for Broiling, Baking, and Grilling
	 */
	public function set_category($category)
	{
		$this->_attributes['category'] = $category;
	}

	/**
	 * @param string $family_friendly "No" if the video should be available only
	 * to users with SafeSearch turned off.
	 */
	public function set_family_friendly($family_friendly)
	{
		$this->_attributes['family_friendly'] = $family_friendly;
	}

	/**
	 * @param integer $duration 	The duration of the video in seconds. Value must
	 * be between 0 and 28800 (8 hours). Non-digit characters are disallowed.
	 */
	public function set_duration($duration)
	{
		$this->_attributes['duration'] = $duration;
	}

	/**
	 * @param integer $expiration_date The date after which the video will no
	 * longer be available, in unixtimestamp format.
	 */
	public function set_expiration_date($expiration_date)
	{
		$this->_attributes['expiration_date'] = $this->date_format($expiration_date);
	}

	public function create()
	{
		// Here we need to create a new DOMDocument. This is so we can re-import the
		// DOMElement at the other end.
		$document = new DOMDocument;

		// Video element
		$video = $document->createElement('video:video');

		$document->appendChild($video);

		// Append attributes
		foreach($this->_attributes as $name => $value)
		{
			if (NULL !== $value)
			{
				$video->appendChild($document->createElement('video:'.$name, $value));
			}
		}

		return $video;
	}

	public function root( DOMElement & $root )
	{
		$root->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:video', 'http://www.google.com/schemas/sitemap-video/1.1');
	}
	
}