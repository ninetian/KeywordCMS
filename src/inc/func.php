<?php
/*
 Pretty-print some JSON.

 We use this to make lastmod.json more readable. It'll probably prove useful
 elsewhere, as well.
*/
function prettyPrint($json) {
	$result = '';
	$level = 0;
	$prev_char = '';
	$in_quotes = false;
	$ends_line_level = NULL;
	$json_length = strlen( $json );

	for( $i = 0; $i < $json_length; $i++ ) {
		$char = $json[$i];
		$new_line_level = NULL;
		$post = "";
		if( $ends_line_level !== NULL ) {
			$new_line_level = $ends_line_level;
			$ends_line_level = NULL;
		}
		if( $char === '"' && $prev_char != '\\' ) {
			$in_quotes = !$in_quotes;
		} else if( ! $in_quotes ) {
			switch( $char ) {
				case '}': case ']':
				$level--;
				$ends_line_level = NULL;
				$new_line_level = $level;
				break;

				case '{': case '[':
				$level++;
				case ',':
					$ends_line_level = $level;
					break;

				case ':':
					$post = " ";
					break;

				case " ": case "\t": case "\n": case "\r":
				$char = "";
				$ends_line_level = $new_line_level;
				$new_line_level = NULL;
				break;
			}
		}
		if( $new_line_level !== NULL ) {
			$result .= "\n".str_repeat( "\t", $new_line_level );
		}
		$result .= $char.$post;
		$prev_char = $char;
	}

	return $result;
}

/*
 Use a combination of metaphone and levenshtein values to determine how similar
 two words are.

 We use this to determine if a word we're looking at is, or is similar to, any
 word or words in out keyword exclusion list.
*/
function metaleven($a, $b) {
	$a = preg_replace('/,-\'/u', '', $a);
	$b = preg_replace('/,-\'/u', '', $b);
	return 100 *
		(max(strlen($a),strlen($b)) / (levenshtein(metaphone($a),metaphone($b))+1));
}
