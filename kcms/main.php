<?php /* KeywordCMS Main Process */
/*
 TODO:
 Config (load configuration)
 Source (interface with content source)
 Sitemap (generate a flat sitemap)
    Nav (generate a nested navigation menu)
 Render (render HTML page from template collection)
 Buffer (base class for output-buffer-based functions)
    Keyword (select keywords from text, inject into <head>)
    Minify (remove unnecessary whitespace)
    Cache (implement cache scheme similar to proof-of-concept)
    Deflate (handle deflate based on request headers)
 */

namespace kcms;

spl_autoload_register(function ($class) {
	if (preg_match('~^kcms\\\([^\\\].+$)~', $class, $matches)) {
		include 'bin/' . $matches[1] . '.php';
	}
});

