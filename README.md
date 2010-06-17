Sitemap Module
==============

For Kohana v3, the module allows you to generate XML sitemaps for Google Webmaster tools. I support the current types of Google sitemaps:

- [Standard](http://www.sitemaps.org/protocol.php)
- [Code Search](http://www.google.com/support/webmasters/bin/answer.py?answer=75224)
- [Geo](http://www.google.com/support/webmasters/bin/answer.py?answer=94554)
- [Mobile](http://www.google.com/support/webmasters/bin/answer.py?answer=34648)
- [News](http://www.google.com/support/webmasters/bin/answer.py?hl=en&answer=74288)
- [Video](http://www.google.com/support/webmasters/bin/answer.py?answer=80472)

Installation
------------

    git submodule add git://github.com/ThePixelDeveloper/kohana-sitemap.git modules/sitemap

Keeping up to date
-------------------

    git submodule update

Basic Sitemap
-----

    $sitemap = new Sitemap;

    // Create a URL object.
    $url = new Sitemap_URL;
    $url->set_loc('http://google.com');
    $url->set_last_mod(1276800492);

    // Add it to the main sitemap
    $sitemap->add($url);

    // Return out the final XML.
    $output = $sitemap->render();

Output:

    <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
      <url>
        <loc>http://google.com</loc>
        <lastmod>2010-06-17T19:48:12+01:00</lastmod>
      </url>
    </urlset>

Advanced Sitemaps
-----------------

We create a specific sitemap `Sitemap_Url_News`, set any parameters and then
pass the object into the construct of `Sitemap_Url`. **Reason?** `Sitemap_Url` is the base
of all sitemaps and has required attributes.

    $sitemap = new Sitemap;

    $news = new Sitemap_Url_News;
    $news->set_title('Kohana has been bought by Ellislab!');
    $news->set_publication_date(1276800492);
    $news->set_publication('News publication');
    $news->set_lang('en');

    // Create a URL object.
    $url = new Sitemap_URL($news);
    $url->set_loc('http://google.com');
    $url->set_last_mod(1276800492);

    // Add it to the main sitemap
    $sitemap->add($url);

    // Return out the final XML.
    $output = $sitemap->render();

Output:

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:n="http://www.google.com/schemas/sitemap-news/0.9">
  <url>
    <loc>http://google.com</loc>
    <lastmod>2010-06-17T19:48:12+01:00</lastmod>
    <n:news>
      <n:publication>
        <n:name>News publication</n:name>
        <n:lang>en</n:lang>
      </n:publication>
      <n:publication_date>2010-06-17T19:48:12+01:00</n:publication_date>
      <n:title>Kohana has been bought by Ellislab!</n:title>
    </n:news>
  </url>
</urlset>

Bugs
----

Please file all bugs, patches and feature requests to the [Sitemap Issue Tracker](http://github.com/ThePixelDeveloper/kohana-sitemap/issues)