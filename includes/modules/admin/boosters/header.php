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
define('PAGE_TITLE', 'Fans');
define('PAGE_HEADER', 'FANS');

if($teamMasterRef > 0){
	$sql = 'SELECT IF(FName!=\'\', CONCAT_WS(\' \', FName, LName), LName) AS name, street1, street2, city, state, zip, phone, email, userIP, created
			FROM people
			WHERE teamMasterRef='.$teamMasterRef.'
			ORDER BY LName, FName';
}else{
	$sql = 'SELECT IF(FName!=\'\', CONCAT_WS(\' \', FName, LName), LName) AS name, street1, street2, city, state, zip, phone, email, userIP, created
			FROM people
			ORDER BY LName, FName';
}
$fans = $db->db_query($sql);
?>