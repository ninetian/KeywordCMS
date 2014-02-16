<?php if (!isset($tpl)) {header("HTTP/1.0 404 Not Found"); die;} ?>
<script type="text/javascript" src="//use.typekit.net/pda8moz.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
</body>
</html><?php $ob = preg_replace('/[\r\n\t]+/u', '', ob_get_clean());

// Stuff keywords, stripping javascript and some other stuff. Wish this was cleaner.
$ok = preg_split('/\s/u',
	preg_replace('/[,;]+\s*/u', ', ',
		preg_replace('/[^\w\d\',;-]+/u', ' ',
			mb_convert_case(
				html_entity_decode(
					preg_replace(
						'/(<script.+<\/script>)|(<[^<]+>)|(<\!--)|(-->)/ui', ' ',
						 $ob
					),
				 ENT_COMPAT | ENT_HTML5),
				MB_CASE_LOWER, 'UTF-8')
		)
	),
-1, PREG_SPLIT_NO_EMPTY);

// Include our excludes... hehe...
require_once('keyword_excludes.php');

// Initialize...
$kw        = new stdClass;
$kw->count = count($ok);
$kw->one   = array();
$kw->two   = array();
$kw->three = array();
$kw->four  = array();

/*
 Initiate spaghetti-mess. This can probably be optimized and/or done recursively.

 Select 1-to-4-word keywords totaling at-least 12 words in length. Less than 12
 words may be used if there is not enough content on the page.

 While it may look somewhat complex, this code should be rather self-documenting.

 TODO: Look into optimizing this...
*/
foreach ($ok as $i => $word) {
    // Process one-word keyword
	$add1 = true;
	foreach ($keyword_excludes as $kword) {
		if ($add1
		 && (preg_replace('/,/u', '', $word) == $kword
		  || metaleven($word, $kword) < 75))
			$add1 = false;
		if (!$add1) break;
	}
	if ($add1) $kw->one[] = $word;

    // Process two-word keyword
	if ($i <= $kw->count-2) {
		$add1 = $add2 = true;
		foreach ($keyword_excludes as $kword) {
			if ($add1
			 && (preg_replace('/,/u', '', $word) == $kword
			  || metaleven($word, $kword) < 75))
				$add1 = false;
			if ($add2
			 && (preg_replace('/,/u', '', $ok[$i+1]) == $kword
			  || metaleven($ok[$i+1], $kword) < 75))
				$add2 = false;
			if (!$add1 && !$add2) break;
		}
		if ($add1 || $add2) {
			$kw_tmp = implode(' ', array($word, $ok[$i+1]));
			if (!preg_match($exclude_regex, $kw_tmp)) {
				if ($add1) $kw->two[] = preg_replace('/,$/u', '', preg_replace('/, /u', ',', $kw_tmp));
				if ($add2) $kw->two[] = preg_replace('/,$/u', '', preg_replace('/, /u', ',', $kw_tmp));
			}
		}
	}

    // Process 3-word keyword
	if ($i <= $kw->count-3) {
		$add1 = $add2 = $add3 = true;
		foreach ($keyword_excludes as $kword) {
			if ($add1
			 && (preg_replace('/,/u', '', $word) == $kword
			  || metaleven($word, $kword) < 75))
				$add1 = false;
			if ($add2
			 && (preg_replace('/,/u', '', $ok[$i+1]) == $kword
			  || metaleven($ok[$i+1], $kword) < 75))
				$add2 = false;
			if ($add3
			 && (preg_replace('/,/u', '', $ok[$i+2]) == $kword
			  || metaleven($ok[$i+2], $kword) < 75))
				$add3 = false;
			if (!$add1 && !$add2 && !$add3) break;
		}
		if ($add1 || $add2 || $add3) {
			$kw_tmp = implode(' ', array($word, $ok[$i+1], $ok[$i+2]));
			if (!preg_match($exclude_regex, $kw_tmp)
			 && strpos($menu_exclude, $kw_tmp) === false) {
				if ($add1) $kw->three[] = preg_replace('/,$/u', '', preg_replace('/, /u', ',', $kw_tmp));
				if ($add2) $kw->three[] = preg_replace('/,$/u', '', preg_replace('/, /u', ',', $kw_tmp));
				if ($add3) $kw->three[] = preg_replace('/,$/u', '', preg_replace('/, /u', ',', $kw_tmp));
			}
		}
	}

    // Process 4-word keyword
	if ($i <= $kw->count-4) {
		$add1 = $add2 = $add3 = $add4 = true;
		foreach ($keyword_excludes as $kword) {
			if ($add1
			 && (preg_replace('/,/u', '', $word) == $kword
			  || metaleven($word, $kword) < 75))
				$add1 = false;
			if ($add2
			 && (preg_replace('/,/u', '', $ok[$i+1]) == $kword
			  || metaleven($ok[$i+1], $kword) < 75))
				$add2 = false;
			if ($add3
			 && (preg_replace('/,/u', '', $ok[$i+2]) == $kword
			  || metaleven($ok[$i+2], $kword) < 75))
				$add3 = false;
			if ($add4
			 && (preg_replace('/,/u', '', $ok[$i+3]) == $kword
			  || metaleven($ok[$i+3], $kword) < 75))
				$add4 = false;
			if (!$add1 && !$add2 && !$add3 && !$add4) break;
		}
		if ($add1 || $add2 || $add3 || $add4) {
			$kw_tmp = implode(' ', array($word, $ok[$i+1], $ok[$i+2], $ok[$i+3]));
			if (!preg_match($exclude_regex, $kw_tmp)
			 && strpos($menu_exclude, $kw_tmp) === false) {
				if ($add1) $kw->four[] = preg_replace('/,$/u', '', preg_replace('/, /u', ',', $kw_tmp));
				if ($add2) $kw->four[] = preg_replace('/,$/u', '', preg_replace('/, /u', ',', $kw_tmp));
				if ($add3) $kw->four[] = preg_replace('/,$/u', '', preg_replace('/, /u', ',', $kw_tmp));
				if ($add4) $kw->four[] = preg_replace('/,$/u', '', preg_replace('/, /u', ',', $kw_tmp));
			}
		}
	}
}

// Count occurrences of each keyword
$kw->one   = array_count_values($kw->one);
$kw->two   = array_count_values($kw->two);
$kw->three = array_count_values($kw->three);
$kw->four  = array_count_values($kw->four);

// Sort by popularity
arsort($kw->one);
arsort($kw->two);
arsort($kw->three);
arsort($kw->four);

// Combine keyword lists, weighting by word count, limiting to 4+ occurrences
$kw_list = array();
foreach ($kw->one as $word => $count) {
	if ($count < 4) break;
	$kw_list[$word] = $count;
}
foreach ($kw->two as $word => $count) {
	if ($count < 4) break;
	$kw_list[$word] = $count*2;
}
foreach ($kw->three as $word => $count) {
	if ($count < 4) break;
	$kw_list[$word] = $count*3;
}
foreach ($kw->four as $word => $count) {
	if ($count < 4) break;
	$kw_list[$word] = $count*4;
}

// Sort by popularity, again
arsort($kw_list);

// Initialize!
$kw      = array();
$kw_used = array();

// Loop through our keyword list until we reach the end or we have 12 words
foreach ($kw_list as $keyword => $count) {
	$words = preg_split('/\s/u', $keyword);

    // Loop through the individual words comprising this keyword
	foreach ($words as $word) {
        // Loop through our list of used words
		foreach ($kw_used as $kword) {
            // Skip this word if it's similar to another used word; weight by length
			$ml = floor(strlen($word.$kword)/5)+1;
			if (metaphone($word, $ml) == metaphone($kword, $ml))
				continue 3;
		}
	}

    // Add the keyword to our keywords list
	$kw[] = $keyword;

    // Add its individual words to our used words list
	$kw_used = array_merge($kw_used, $words);

    // Stop when we reach 12 words
	if (count($kw_used) >= 12) break;
}

// Inject our keywords into the buffer
$ob = str_replace('__PAGE__KEYWORDS__', implode(',', $kw), $ob);

// Stuff cache
file_put_contents($_SERVER['SCRIPT_FILENAME'].'._c', $ob);

// Create new buffer for gzip or deflate
ob_start();
ob_start('ob_gzhandler');
echo $ob ;
ob_end_flush();
header('Content-Length: '.ob_get_length());
ob_end_flush();
flush();

// And we're done. Goodbye. Yes, it's implicit, but I like to be explicit.
die;
