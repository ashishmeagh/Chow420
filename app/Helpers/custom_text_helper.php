<?php 

 function truncate_html($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true)
	{
		if ($considerHtml) {
			// if the plain text is shorter than the maximum length, return the whole text
			if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			// splits all html-tags to scanable lines
			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';
			foreach ($lines as $line_matchings) {
				// if there is any html-tag in this line, handle it and add it (uncounted) to the output
				if (!empty($line_matchings[1])) {
					// if it's an "empty element" with or without xhtml-conform closing slash
					if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
						// do nothing
					// if tag is a closing tag
					} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
						// delete tag from $open_tags list
						$pos = array_search($tag_matchings[1], $open_tags);
						if ($pos !== false) {
						unset($open_tags[$pos]);
						}
					// if tag is an opening tag
					} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
						// add tag to the beginning of $open_tags list
						array_unshift($open_tags, strtolower($tag_matchings[1]));
					}
					// add html-tag to $truncate'd text
					$truncate .= $line_matchings[1];
				}
				// calculate the length of the plain text part of the line; handle entities as one character
				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				if ($total_length+$content_length> $length) {
					// the number of characters which are left
					$left = $length - $total_length;
					$entities_length = 0;
					// search for html entities
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
						// calculate the real length of all entities in the legal range
						foreach ($entities[0] as $entity) {
							if ($entity[1]+1-$entities_length <= $left) {
								$left--;
								$entities_length += strlen($entity[0]);
							} else {
								// no more characters left
								break;
							}
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
					// maximum lenght is reached, so get off the loop
					break;
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}
				// if the maximum length is reached, get off the loop
				if($total_length>= $length) {
					break;
				}
			}
		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}
		// if the words shouldn't be cut in the middle...
		if (!$exact) {
			// ...search the last occurance of a space...
			$spacepos = strrpos($truncate, ' ');
			if (isset($spacepos)) {
				// ...and cut the text in this position
				$truncate = substr($truncate, 0, $spacepos);
			}
		}
		// add the defined ending to the text
		$truncate .= $ending;
		if($considerHtml) {
			// close all unclosed html-tags
			foreach ($open_tags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}


	if(!function_exists('meta_keywords_transform'))
	{
		function meta_keywords_transform($str = ''){
				
				$string = $str;
			
			 $stopWords = [
				    'a',
				    'about',
				    'above',
				    'above',
				    'across',
				    'after',
				    'afterwards',
				    'again',
				    'against',
				    'all',
				    'almost',
				    'alone',
				    'along',
				    'already',
				    'also',
				    'although',
				    'always',
				    'am',
				    'among',
				    'amongst',
				    'amoungst',
				    'amount',
				    'an',
				    'and',
				    'another',
				    'any',
				    'anyhow',
				    'anyone',
				    'anything',
				    'anyway',
				    'anywhere',
				    'are',
				    'around',
				    'as',
				    'at',
				    'back',
				    'be',
				    'became',
				    'because',
				    'become',
				    'becomes',
				    'becoming',
				    'been',
				    'before',
				    'beforehand',
				    'behind',
				    'being',
				    'below',
				    'beside',
				    'besides',
				    'between',
				    'beyond',
				    'bill',
				    'both',
				    'bottom',
				    'but',
				    'by',
				    'call',
				    'can',
				    'cannot',
				    'cant',
				    'co',
				    'con',
				    'could',
				    'couldnt',
				    'cry',
				    'de',
				    'describe',
				    'detail',
				    'do',
				    'done',
				    'down',
				    'due',
				    'during',
				    'each',
				    'eg',
				    'eight',
				    'either',
				    'eleven',
				    'else',
				    'elsewhere',
				    'empty',
				    'enough',
				    'etc',
				    'even',
				    'ever',
				    'every',
				    'everyone',
				    'everything',
				    'everywhere',
				    'except',
				    'few',
				    'fifteen',
				    'fify',
				    'fill',
				    'find',
				    'fire',
				    'first',
				    'five',
				    'for',
				    'former',
				    'formerly',
				    'forty',
				    'found',
				    'four',
				    'from',
				    'front',
				    'full',
				    'further',
				    'get',
				    'give',
				    'go',
				    'had',
				    'has',
				    'hasnt',
				    'have',
				    'he',
				    'hence',
				    'her',
				    'here',
				    'hereafter',
				    'hereby',
				    'herein',
				    'hereupon',
				    'hers',
				    'herself',
				    'him',
				    'himself',
				    'his',
				    'how',
				    'however',
				    'hundred',
				    'ie',
				    'if',
				    'in',
				    'inc',
				    'indeed',
				    'interest',
				    'into',
				    'is',
				    'it',
				    'its',
				    'itself',
				    'keep',
				    'last',
				    'latter',
				    'latterly',
				    'least',
				    'less',
				    'ltd',
				    'made',
				    'many',
				    'may',
				    'me',
				    'meanwhile',
				    'might',
				    'mill',
				    'mine',
				    'more',
				    'moreover',
				    'most',
				    'mostly',
				    'move',
				    'much',
				    'must',
				    'my',
				    'myself',
				    'name',
				    'namely',
				    'neither',
				    'never',
				    'nevertheless',
				    'next',
				    'nine',
				    'no',
				    'nobody',
				    'none',
				    'noone',
				    'nor',
				    'not',
				    'nothing',
				    'now',
				    'nowhere',
				    'of',
				    'off',
				    'often',
				    'on',
				    'once',
				    'one',
				    'only',
				    'onto',
				    'or',
				    'other',
				    'others',
				    'otherwise',
				    'our',
				    'ours',
				    'ourselves',
				    'out',
				    'over',
				    'own',
				    'part',
				    'per',
				    'perhaps',
				    'please',
				    'put',
				    'rather',
				    're',
				    'same',
				    'see',
				    'seem',
				    'seemed',
				    'seeming',
				    'seems',
				    'serious',
				    'several',
				    'she',
				    'should',
				    'show',
				    'side',
				    'since',
				    'sincere',
				    'six',
				    'sixty',
				    'so',
				    'some',
				    'somehow',
				    'someone',
				    'something',
				    'sometime',
				    'sometimes',
				    'somewhere',
				    'still',
				    'such',
				    'system',
				    'take',
				    'ten',
				    'than',
				    'that',
				    'the',
				    'their',
				    'them',
				    'themselves',
				    'then',
				    'thence',
				    'there',
				    'thereafter',
				    'thereby',
				    'therefore',
				    'therein',
				    'thereupon',
				    'these',
				    'they',
				    'thickv',
				    'thin',
				    'third',
				    'this',
				    'those',
				    'though',
				    'three',
				    'through',
				    'throughout',
				    'thru',
				    'thus',
				    'to',
				    'together',
				    'too',
				    'top',
				    'toward',
				    'towards',
				    'twelve',
				    'twenty',
				    'two',
				    'un',
				    'under',
				    'until',
				    'up',
				    'upon',
				    'us',
				    'very',
				    'via',
				    'was',
				    'we',
				    'well',
				    'were',
				    'what',
				    'whatever',
				    'when',
				    'whence',
				    'whenever',
				    'where',
				    'whereafter',
				    'whereas',
				    'whereby',
				    'wherein',
				    'whereupon',
				    'wherever',
				    'whether',
				    'which',
				    'while',
				    'whither',
				    'who',
				    'whoever',
				    'whole',
				    'whom',
				    'whose',
				    'why',
				    'will',
				    'with',
				    'within',
				    'without',
				    'would',
				    'yet',
				    'you',
				    'your',
				    'yours',
				    'yourself',
				    'yourselves',
				    'the',
				];
 
		      $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
		      $string = trim($string); // trim the string
		      $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
		      $string = strtolower($string); // make it lowercase
		 
		      preg_match_all('/\b.*?\b/i', $string, $matchWords);
		      $matchWords = $matchWords[0];
		 
		      foreach ( $matchWords as $key=>$item ) {
		          if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
		              unset($matchWords[$key]);
		          }
		      }   
		      $wordCountArr = array();
		      if ( is_array($matchWords) ) {
		          foreach ( $matchWords as $key => $val ) {
		              $val = strtolower($val);
		              if ( isset($wordCountArr[$val]) ) {
		                  $wordCountArr[$val]++;
		              } else {
		                  $wordCountArr[$val] = 1;
		              }
		          }
		      }
		      arsort($wordCountArr);
		      $wordCountArr = array_slice($wordCountArr, 0, 10);
		      return implode(",",array_keys($wordCountArr));
		}
	}