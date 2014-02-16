<?php if (!isset($tpl)) {header("HTTP/1.0 404 Not Found"); die();} ?>
    </div>
	<div id="footer" class="cf">
		<?php if ($nav) echo($nav); ?>

		<div class="copyright">
			<p>&copy;2014 Keith Bronstrup. All rights reserved. Contact: <a href="mailto:keith@bronstrup.com" title="Contact Keith">keith@bronstrup.com</a></p>
		</div>
	</div>
</div>
<?php require($_SERVER['DOCUMENT_ROOT'].'/inc/html_foot.php');
