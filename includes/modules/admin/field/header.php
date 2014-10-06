<?php
//test privileges
test_privileges(1);
//set headers
$masthead_logo = MASTHEAD_ADMIN_FIELD;
if($_SESSION['user_affiliation'] == 'Administrator'){
	$tpl_menubar = MENUBAR_ADMIN3;
}else{
	$tpl_menubar = MENUBAR_ADMIN2;
}
define('PAGE_TITLE', 'Fields');
define('PAGE_HEADER', 'FIELD MAINTENANCE');

$fieldRef = $playing_field;
if($state != ''){
	$params = 'f=0&sn='.$state.'&nmh=1';
}else{
	$params = 'f=0&nmh=1';
}
$href_new = set_href(FILENAME_ADMIN_FIELD_NEW, $params);

$message = '';
if($action != ''){
	switch($action){
		case 'd':
			//test for active subscription
			$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//delete record
			if($message == ''){
				$sql = 'DELETE FROM sites
						WHERE fieldRef='.$fieldRef;
				$message = $db->db_write($sql);
			}
			//proceed
			if($message == ''){
				$params = 'sn='.$state;
				redirect(set_href(FILENAME_ADMIN_FIELD, $params));
			}
			break;
	}
}
if($state != ''){
	$sql = 'SELECT fieldRef, town, name, type, directions
			FROM sites
			WHERE state=\''.$state.'\'
			ORDER BY town, name';
	$fields = $db->db_query($sql);
}
?>