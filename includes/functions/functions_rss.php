<?php
function startElement($parser, $tagName, $attrs){
	global $dataOn, $tagEnd, $itemOn, $channelOn;
	global $tag, $title, $link, $enclosure, $date, $description, $channelTitle, $channelLink;
	//FOUR FLAGS ARE USED TO TEST XML ELEMENTS:
	//DATAON - TESTS WHETHER DATA IS BEING READ. INITIALIZE TO FALSE
	//TAGEND - TESTS WHETHER AN END TAG HAS BEEN IDENTIFIED AND CLOSED - INITIALIZE TO FALSE
	//CHANNELON - TESTS WHETHER A CHANNEL TAG HAS BEEN FOUND (FOR FEED NAMES)
	//ITEMON - TESTS WHETHER AN ITEM TAG HAS BEEN FOUND (FOR STORY HEADLINES)
	
	//1. TEST FOR CHANNEL TAG
	$tagName = strtolower($tagName);
	if($channelOn){
		$tag = $tagName;
	}elseif($tagName == 'channel'){
		$channelOn = true;
	}
	//2. TEST FOR ITEM TAG
	if($itemOn){
		$tag = $tagName;
	}elseif($tagName == 'item'){
		$itemOn = true;
	}
	//3. PICK UP URL FOR LAXCAST MPGS
	if(count($attrs)){
		while(list($key, $value) = each($attrs)){
			$key = strtolower($key);
			if($key == 'url' || $key == 'link'){
				$link = $value;
				//$link = str_replace("%20", ' ', $link);
				$link = str_replace("sml_uploadsI", "sml_uploads/I", $link);
			}elseif($key == 'type'){
				$type = $value;
			}
		}
	}
	//4. SET DATAON AND TAGEND FLAGS
	$tagEnd = false;
	$dataOn = false;
}

function endElement($parser, $tagName){
	global $dataOn, $tagEnd, $itemOn, $channelOn;
	global $tag, $title, $link, $enclosure, $date, $description, $channelTitle,$channelLink, $j;
	
	$tagName = strtolower($tagName);
	
	//1. TEST FOR CHANNEL TAG
	//PRINT FEED INFORMATION AND SET CHANNELON FLAG TO FALSE
	//SO THIS ROUTINE WON'T REPRINT FOR OTHER TAGS INSIDE THE CHANNEL TAG
	if($channelOn && !$itemOn && $tagName == 'title'){
		if($channelLink != ''){
			printf("\t<div class=\"rssHeader\"><a href=\"%s\">%s</a></div>\n\t<div class=\"rssContainer\">\n", trim($channelLink), htmlspecialchars(trim($channelTitle)));
		}else{
			printf("\t<div class=\"rssHeader\">%s</div>\n\t<div class=\"rssContainer\">\n", htmlspecialchars(trim($channelTitle)));
		}
		$channelLink = '';
		$channelTitle = '';
		$channelOn = false;
	}
	
	//2. TEST FOR ITEM TAG
	//READ ONLY FIRST 5 STORIES
	//PRINT STORY HEADLINE INFORMATION AND SET ITEM ITEMON FLAG TO FALSE
	if($tagName =='item' && $j < 6){
		$date = date('l, F j, Y g:i a', strtotime($date));
		printf("\t\t<div class=\"rssTitle\"><a href=\"%s\">%s</a></div>\n", trim($link), htmlspecialchars(trim($title)));
		printf("\t\t<div class=\"rssDate\">%s</div>\n", $date);
		//printf("<b>%s</b><br>\n",htmlspecialchars(trim($description)));
		$link = '';
		$title = '';
		$date = '';
		$description = '';
		$itemOn = false;
		$j++;
	}
	
	//3. TEST FOR AND CLOSE STORY HEADLINE CONTAINER DIV
	if($tagName == 'channel'){
		print "\t</div>\n";
	}
	
	//4. SET TAGEND FLAG TO TRUE (END TAG HAS BEEN FOUND)
	if($dataOn){
		$tagEnd = true;
	}
	
	//5. SET DATAON FLAG TO FALSE (NO MORE DATA TO PRINT)
	$dataOn = false;
	//print "&lt;/<font style=\"color:#0000cc\">$tagName</font>&gt;<br>\n";
}

function characterData($parser, $data){
	global $dataOn, $tagEnd, $itemOn, $channelOn;
	global $tag, $title, $link, $enclosure, $date, $description, $channelTitle, $channelLink;
	//1. TEST FOR AND LOAD CHANNEL VARIABLES
	$tag = strtolower($tag);
	if($channelOn){
		switch($tag){
			case 'title':
				$channelTitle .= $data;
				break;
			case 'link':
				$channelLink .= $data;
				break;
		}
	}
	
	//2. TEST FOR AND LOAD ITEM VARIABLES
	if($itemOn){
		switch($tag){
			case 'title':
				$title .= $data;
				break;
			case 'link':
				$link .= $data;
				break;
			case 'description':
				$description .= $data;
				break;
			case 'pubdate':
				$date .= $data;
				break;
		}
	}
	
	//3. SET TAGEND FLAG TO TRUE IF NO MORE DATA TO READ (FOR SELF-CLOSING TAGS)
	if(!$dataOn && !$tagEnd){
		//print "&gt;";
		$tagEnd = true;
	}
	//print $data;
	$dataOn = true;
}

/*------------------------------------------------------------
WRITES HTML FOR LAXPOWER 'RSS' FEED
------------------------------------------------------------*/
function laxPowerRSS(){
?>
	<!-- bof laxpower feed -->
	<div class="rssHeader"><a href="http://www.laxpower.com">LaxPower Headlines</a></div>
	<div class="rssContainer">
<?php
	//1. open web page
	$url = 'http://www.laxpower.com/index.php';
	ini_set('user_agent', 'Mozilla: (compatible; Windows XP)');
	$handle = @fopen($url, "rb");
	if(!$handle){
?>
		<div class="rssTitle2">Error accessing LaxPower.</div>
	</div>
<?php
		return false;
	}
	//2. read web page
	$buffer = '';
	while(!feof($handle)){
		$buffer .= fread($handle, 65536);
	}
	fclose($handle);
	
	//3. discard unnecessary code
	$start = '<p style="margin-left: 6px">';
	$end = '</div><br>';
	$start_pos = strpos($buffer, $start);
	$end_pos = strpos($buffer, $end, $start_pos);
	if($start_pos > 0 && $end_pos > 0){
		if($end_pos > $start_pos){
			$length = $end_pos - $start_pos;
			$string = substr($buffer, $start_pos, $length);
			
			//4. test for stories
			$stories = array();
			$parts = preg_split('/<p style\=\"margin-left: 6px\"><a href\=\"laxnews\/news.php\?/', $string, 15);
			if(count($parts) > 0){
				//5. build array of headlines and story ids
				for($i = 0; $i < count($parts); $i++){
					if(strlen($parts[$i]) > 0){
						$start_pos	= strpos($parts[$i], ">") + 1;
						$end_pos	= strpos($parts[$i], "<");
						$length		= $end_pos - $start_pos;
						$ref		= substr($parts[$i], 6, 4);
						$headline	= substr($parts[$i], $start_pos, $length);
						$stories[]	= array('ref' => $ref,
											'headline' => $headline
											);
					}
				}
				//6. print results
				for($i = 0; $i < count($stories); $i++){
?>
		<div class="rssTitle2"><a href="http://www.laxpower.com/laxnews/news.php?story=<?php echo $stories[$i]['ref']; ?>"><?php echo $stories[$i]['headline']; ?></a></div>
<?php
				}
			}else{
?>
		<div class="rssTitle2">No stories found.</div>
<?php
			}
		}else{
?>
		<div class="rssTitle2">Error: Invalid delimiters: Start: <?php echo $start_pos; ?>; End: <?php echo $end_pos; ?></div>
<?php
		}
	}else{
?>
		<div class="rssTitle2">The LaxPower news system appears to be down. Please try again later.</div>
<?php
	}
?>
	</div>
	<!-- eof laxpower feed -->

<?php
}
?>