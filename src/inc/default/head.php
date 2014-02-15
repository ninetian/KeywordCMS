<?php if (!isset($tpl)) {header("HTTP/1.0 404 Not Found"); die();} ?>
<div id="page">
	<div id="header">
		<div id="logo">
			<a href="/">
				<img class="logo" src="/img/logo_web_retina.png" alt="" title="KewyordCMS Logo">
			</a>
			<h3>
				<a href="/">
					KeywordCMS
				</a>
			</h3>
			<h4>
				<a href="/">
					Simplified SEO
				</a>
			</h4>
		</div>
		<?php if ($nav) echo($nav); ?>
	</div>

	<div id="content" class="left">
		<h1 class="page_title">
			<?php echo($page->title); ?>
		</h1>
		<?php if (property_exists($page, 'subtitle')) { ?>
			<h2 class="sub_title">
				<?php echo($page->subtitle); ?>
			</h2>
		<?php } ?>
