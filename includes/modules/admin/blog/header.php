<?php
//test privileges
test_privileges(1);
//set headers
$masthead_logo = MASTHEAD_ADMIN_BLOG;
	$tpl_menubar = MENUBAR_ADMIN2;
define('PAGE_TITLE', 'Coach\'s Corner');
define('PAGE_HEADER', 'BLOG MAINTENANCE');

$type = '';
$date = '';
$title = '';
$modified_date = '';

$params = 'tmr='.$teamMasterRef.'&br=0&nmh=1';
$href_new = set_href(FILENAME_ADMIN_BLOG_NEW, $params);

$message = '';
if($action != ''){
	switch($action){
		case 'd':
			if($blog_ref > 0){
				//test for active subscription
				$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
				//delete records
				if($message == ''){
					$sql = 'DELETE FROM blog
							WHERE blogRef='.$blog_ref;
					$message = $db->db_write($sql);
					$sql = 'DELETE FROM coachLetters
							WHERE reference='.$blog_ref;
					$message .= $db->db_write($sql);
				}
				//proceed
				if($message == ''){
					$params = 'tmr='.$teamMasterRef;
					redirect(set_href(FILENAME_ADMIN_BLOG, $params));
				}
			}
			break;
	}
}

if($teamMasterRef > 0){
	$sql = 'SELECT reference, type, date, title, modified
			FROM coachLetters
			WHERE teamMasterRef='.$teamMasterRef.'
			ORDER BY date DESC';
	$blogs = $db->db_query($sql);
}
?>