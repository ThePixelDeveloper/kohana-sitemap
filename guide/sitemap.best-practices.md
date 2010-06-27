# Caching

Since a sitemap can contain up to 10,000 entries it's usually a good idea to only
regenerate the results every 24 hours. This lowers the load on the server and has
the added benefit of faster file serving.

#### Example

I've taken the basic example and modified it so the results are cached for 24 hours.

[!!] This assumes you have the [cache](http://github.com/kohana/cache) module enabled.

	$cache = Cache::instance();

	if($response = $cache->get('sitemap') === NULL)
	{
		// Sitemap instance.
		$sitemap = new Sitemap;

		// New basic sitemap.
		$url = new Sitemap_URL;

		// Set arguments.
		$url->set_loc('http://google.com')
		    ->set_last_mod(1276800492)
		    ->set_change_frequency('daily')
		    ->set_priority(1);

		// Add it to sitemap.
		$sitemap->add($url);

		// Render the output.
		$response = $sitemap->render();

		// Cache the output for 24 hours.
		$cache->set('sitemap', $response, 86400);
	}

	// Output the sitemap.
	echo $response;