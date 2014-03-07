<?php /* KeywordCMS Core File

 Beware all who enter here: This is a mess! I should (and someday soon, I will)
 wrap all of this up nicely into an object, perhaps even stuff it into a nice,
 neat little namespace. This was developed as a quick-and-dirty solution to a
 problem with very loose requirements; as such, it comes with all the caveats
 you'd expect with any quick-and-dirty solution.

 More or less, the whole CMS is a hack with a couple of worthwhile features;
 it'll get cleaned up, someday. Maybe I'll even tweet about it!

 At least I attempted to document. :)

 */
namespace kcms;

// No template specified? We're probably not being called correctly... ABORT!
if (!isset($tpl)) {header("HTTP/1.0 404 Not Found"); die;}

// Fetch the URL path
$path = preg_replace('/(\/)?(\?.*)?$/', '',
 $_SERVER['REQUEST_URI']);

if (empty($path)) $path = '/';

// Redirect .php files; works hand-in-hand with the rewrite in our .htaccess
if (preg_match('/\.php$/', $path)) {header("Location: ".preg_replace(
 '/(\.php$)/', '', $path)); die;}

// Fetch last modified times and sitemap
$lastmod       = filemtime($_SERVER['SCRIPT_FILENAME']);
$lastmod_map   = filemtime($_SERVER['DOCUMENT_ROOT'].
 '/sitemap.json');
$lastmod_kwrds = filemtime($_SERVER['DOCUMENT_ROOT'].
 '/inc/keyword_excludes.php');
$sitemap       = json_decode(file_get_contents(
 $_SERVER['DOCUMENT_ROOT'].'/sitemap.json'));
$lastmod_obj   = file_exists($_SERVER['DOCUMENT_ROOT'].
 '/lastmod.json') ?
  json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].
   '/lastmod.json'))
  : new stdClass;

// Look for cache-kill flag
if (array_key_exists('au', $_GET) // Really cheesy authentication
 // Please, develop something better for production use!
 && $_GET['au'] === 'th' // The rest of that really cheesy authentication
 && array_key_exists('htmlcache', $_GET)) {
	// Set Content-Type header
	header('Content-Type: text/plain; charset=utf-8');
	if ($_GET['htmlcache'] === 'all') {
		echo "Clearing all cache...\n\n";
		passthru('cd '.$_SERVER['DOCUMENT_ROOT'].' && find . -type f -name "*._c" -exec echo "Found {}..." \; -exec rm {} \;');
	} elseif (file_exists($_SERVER['SCRIPT_FILENAME'].'._c')) {
		echo 'Found '.$_SERVER['SCRIPT_FILENAME'].'._c'.'...';
		unlink($_SERVER['SCRIPT_FILENAME'].'._c');
	} else {
		echo 'No cache found for this page.';
	}
	die("\n\nDone.");
}

// Set Content-Type and Last-Modified headers
/*
 TODO: Allow Content-Type to be overridden easily.
 Don't care right now, but it might be useful to someone.
*/
header('Content-Type: text/html; charset=utf-8');
header('Last-Modified: '.gmdate('r',
	max($lastmod, $lastmod_map, $lastmod_kwrds)));

// Set Expires header
// Quarter of changefreq duration (see sitemap.json), default: 10sec
if (!empty($page->nocache)) {
	header('Expires: '.date('r', time()));
} else {
	$changefreq = 'none';

	foreach ($sitemap as $entry) {
		// Do we have an entry?
		if (!property_exists($entry, 'path')
		 || $entry->path != $path
		) continue;

		// Are we properly capitalized? If not, redirect.
		if ($entry->path !== $path) {
			header('Location: '.$entry->path);
			die;
		}

		// If we have a changefreq, grab it
		if (property_exists($entry, 'changefreq')) $changefreq = $entry->changefreq;

		// We've found our entry, so we're done here
		break;
	}

	switch ($changefreq) {
		case 'always':
			header('Expires: '.date('r', time()));
			break;
		case 'hourly':
			header('Expires: '.date('r', time()+900));
			break;
		case 'daily':
			header('Expires: '.date('r', time()+21600));
			break;
		case 'weekly':
			header('Expires: '.date('r', time()+151200));
			break;
		case 'monthly':
			header('Expires: '.date('r', time()+604800));
			break;
		case 'yearly':
		case 'never':
			header('Expires: '.date('r', time()+7884000));
			break;
		default:
			header('Expires: '.date('r', time()+10));
	}
}
// Look for a still-valid cache
if ((!property_exists($page, 'nocache')
  || empty($page->nocache))
 && file_exists($_SERVER['SCRIPT_FILENAME'].'._c')
 && filemtime($_SERVER['SCRIPT_FILENAME'].'._c') >=
  max($lastmod, $lastmod_map, $lastmod_kwrds)
) {
	// Indicate that we're serving a cached version
	header('X-Cached: 1');

	// Serve cached version
	ob_start();
	ob_start('ob_gzhandler');
	echo file_get_contents($_SERVER['SCRIPT_FILENAME'].'._c');
	ob_end_flush();
	header('Content-Length: '.ob_get_length());
	ob_end_flush();
	flush();

	// And we're done. Goodbye.
	die;
}

// No cache? Let's build the page, then.
require_once('func.php');

// Indicate that we're serving a generated version
header('X-Cached: 0');

// Stuff lastmod
$lastmod_obj->{$path} = $lastmod;
file_put_contents($_SERVER['DOCUMENT_ROOT'].
 '/lastmod.json', prettyPrint(json_encode($lastmod_obj)));

// Build out sitemap and menu
$nav           = '<ul class="nav">';
$menu          = '<ul class="menu">';
$section       = '';
$link          = '';
$empty_nav     = true;
$empty_menu    = true;
$empty_section = true;
$active        = false;
$level         = 0;
$menu_level    = 0;
$menu_exclude  = array(); // Exclude menu from keywords;

foreach ($sitemap as $i => $sitemap_page) {
    if (property_exists($sitemap_page, 'nomenu')) continue;

	if ($path === $sitemap_page->path) {
		$active = true;
	} else {
		$active = false;
	}

	$link = '<li><'.(
	 $active ? 'span' : 'a href="'.$sitemap_page->path.'"'.(
	  $sitemap_page->target
	   ? ' target="'.preg_replace('/"/u', "''", $sitemap_page->target).'"'
	   : '').(
	  $sitemap_page->title
	   ? ' title="'.preg_replace('/"/u', "''", $sitemap_page->title).'"'
	   : '')
	 ).'>'.htmlspecialchars($sitemap_page->menu, ENT_COMPAT | ENT_HTML5).
	 '</'.($active ? 'span' : 'a').'>';

	if ($sitemap_page->level == 1) {
		$menu_exclude[] = $sitemap_page->menu;
		if ($empty_section) $section = $sitemap_page->section;
		if ($empty_nav) {
			$empty_nav = false;
		} else {
			$nav .= '</li>';
		}
		$nav .= $link;
	} elseif ($sitemap_page->level > 1) {
		if ($empty_menu) {
			$empty_menu = false;
		} else {
			if ($sitemap_page->level > $level) {
				$menu .= '<ul>';
			} elseif ($sitemap_page->level < $level) {
				$menu .= str_repeat('</li></ul>', $level - $sitemap_page->level).'<ul>';
			}
		}
		$menu .= $link;
		$menu_level = $sitemap_page->level - 1;
	}

	if ($empty_section && $path == $sitemap_page->path) $empty_section = false;

	$level = $sitemap_page->level;
}

$nav  .= '</ul>';
$menu .= str_repeat('</li></ul>', $menu_level);

if ($empty_nav)     $nav     = false;
if ($empty_menu)    $menu    = false;
if ($empty_section) $section = false;

// Build a page title
if (!property_exists($page, 'title') || !$page->title) {
	if ($path === '/') {
		$page->title = 'Home';
	} else {
		$page->title = str_replace('-', ' ',
		 preg_replace('/(\/([^\/]+\/)*)/', '', $path));
	}
}

// Set values for meta tags
if (!property_exists($page, 'author') || !$page->author)
	$page->author = "KeywordCMS";

$page->noindex = (!property_exists($page, 'noindex') || !$page->noindex) ?
 '' : 'no';

$page->nofollow = (!property_exists($page, 'nofollow') || !$page->nofollow) ?
 '' : 'no';

$page->robots = $page->noindex.'index,'.$page->nofollow.'follow';

$inc = $_SERVER['DOCUMENT_ROOT'].'/inc/'.$tpl.'/';

// Function to minify our HTML. We like performance, right?
function minify_html($ob) {
	return preg_replace('/\s+/u', ' ', preg_replace('/[\r\n\t]+/u', '', $ob));
}

// Dump our current buffer, which should be empty anyway, and start a new one
ob_end_clean();
ob_start('minify_html');

// Require our document and template heads
require('html_head.php');
require($tpl.'/head.php');
// Everything else happens elsewhere!
