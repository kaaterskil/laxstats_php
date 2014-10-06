<?php
//test privileges
test_privileges(0);
//set headers
$masthead_logo = MASTHEAD_ADMIN_DESIGNER_HOME;
$tpl_menubar = MENUBAR_ADMIN3;
define('PAGE_TITLE', 'Fouls');

$params = get_all_get_params(array('p', 'a', 'se')).'&se=0&nmh=1';
$href_new = set_href(FILENAME_ADMIN_FOULS_NEW, $params);

$message = '';
if($action != ''){
	if($action == 'd'){
		$sql = 'DELETE FROM fouls
				WHERE reference='.$selection;
		$message = $db->db_write($sql);
		if($message == ''){
			$params = get_all_get_params(array('p', 'a', 'se'));
			redirect(set_href(FILENAME_ADMIN_FOULS, $params));
		}
	}
}

$sql = 'SELECT reference, description, type, releasable
		FROM fouls
		ORDER BY description';
$fouls = $db->db_query($sql);
?>