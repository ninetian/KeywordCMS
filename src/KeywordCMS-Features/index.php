<?php $tpl = 'default';
$page = new stdClass;
$page->title = 'KeywordCMS Features';
$page->subtitle = 'What\'s this thing do, anyway?';

require($_SERVER['DOCUMENT_ROOT'].'/inc/site.php');
?>
	<p>Features? You want your CMS to have features? Fine, I'll give you a few of those, but only the ones best suited to optimizing your search rankings and the speed at which your pages are served. Here's what you get:</p>

    <ul>
        <li>
            <h3>Automated Keyword Selection</h3>
            <p>Take the guesswork out of SEO keyword selection; KeywordCMS scans your page content and chooses the best keywords for you. At first glance, the keywords and phrases it selects may not look like the best choices, but they're statistically the most relevant terms on the page. If KeywordCMS picks a keyword you <em>really</em> don't like, you can add it to the excluded words list and KeywordCMS will pick something else, instead.</p>
        </li>
        <li>
            <h3>Content Minification</h3>
            <p>KeywordCMS will automatically strip any excess whitespace, including carriage returns, newlines, and tabs, from your HTML, reducing the overall size of the data being transferred. <em>(There is a known issue with &lt;pre&gt; tags. I don't make use of &lt;pre&gt; tags on any site currently using KeywordCMS, so this was not a development priority for me; now that I've released KeywordCMS, be assured that a fix will come soon).</em></p>
        </li>
        <li>
            <h3>Flexible Menuing System</h3>
            <p>Build out your site's structure in simple JSON. Whether you have just a handful of pages, or need a complex menu that's nested several levels deep; KeywordCMS's menu builder will generate a beautifully-nested &lt;ul&gt;/&lt;li&gt; menu.</p>
        </li>
        <li>
            <h3>XML Sitemap Generation</h3>
            <p>The same JSON that defines your menu can also be used to automatically generate an XML sitemap for your site, including change frequency and priority values. Want a page to show up in your sitemap, but not your menu? There's a tag for that!</p>
        </li>
        <li>
            <h3>CMS-Enforced gzip/Deflate Compression</h3>
            <p>Transport compression not enabled on your server? No worries, KeywordCMS makes use of PHP's built-in gzip/Deflate compression to automatically send out compressed data to clients that support it.</p>
        </li>
        <li>
            <h3>Super-Fast Server-Side Caching</h3>
            <p>Every page is cached as soon as it is generated and that cached copy is served up for all subsequent requests, until the page is updated. Have a page with dynamic content? You can turn the cache off on a page-by-page basis <em>(manual keyword selection coming soon for these pages)</em>, though you should consider loading this content asynchronously, so you can take full advantage of the cache.</p>
        </li>
        <li>
            <h3>Sane Default Cache Headers</h3>
            <p>KeywordCMS will automatically set Expires: headers, based on sitemap change frequency. The cache header will automatically be set to 1/4 of the change frequency, or 10 seconds if one is not specified.</p>
        </li>
        <li>
            <h3>Easy Extensibility</h3>
            <p>Because KeywordCMS isn't its own framework and doesn't bring a bunch of extra features along, you are free to choose whatever back-end, template engine, or other libraries you wish to extend it with. You can even wrap KeywordCMS around a database-driven back-end; or just use it as-is, if you prefer hand-coding your own HTML <em>(this is what I do)</em>.</p>
        </li>
    </ul>
<?php  require($inc.'foot.php');
