<?php
/*
 Regex to exclude multi-word keywords beginning or ending with certain words
 and phrases with repeating words
*/
$exclude_regex = '/(([^ ]+) \2( |$))|(^(and)|(or) )|( (and)|(the)|(are)|(which)|(how)|(or)$)/u';

// Exclude words found in our menu
$menu_exclude = preg_replace('/[^\w\d\'-]+/u', ' ',
 mb_convert_case(
  html_entity_decode(
   implode(' ', $menu_exclude),
   ENT_COMPAT | ENT_HTML5),
  MB_CASE_LOWER, 'UTF-8')
);

// Explicitly-disallowed words (variants will be picked up, as well)
$keyword_excludes = array(
    // Single Letters
 'a',
 'b',
 'c',
 'd',
 'e',
 'f',
 'g',
 'h',
 'i',
 'j',
 'k',
 'l',
 'm',
 'n',
 'o',
 'p',
 'q',
 'r',
 's',
 't',
 'u',
 'v',
 'w',
 'x',
 'y',
 'z',

    // Wikipedia: Most Common English Words
 'time',
 'person',
 'year',
 'way',
 'day',
 'thing',
 'man',
 'world',
 'life',
 'hand',
 'part',
 'child',
 'eye',
 'woman',
 'place',
 'work',
 'week',
 'case',
 'point',
 'government',
 'company',
 'number',
 'group',
 'problem',
 'fact',
 'be',
 'have',
 'do',
 'say',
 'get',
 'make',
 'go',
 'know',
 'take',
 'see',
 'come',
 'think',
 'look',
 'want',
 'give',
 'use',
 'find',
 'tell',
 'ask',
 'work',
 'seem',
 'feel',
 'try',
 'leave',
 'call',
 'good',
 'new',
 'first',
 'last',
 'long',
 'great',
 'little',
 'own',
 'other',
 'old',
 'right',
 'big',
 'high',
 'different',
 'small',
 'large',
 'next',
 'early',
 'young',
 'important',
 'few',
 'public',
 'bad',
 'same',
 'able',
 'to',
 'of',
 'in',
 'for',
 'on',
 'with',
 'at',
 'by',
 'from',
 'up',
 'about',
 'into',
 'over',
 'after',
 'beneath',
 'under',
 'above',
 'the',
 'and',
 'a',
 'that',
 'i',
 'it',
 'not',
 'he',
 'as',
 'you',
 'this',
 'but',
 'his',
 'they',
 'her',
 'she',
 'or',
 'an',
 'will',
 'my',
 'one',
 'all',
 'would',
 'there',
 'their',

    // Other undesirable words; these will vary by site. E.g. - DIY
 'its',
 'it\'s',
 'was',
 'basically',
 'just',
 'factor',
 'many',
 'thats',
 'header',
 'footer',
 'sidebar',
 'allowing',
 '2013',
 '2014',
 '2015',
 '2016',
 '2017',
 '2018',
 '2019',
 '2020',
 'all',
 'rights',
 'reserved',
 'com'
);
