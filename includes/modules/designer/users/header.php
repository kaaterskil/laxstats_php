<?php
//test privileges
test_privileges(0);
//set headers
$masthead_logo = MASTHEAD_ADMIN_DESIGNER_HOME;
$tpl_menubar = MENUBAR_ADMIN3;
define('PAGE_TITLE', 'Users');

$params = get_all_get_params(array('p', 'a')).'&ur=0&nmh=1';
$href_new = set_href(FILENAME_ADMIN_USERS_NEW, $params);

$message = '';
if($action != ''){
	if($action == 'd'){
		//test for self
		if($userRef == $_SESSION['user_id']){
			$message = 'You can\'t delete yourself.';
		}
		//delete record
		if($message == ''){
			$sql = 'DELETE FROM users
					WHERE userRef='.$userRef;
			$message = $db->db_write($sql);
		}
		//proceed
		if($message == ''){
			$params = get_all_get_params(array('p', 'a', 'ur'));
			redirect(set_href(FILENAME_ADMIN_USERS, $params));
		}
	}
}

$sql = 'SELECT userRef, IF(FName!=\'\', CONCAT_WS(\' \', FName, LName), LName) AS user_name, affiliation, phone, email, username, password, userIP, created
		FROM users
		ORDER BY affiliation, LName';
$users = $db->db_query($sql);
?>