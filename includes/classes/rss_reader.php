<?php
class rss_reader{
	/*************************************************************
	VARIABLE DECLARATION
	*************************************************************/
	var $parser;
	var $buffer = '';
	var $eof = false;
	var $item = 0;
	var $max_items = 0;
	
	var $channel_test = false;
	var $item_test = false;
	var $data_test = false;
	var $image_test = false;
	var $tag_end_test = true;
	var $channel_end_test = false;
	
	var $tag = '';
	var $channel_title = '';
	var $channel_link = '';
	var $item_title = '';
	var $item_link = '';
	var $item_type = '';
	var $item_pub_date = '';
	var $item_description = '';
	var $item_enclosure = '';
	
	/*************************************************************
	CONSTRUCTOR
	*************************************************************/
	function rss_reader($href, $max_items){
		if($this->test_function()){
			$this->create_parser();
			$this->set_handler();
			$this->set_data_handler();
			$this->set_max_items($max_items);
			$this->read_data($href);
			$this->clear_parser();
		}else{
			$this->error_no_function();
		}
	}
	
	/*************************************************************
	ACTION FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	READ FILE
	------------------------------------------------------------*/
	function read_data($href){
		ini_set('user_agent', 'Mozilla: (compatible; Windows XP)');
		if(!$handle = @fopen($href, "rb")){
			$this->error_no_open();
		}else{
			$this->buffer = '';
			while($this->buffer = fread($handle, 4096)){
				$this->eof = false;
				if(feof($handle)){
					$this->eof = true;
				}
				if(!$this->parse_data()){
					$this->xml_error();
					break;
				}
			}
			fclose($handle);
		}
	}
	
	
	/*------------------------------------------------------------
	PARSE DATA
	------------------------------------------------------------*/
	function parse_data(){
		return xml_parse($this->parser, $this->buffer, $this->eof);
	}
	
	/*************************************************************
	HANDLER FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	TAG HANDLER
	------------------------------------------------------------*/
	function tag_handler($p, $b){
		//1. set tag to lowercase
		$this->tag = strtolower($this->tag);
		
		//2. test for and load channel data
		//ignore image tags with same names
		if($this->channel_test && !$this->image_test){
			switch($this->tag){
				case 'title':
					$this->channel_title .= $b;
					break;
				case 'link':
					$this->channel_link .= $b;
					break;
			}
		}
		
		//3. test for and load item data
		if($this->item_test){
			switch($this->tag){
				case 'title':
					$this->item_title .= $b;
					break;
				case 'link':
					$this->item_link .= $b;
					break;
				case 'description':
					$this->item_description .= $b;
					break;
				case 'pubdate':
					$this->item_pub_date .= $b;
					break;
			}
		}
		
		//4. for self-closing tags, set tag-end flag to 'true' if eof
		if(!$this->data_test && !$this->tag_end_test){
			$this->tag_end_test = true;
		}
		$this->data_test = true;
	}

	/*------------------------------------------------------------
	START HANDLER
	------------------------------------------------------------*/
	function start_handler($p, $element, $attributes){
		//1. set tag name to lowercase
		$element = strtolower($element);
		
		//2. test for channel tag
		if($this->channel_test){
			$this->tag = $element;
		}elseif($element == 'channel'){
			$this->channel_test = true;
			$this->item_test = false;
			$this->channel_end_test = false;
		}
		if($element == 'image'){
			$this->image_test = true;
			$this->item_test = false;
		}
		
		//3. test for item tag
		if($this->item_test){
			$this->tag = $element;
		}elseif($element == 'item'){
			$this->item_test = true;
		}
		
		//4. get url for laxCast mpegs
		if(count($attributes) > 0){
			while(list($key, $value) = each($attributes)){
				$key = strtolower($key);
				if($key == 'url' || $key == 'link' || $key == 'enclosure'){
					$this->item_link = $value;
					$this->item_link = str_replace('sml_uploadsI', 'sml_uploads/I', $this->item_link);
				}elseif($key == 'type'){
					$this->item_type = $value;
				}
			}
		}
		
		//5. set flags
		$this->tag_end_test = false;
		$this->data_test = false;
	}

	/*------------------------------------------------------------
	END HANDLER
	------------------------------------------------------------*/
	function end_handler($p, $element){
		//1. set tag name to lowercase
		$element = strtolower($element);
		
		//2. test for channel tag
		if($this->channel_test && !$this->item_test && $element == 'title'){
			$channel_title = htmlspecialchars(trim($this->channel_title));
			if($this->channel_link != ''){
				$channel_href = trim($this->channel_link);
				$string = "\t\t\t".'<div class="rssHeader"><a href="'.$channel_href.'">'.$channel_title.'</a></div>'."\n\t\t\t".'<div class="rssContainer">'."\n";
			}else{
				$string = "\t\t\t".'<div class="rssHeader">'.$channel_title.'</div>'."\n\t\t\t".'<div class="rssContainer">'."\n";
			}
			echo $string;
			$this->channel_link = '';
			$this->channel_title = '';
			$this->channel_test = false;
			$this->image_test = false;
		}
		
		//3. test for item tag
		if($element == 'item' && $this->item < $this->max_items){
			$item_title = htmlspecialchars(trim($this->item_title));
			$item_href = trim($this->item_link);
			$pub_date = '';
			if($this->item_pub_date != ''){
				$pub_date = date('l, F j, Y g:i a', strtotime($this->item_pub_date));
			}
			echo "\t\t\t\t".'<div class="rssTitle"><a href="'.$item_href.'">'.$item_title.'</a></div>'."\n\t\t\t\t".'<div class="rssDate">'.$pub_date.'</div>'."\n";
			$this->item_link = '';
			$this->item_title = '';
			$this->item_pub_date = '';
			$this->item_description = '';
			$this->item_test = false;
			$this->item++;
		}
		
		//4. close channel div tag
		if($element == 'channel'){
			$this->channel_end_test = true;
			if($this->item > 0){
				echo "\t\t\t".'</div>'."\n";
			}
		}elseif($element == 'item' && $this->channel_end_test && $this->item == $this->max_items){
			//for xml docs that end the channel tag before the item 
			//tags start (e.g. collegeLax)
			$this->item++;
			echo "\t\t\t".'</div>'."\n";
		}
		
		//5. close tag
		if($this->data_test){
			$this->tag_end_test = true;
		}
		$this->data_test = false;
	}
	
	/*************************************************************
	OTHER FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	TEST FUNCTION
	------------------------------------------------------------*/
	function test_function(){
		return function_exists('xml_parser_create');
	}
	
	/*------------------------------------------------------------
	CREATE PARSER
	------------------------------------------------------------*/
	function create_parser(){
		$this->parser = xml_parser_create();
		xml_set_object($this->parser, $this);
	}
	
	/*------------------------------------------------------------
	SET HANDLERS
	------------------------------------------------------------*/
	function set_handler(){
		xml_set_element_handler($this->parser, 'start_handler', 'end_handler');
	}
	
	/*------------------------------------------------------------
	DEFINE DATA HANDLER
	------------------------------------------------------------*/
	function set_data_handler(){
		xml_set_character_data_handler($this->parser, 'tag_handler');
	}
	
	/*------------------------------------------------------------
	SET NUMBER OF ITEMS IN CHANNEL LIST
	------------------------------------------------------------*/
	function set_max_items($items = 10){
		$this->max_items = $items;
	}
	
	/*------------------------------------------------------------
	CLEAR PARSER MEMORY
	------------------------------------------------------------*/
	function clear_parser(){
		xml_parser_free($this->parser);
	}
	
	/*************************************************************
	ERROR FUNCTIONS
	*************************************************************/
	/*------------------------------------------------------------
	XML FUNCTIONS DO NOT EXIST
	------------------------------------------------------------*/
	function error_no_function(){
		echo "\t\t\t".'<div class="rssHeader">Failed to load PHP\'s XML Extension.</div>'."\n";
	}

	/*------------------------------------------------------------
	CANNOT OPEN FILE
	------------------------------------------------------------*/
	function error_no_open(){
		echo "\t\t\t".'<div class="rssHeader">Error reading RSS data.</div>'."\n";
	}
	
	/*------------------------------------------------------------
	XML ERROR
	------------------------------------------------------------*/
	function xml_error(){
		$error = xml_error_string(xml_get_error_code($this->parser));
		$line = xml_get_current_line_number($this->parser);
		echo "\t\t\t\t".'<div class="rssTitle">'.'XML error: '.$error.' at line '.$line.'</div>'."\n\t\t\t".'</div>'."\n";
	}
}
?>