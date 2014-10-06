<?php
$masthead_logo = MASTHEAD_ERROR;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Error');

$message = '';
if($error != ''){
	switch($error){
		case 1:
			$message = 'Sorry dude, but you either tried to access a secure area or your session timed out. Please log into the Manager\'s Office to resume your session. ';
			break;
		case 2:
			$message = 'Sorry dude, but you don\'t have privileges to enter that area. ';
			break;
		case 3:
			$message = 'Sorry dude, that was a bad password.';
	}
}
?>