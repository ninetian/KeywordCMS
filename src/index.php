<?php $tpl = 'default';
$page = new stdClass;
$page->title = 'KeywordCMS Demo';
$page->subtitle = 'Simplified SEO';

require($_SERVER['DOCUMENT_ROOT'].'/inc/site.php');
?>
	<p>Thank you for your interest in KeywordCMS! If you're looking for a simple, small, lightweight file-based CMS, your search is over! KeywordCMS doesn't bring along a template engine or, really, any back-end features; what it offers is an awesome file-based caching scheme, content minification, a flexible menu system, and automated keyword generation, which you can wrap around the back-end of your choice, or use as-is.</p>

    <p>SEO is important for any website, but not every website owner has the time or knowledge to select the correct keywords, least of all developers, who often have deadlines to meet and, even when they don't, have to find time to keep up with emerging technologies. That's where KeywordCMS comes in; KeywordCMS analyzes your content and picks the statistical best keywords and phrases to ensure that search engines find a high correlation between your page content and meta keywords.</p>

    <p>The core of KeywordCMS is a simple flatfile CMS, written in less than 1000 lines of PHP. Its strength lies in its simplicity, which allows you to easily use it as a jumping-off point for a much more capable system, or to just as easily "borrow" the keyword selection functionality (it's MIT-licensed) for your own project.</p>

    <h3>Why was KeywordCMS made?</h3>

    <p>I have been toying with the idea of automatic keyword selection for years, but was always too busy to actually implement it. Recently, I needed a website for a project I was (and still am) working on. I wanted that site to be served up quickly and efficiently; much more quickly than any consumer-ready off-the-shelf CMS; and I wanted to spend as little time as possible on SEO. I wanted to be able to write some decent copy and have it stand in its own. A few hundred lines later, I had KeywordCMS; after another few hundred lines, I had a simple website for my project, with the most relevant keywords already selected.</p>

    <h3>Does it really work?</h3>

    <p>I've used it on a <a href="http://aralarinda.com">single site</a> (two, if you count this demo), consisting of three pages, for a project that has not yet been released, so I really can't say. What I can say is that this simple site, for this unfinished project, ranks on the first page out of over 30 million results for at least <a href="https://www.google.com/search?q=secure+messaging+where+i+control+the+keys">one set of targeted keywords</a>; organically, with no external promotion.</p>
<?php  require($inc.'foot.php');
