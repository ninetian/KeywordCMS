<?php $tpl = 'default';
$page = new stdClass;
$page->title = 'About KeywordCMS';
$page->subtitle = 'Why would I want to use your silly little CMS?';

require($_SERVER['DOCUMENT_ROOT'].'/inc/site.php');
?>
    <p>KeywordCMS is a simple flatfile CMS geared towards developers who just need to throw up simple sites for their projects. It leverages both client- and server-side caching, as well as HTML minification and gzip/deflate compression to ensure fast performance with minimal resource usage. The template engine is, well, there is no template engine; header, footer, sidebar, popout, and other predefined content files are simply pulled in with PHP include() statements, allowing you to structure your content however you see fit, or plug in your own template engine, if that's what floats your boat. Not least of all is the namesake feature of KeywordCMS, automated keyword selection.</p>

    <p>Automated keyword selection scans the content of your site, utilizing a list of excluded words (by default, single letters and the most common English words, but you can always add to this) and a tweakable RegEx that removes phrases beginning with common words like "and" and "or", or ending in words like "the", "but", or "which". It then automatically determines which keywords are most relevant to your content and adds them to the appropriate pages. Since many search engines factor correlation between meta keywords and actual page content, this is, statistically speaking, the best method by which to select keywords. It also leads to some amusing selections, which you can tweak away, either by adding words or phrases to the exclusions list, or by rewording your content so that it contains more instances of the keywords you wish to target.</p>

    <p>This is keyword selection and SEO that is both automated <em>and</em> organic. What's not to love?</p>

    <p>The true power of KeywordCMS comes from its simplicity. It's basically just a machine that assembles your pages, packages them up nicely, gives them reasonable expiration dates, and delivers them to your users in a timely fashion. As much functionality was left out as reasonably could be so you can take this simple core and make it whatever you need it to be, without having to strip out a bunch of cruft. This holds true whether you need a simple framework for a small site or you plan on hosting several, hundreds, or even thousands of sites with a database-driven back-end. The entire CMS is comprised of less than 1000 lines of "real" code; even the complex parts are compact and simple.</p>

    <h3>Why <em>wouldn't</em> you want to use my silly little CMS?</h3>

    <p>Perhaps you're not a developer; no real effort was put into making this lay-person friendly, so if you're not at least passingly familiar with PHP, KeywordCMS is probably not for you; <em>but a CMS built on KeywordCMS might be</em>. Really, that's the only reason I can think of! If you <em>are</em> a developer and you don't want to use KeywordCMS, perhaps we have differing definitions of the word "use". Are you sure you don't want to use automated keyword generation? Feel free to rip that code right out or KeywordCMS and use it in your own project; it's MIT-licensed, so there's nothing at all stopping you; go ahead, give the search engines what they want!</p>
<?php  require($inc.'foot.php');
