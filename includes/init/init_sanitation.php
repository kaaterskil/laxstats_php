<?php
//process GET terms
$pattern = '[<>\']';
if(isset($_GET) && count($_GET) > 0){
	foreach($_GET as $key => $value){
		if(is_array($value)){
			foreach($value as $key2 => $value2){
				$_GET[$key][$key2] = preg_replace($pattern, '', $value2);
			}
		}else{
			$_GET[$key] = preg_replace($pattern, '', $value);
		}
	}
}

//process POST terms
$pattern = '[<>]';
if(isset($_POST) && count($_POST) > 0){
	foreach($_POST as $key => $value){
		if(is_array($value)){
			foreach($value as $key2 => $value2){
				if(is_array($value2)){
					foreach($value2 as $key3 => $value3){
						$_POST[$key][$key2][$key3] = preg_replace($pattern, '', $value3);
					}
				}else{
					$_POST[$key][$key2] = preg_replace($pattern, '', $value2);
				}
			}
		}else{
			if($key != 'blog_text'){
				$_POST[$key] = preg_replace($pattern, '', $value);
			}
		}
	}
}

//assign GET terms to variables
$action				= (isset($_GET['a']) ? $_GET['a'] : '');
$blog_ref			= (isset($_GET['br']) ? $_GET['br'] : 0);
$conference			= (isset($_GET['c']) ? html_entity_decode($_GET['c']) : '');
$close_popup_test	= (isset($_GET['ct']) ? $_GET['ct'] : 0);
$error				= (isset($_GET['e']) ? $_GET['e'] : '');
$edit_test			= (isset($_GET['et']) ? $_GET['et'] : false);
$playing_field		= (isset($_GET['f']) ? $_GET['f'] : 0);
$gameRef			= (isset($_GET['gr']) ? $_GET['gr'] : 0);
$month				= (isset($_GET['m']) ? $_GET['m'] : '');
$no_masthead		= (isset($_GET['nmh']) ? $_GET['nmh'] : false);
$offsetY			= (isset($_GET['sc']) ? $_GET['sc'] : 0);
$page_ref			= (isset($_GET['p']) ? $_GET['p'] : '');
$playerMasterRef	= (isset($_GET['pmr']) ? $_GET['pmr'] : 0);
$playerRef			= (isset($_GET['pr']) ? $_GET['pr'] : 0);
$password			= (isset($_GET['pt']) ? $_GET['pt'] : '');
$recordID			= (isset($_GET['r']) ? $_GET['r'] : 0);
$season				= (isset($_GET['s']) ? $_GET['s'] : '');
$selection			= (isset($_GET['se']) ? $_GET['se'] : '');
$sortCode			= (isset($_GET['st']) ? $_GET['st'] : '');
$staffRef			= (isset($_GET['sr']) ? $_GET['sr'] : 0);
$state				= (isset($_GET['sn']) ? $_GET['sn'] : '');
$teamMasterRef		= (isset($_GET['tmr']) ? $_GET['tmr'] : 0);
$teamRef			= (isset($_GET['tr']) ? $_GET['tr'] : 0);
$type				= (isset($_GET['ty']) ? $_GET['ty'] : '');
$userRef			= (isset($_GET['ur']) ? $_GET['ur'] : 0);
?>