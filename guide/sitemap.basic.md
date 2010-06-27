# Basic Sitemap

This will show you how to create the most basic XML sitemap.

[!!] Only the **loc** argument is required, the others are **optional**.

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
	$output = $sitemap->render();

	// __toString is also supported.
	echo $sitemap;

# Output

The above example should output the following

	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		<url>
			<loc>http://google.com</loc>
			<lastmod>2010-06-17T19:48:12+01:00</lastmod>
			<changefreq>daily</changefreq>
			<priority>1</priority>
		</url>
	</urlset>

# Requirements

| Argument         | Requirements                                                                                                    |
|------------------|-----------------------------------------------------------------------------------------------------------------|
| loc              | Maximum length of 2,048 characters.                                                                             |
|                  | Must pass Validate::url                                                                                         |
| last mod         | Unixtime stamp                                                                                                  |
| change frequency | Must be one of the following: **always**, **hourly**, **daily**, **weekly**, **monthly**, **yearly**, **never** |
| priority         | Must be a numeric value between **0 (zero)** and **1 (one)** and is **inclusive**.                              |