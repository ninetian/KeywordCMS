<?php header('Content-Type: text/plain'); ?>
User-agent: *
<?php
// Example rule to disallow robots from browsing the 'wwwdev' subdomain
echo (
	 preg_match('/^wwwdev\./', $_SERVER["SERVER_NAME"]) ?
	  'Disa' : 'A'
).'llow: /';
/* Place all global rules below this line */ ?>
