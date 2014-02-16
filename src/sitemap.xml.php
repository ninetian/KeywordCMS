<?php /*
 KeywordCMS Sitemap Generator.

 Tweak your base URL, below.

 I could have used PHP's native XML functions for this, but the format is simple
 enough that it probably would have taken more code to do so.

 Enjoy :)
*/

header('Content-Type: application/xml; charset=UTF-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';
$sitemap = json_decode(file_get_contents('sitemap.json'));
$lastmod = json_decode(file_get_contents('lastmod.json')); ?>

<urlset
 xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
 xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
  http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<?php
	foreach ($sitemap as $page) {
		if (!property_exists($page, 'path')
		 || substr($page->path, 0, 1) !== '/') continue;

		echo '
	<url>
		<loc>http://bronstrup.com/keywordcms'.$page->path.'</loc>'.(
		 $page->priority
		  ? '
		<priority>'.$page->priority.'</priority>'
		  : '').(
		 $page->changefreq
		  ? '
		<changefreq>'.$page->changefreq.'</changefreq>'
		  : '').(
		 property_exists($lastmod, $page->path)
		  ? '
		<lastmod>'.date('c', $lastmod->{$page->path}).'</lastmod>'
		  : '').'
	</url>';
	}
?>

</urlset>
