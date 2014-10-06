<?php

/**********************************************************************
COMMON FUNCTIONS
**********************************************************************/
/*----------------------------------------------------------------------
GET DOMAIN
----------------------------------------------------------------------*/
function get_top_level_domain($url){
	if(strpos($url, '://')){
		$url = parse_url($url);
		$url = $url['host'];
	}
	$domain_array = explode('.', $url);
	$domain_size = count($domain_array);
	if($domain_size > 1){
		if(is_numeric($domain_array[$domain_size-2]) && is_numeric($domain_array[$domain_size-1])){
			return false;
		}else{
			if($domain_size > 3){
				return $domain_array[$domain_size-3].'.'.$domain_array[$domain_size-2].'.'.$domain_array[$domain_size-1];
			}else{
				return $domain_array[$domain_size-2].'.'.$domain_array[$domain_size-1];
			}
		}
	}else{
		return false;
	}
}

/*----------------------------------------------------------------------
REDIRECT
----------------------------------------------------------------------*/
function redirect($url, $replace = true){
	global $request_type;
	if($request_type == 'SSL' && ENABLE_SSL == true){
		//change protocol
		if(substr($url, 0, strlen(HTTP_SERVER)) == HTTP_SERVER){
			$url = HTTPS_SERVER.substr($url, strlen(HTTP_SERVER));
		}
	}
	
	header('Location: '.$url, $replace);
	exit;
}

/*----------------------------------------------------------------------
TEST FOR VALUE
----------------------------------------------------------------------*/
function not_null($value){
	if(is_array($value)){
		if(count($value) > 0){
			return true;
		}else{
			return false;
		}
	}else{
		if((is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)){
			return true;
		}else{
			return false;
		}
	}
}

/*----------------------------------------------------------------------
RETRIEVE USEFUL GET PARAMETERS
----------------------------------------------------------------------*/
function get_all_get_params($exclude_array = ''){
	global $_GET;
	$r = '';
	if($exclude_array == ''){
		$exclude_array = array();
	}elseif(!is_array($exclude_array)){
		$exclude_array = explode(', ', $exclude_array);
	}
	
	reset($_GET);
	while(list($key, $value) = each($_GET)){
		if($key != session_name() && $key != 'error' && !in_array($key, $exclude_array)){
			$r .= $key.'='.$value.'&';
		}
	}
	$r = substr($r, 0, -1);
	return $r;
}

/*----------------------------------------------------------------------
BUILD HTML LINK
----------------------------------------------------------------------*/
function set_href($page = '', $param = '', $connection = 'NONSSL', $add_session_id = true){
	global $request_type, $session_started, $http_domain, $https_domain;
	$r = '';
	
	//test for page
	if(!not_null($page)){
		$page = 'home';
	}
	//set protocol
	if($connection == 'NONSSL'){
		$link = HTTP_SERVER;
	}elseif($connection == 'SSL'){
		if(ENABLE_SSL == true){
			$link = HTTPS_SERVER;
		}else{
			$link = HTTP_SERVER;
		}
	}else{
		die('Error: No server protocol selected.');
	}

	//test for params
	if($page != 'home'){
		if(not_null($param)){
			$link .= 'index.php?p='.$page.'&'.$param;
		}else{
			$link .= 'index.php?p='.$page;
		}
		$separator = '&';
	}else{
		$link .= 'index.php';
	}
	
	//clean-up string
	while(substr($link, -1) == '&' || substr($link, -1) == '?'){
		$link = substr($link, 0, -1);
	}
	
	//add session ID when moving from different HTTP and HTTPS servers
	if($add_session_id == true && $session_started == true){
		if(($request_type == 'NONSSL' && $connection == 'SSL') || ($request_type == 'SSL' && $connection == 'NONSSL')){
			if($http_domain != $https_domain){
				$session_id = session_name().'='.session_id();
			}
		}
	}
	if(isset($session_id)){
		$link .= $separator.$session_id;
	}
	return $link;
}

/*----------------------------------------------------------------------
SET TABLE ROW BACKGROUND COLOR
----------------------------------------------------------------------*/
function set_background($row){
	$even = 'table_row_even';
	$odd = 'table_row_odd';
	$r = ($row % 2 == 0 ? $even : $odd);
	return $r;
}

/*----------------------------------------------------------------------
SET PLAYER NAME
----------------------------------------------------------------------*/
function set_player_name($first_string, $second_string){
	$r = ($first_string != '' ? $first_string.' '.$second_string : $second_string);
	return $r;
}

/*----------------------------------------------------------------------
SET TEAM NAME
----------------------------------------------------------------------*/
function set_team_name($town, $name){
	$r = ($name != '' ? $town.' '.$name : $town);
	return $r;
}

/*----------------------------------------------------------------------
TEST FOR ADMIN LOGIN
----------------------------------------------------------------------*/
function test_privileges($admin_level){
	global $_SESSION;
	if(!isset($_SESSION['user_id'])){
		$params = 'e=1';
		redirect(set_href(FILENAME_ERROR, $params));
	}else{
		if($_SESSION['admin_level'] > $admin_level){
			$params = 'e=2';
			redirect(set_href(FILENAME_ERROR, $params));
		}
	}
}

/*----------------------------------------------------------------------
GET IP ADDRESS
----------------------------------------------------------------------*/
function get_ip_address(){
	if(isset($_SERVER)){
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$r = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif(isset($_SERVER['HTTP_CLIENT_IP'])){
			$r = $_SERVER['HTTP_CLIENT_IP'];
		}else{
			$r = $_SERVER['REMOTE_ADDR'];
		}
	}else{
		if(getenv('HTTP_X_FORWARDED_FOR')){
			$r = getenv('HTTP_X_FORWARDED_FOR');
		}elseif(getenv('HTTP_CLIENT_IP')){
			$r = getenv('HTTP_CLIENT_IP');
		}else{
			$r = getenv('REMOTE_ADDR');
		}
	}
	return $r;
}

/*----------------------------------------------------------------------
GET RANDOM VALUE
----------------------------------------------------------------------*/
function get_random_value($length, $type = 'mixed'){
	if($type != 'mixed' && $type != 'chars' && $type != 'digits'){
		return false;
	}
	$r = '';
	while(strlen($r) < $length){
		if($type == 'digits'){
			$char = get_random_number(0, 9);
		}else{
			$char = chr(get_random_number(0, 255));
		}
		if($type == 'mixed'){
			if(eregi('^[a-z0-9]$', $char)){
				$r .= $char;
			}
		}elseif ($type == 'chars'){
			if(eregi('^[a-z]$', $char)){
				$r .= $char;
			}
		}elseif ($type == 'digits'){
			if(ereg('^[0-9]$', $char)){
				$r .= $char;
			}
		}
	}
	return $r;
}
function get_random_number($min = NULL, $max = NULL){
	static $seeded;
	
	if(!$seeded){
		mt_srand(floatval(microtime()) * 1000000);
		$seeded = true;
	}
	if(isset($min) && isset($max)){
		if($min >= $max){
			return $min;
		}else{
			return mt_rand($min, $max);
		}
	}else{
		return mt_rand();
	}
}

/*----------------------------------------------------------------------
PARSE TEAM SEARCH STRING
----------------------------------------------------------------------*/
function parse_search_string($search_str = '', &$objects){
	$objects = array();
	//convert to lower case and trim whitespace
	$search_str = trim(strtolower($search_str));
	//remove the word 'lacrosse'
	$search_str = ereg_replace('lacrosse', '', $search_str);
	//break into individual words and loop through each one,
	//parsing each item into the objects array
	$parts = split('[[:space:]]+', $search_str);
	for($i = 0; $i < count($parts); $i++){
		if(strlen($parts[$i]) > 0){
			//set aside any nested beginning parens
			while(substr($parts[$i], 0, 1) == '('){
				$objects[] = '(';
				if(strlen($parts[$i]) > 1){
					$parts[$i] = substr($parts[$i], 1);
				}else{
					$parts[$i] = '';
				}
			}
			//set aside any nested ending parens
			$post_objects = array();
			while(substr($parts[$i], -1) == ')'){
				$post_objects[] = ')';
				if(strlen($parts[$i]) > 1){
					$parts[$i] = substr($parts[$i], 0, -1);
				}else{
					$parts[$i] = '';
				}
			}
			//add a cleaned up version of the word to the array
			$objects[] = trim(ereg_replace('"', ' ', $parts[$i]));
			//add the ending parens to the array
			for($j = 0; $j < count($post_objects); $j++){
				$objects[] = $post_objects[$j];
			}
		}
	}
	//evaluate the individual objects
	$keywords = 0;
	$operators = 0;
	$paren_balance = 0;
	for($i = 0; $i < count($objects); $i++){
		if($objects[$i] != NULL && $objects[$i] != ''){
			switch($objects[$i]){
				case '(':
					$paren_balance--;
					break;
				case ')':
					$paren_balance++;
					break;
				case 'and':
				case 'or':
					$operators++;
					break;
				default:
					$keywords++;
			}
		}
	}
	if($operators < $keywords && $paren_balance == 0){
		return true;
	}else{
		return false;
	}
}

/*----------------------------------------------------------------------
BIND VARIABLES TO SEARCH STRING
----------------------------------------------------------------------*/
function bind_variables($sql, $string, $value, $type){
	$r = get_bind_value($value, $type);
	$r = str_replace($string, $r, $sql);
	return $r;
}
function get_bind_value($value, $type){
	$type_array = explode(':', $type);
	$type = $type_array[0];
	switch($type){
		case 'csv':
			$r = $value;
			break;
		case 'pass_through':
			$r = $value;
			break;
		case 'float':
			$r =(not_null($value) || $value == '' || $value == 0 ? 0 : $value);
			break;
		case 'integer':
			$r = intval($value);
			break;
		case 'string':
			$r = '\''.addslashes($value).'\'';
			break;
		case 'no_quote_string':
			$r = addslashes($value);
			break;
		case 'currency':
			$r = '\''.addslashes($value).'\'';
			break;
		case 'date':
			$r = '\''.addslashes($value).'\'';
			break;
		case 'enum':
			$r = '\''.addslashes($value).'\'';
			break;
		default:
			die('Undefined variable type: '.$type.' ('.$value.')');
	}
	return $r;
}

/*----------------------------------------------------------------------
VALIDATE DATE
----------------------------------------------------------------------*/
function validate_date($string){
	$minimum_year = 1900;
	$maximum_year = 2100;
	$month_days_array = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	$parser_array = array('-', ' ', '/', '.');
	$parser_type = -1;
	
	//determine date parser
	for($i = 0; $i < count($parser_array); $i++){
		$parser_position = strpos($string, $parser_array[$i]);
		if($parser_position !== false){
			$parser_type = $i;
			break;
		}
	}
	//split date components
	if($parser_type != -1){
		$date_array = explode($parser_array[$parser_type], $string);
		if(count($date_array) != 3){
			return false;
		}
	}else{
		return false;
	}
	//check year
	$year = (strlen($date_array[2]) == 2 ? intval('20'.strval($date_array[2])) : intval($date_array[2]));
	if($year < $minimum_year || $year > $maximum_year){
		return false;
	}
	//check month
	$month = intval($date_array[0]);
	if($month < 1 || $month > 12){
		return false;
	}
	//check day
	$day = intval($date_array[1]);
	$february_days = get_february_days($year);
	if(($day < 1) || ($day > $month_days_array[$month - 1]) || ($month == 2 && $day > $february_days)){
		return false;
	}
	//reformat date
	$r = $month.'/'.$day.'/'.$year;
	return $r;
}

function get_february_days($year){
	$r = 28;
	if($year % 100 == 0){
		if($year % 400 == 0){
			$r = 29;
		}
	}elseif($year % 4 == 0){
		$r = 29;
	}
	return $r;
}

/*----------------------------------------------------------------------
VALIDATE TIME
returns a timestamp of the date/time
----------------------------------------------------------------------*/
function validate_time($time, $date){
	$date_stamp = strtotime($date);
	$long_pattern = '^([0-9]|[0-1][0-9]|[2][0-3]):?([0-5][0-9])[[:space:]]?([AM|PM|am|pm]{2,2})?$';
	$short_pattern = '^([0-9]|[0-1][0-9]|[2][0-3])[[:space:]]?([AM|PM|am|pm]{2,2})?$';
	//match to long pattern (hh:mm)
	if(ereg($long_pattern, $time, $parts)){
		if(isset($parts[3])){
			$meridian = $parts[3];
			if(($meridian == 'PM' || $meridian == 'pm') && intval($parts[1]) < 12){
				$parts[1] = intval($parts[1]) + 12;
			}
		}
		$v = (intval($parts[1]) * 60 * 60) + (intval($parts[2]) * 60);
	}else{
		//match to short pattern (hh)
		if(ereg($short_pattern, $time, $parts)){
			if(isset($parts[2])){
				$meridian = $parts[2];
				if(($meridian == 'PM' || $meridian == 'pm') && intval($parts[1]) < 12){
					$parts[1] = intval($parts[1]) + 12;
				}
			}
			$v = intval($parts[1]) * 60 * 60;
		}else{
			return false;
		}
	}
	if($v < (60 * 60 * 24)){
		$r = $v + $date_stamp;
		return $r;
	}
	return false;
}

/*----------------------------------------------------------------------
DRAW FIELD DROP-DOWN
----------------------------------------------------------------------*/
function draw_field_select($playing_field, $page_ref){
	global $db;
	$selected_value = 'A';
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '', 'group' => '');
	$sql = 'SELECT f.fieldRef, f.town, f.name, s.name AS state
			FROM sites f
			INNER JOIN states s
			ON (f.state=s.abbrev)
			ORDER BY s.name, f.town';
	$fields = $db->db_query($sql);
	while(!$fields->eof){
		$field_id = $fields->field['fieldRef'];
		$town = $fields->field['town'];
		$name = $fields->field['name'];
		$state = $fields->field['state'];
		
		$field_name = ($name != '' ? $town.' '.$name : $town);
		$param = 'f='.$field_id;
		$href = set_href(FILENAME_FIELD, $param);
		if($field_id == $playing_field){
			$selected_value = $href;
		}
		
		$option_array[] = array('value' => $href,
								'label' => $field_name,
								'group' => $state
								);
		$fields->move_next();
	}
	$onChange = 'changeField(this.options[this.selectedIndex].value);';
	echo 'Field: '.draw_select_element_group('field', $option_array, $selected_value, $onChange);
}

/*----------------------------------------------------------------------
DRAW STATE DROP-DOWN
----------------------------------------------------------------------*/
function draw_state_select($name, $selected_value, $onChange = ''){
	global $db;
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	$sql = 'SELECT name, abbrev
			FROM states
			ORDER BY name';
	$states = $db->db_query($sql);
	while(!$states->eof){
		$state_abbrev = $states->field['abbrev'];
		$state_name = $states->field['name'];
		$option_array[] = array('value' => $state_abbrev,
								'label' => $state_name
								);
		
		$states->move_next();
	}
	echo draw_select_element($name, $option_array, $selected_value, $onChange);
}
function draw_state_select2($name, $selected_value, $onChange = ''){
	global $db;
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	$sql = 'SELECT name, abbrev
			FROM states
			ORDER BY name';
	$states = $db->db_query($sql);
	while(!$states->eof){
		$state_abbrev = $states->field['abbrev'];
		$state_name = $states->field['name'];
		$option_array[] = array('value' => $state_abbrev,
								'label' => $state_abbrev
								);
		
		$states->move_next();
	}
	echo draw_select_element($name, $option_array, $selected_value, $onChange);
}

//--------------------------------------------------/
//TEST FOR CURRENT SUBSCRIPTION
//--------------------------------------------------/
function subscriber_test($user_affiliation, $user_paid_status){
	$r = '';
	if($user_affiliation != 'Administrator' && $user_paid_status != 'T'){
		$r = TEXT_ERROR_NONSUBSCRIBER;
	}
	return $r;
}
?>