<?php if (!isset($tpl)) {header("HTTP/1.0 404 Not Found"); die;} ?><!DOCTYPE html>
<html>
<head>
	<title>Simplified SEO | KeywordCMS | <?php echo($page->title); ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="<?php echo $page->author; ?>">
	<meta name="robots" content="<?php echo $page->robots; ?>">
	<meta name="keywords" content="__PAGE__KEYWORDS__">

	<link rel="icon" href="/favicon.png" type="image/png">

	<link rel="stylesheet" href="/css/default.css" type="text/css">
</head>
<body>
