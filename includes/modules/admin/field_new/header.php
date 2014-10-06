<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'New/Edit Field');
$page_header = ($playing_field > 0 ? 'EDIT FIELD' : 'NEW FIELD');

$fieldRef = $playing_field;
$town = '';
$name = '';
$type = '';
$directions = '';

$params = 'nmh=1&a=s';
$href_action = set_href(FILENAME_ADMIN_FIELD_NEW, $params);

$message = '';
if($action != ''){
	switch($action){
		case 's':
			//retrieve POST variables
			$fieldRef = $_POST['fieldRef'];
			$state = $_POST['state'];
			$type = $_POST['type'];
			$town = $db->db_sanitize($_POST['town']);
			$name = $db->db_sanitize($_POST['name']);
			$directions = $db->db_sanitize($_POST['directions']);
			//test for active subscription
			$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//validate
			if($message == '' && $fieldRef == 0){
				//test for duplicate
				$sql = 'SELECT COUNT(fieldRef) AS duplicates
						FROM sites
						WHERE town=\''.$town.'\'
							AND name=\''.$name.'\'';
				$test = $db->db_query($sql);
				if($test->field['duplicates'] > 0){
					$message = 'That playing field already exists.';
				}
			}
			//write to disk
			if($message == ''){
				if($fieldRef == 0){
					$sql_data_array = array('fieldRef' => NULL,
											'state' => $state,
											'town' => $town,
											'name' => $name,
											'type' => $type,
											'directions' => $directions,
											'modifiedBy' => $_SESSION['user_id'],
											'created' => 'now',
											'modified' => 'now'
											);
					$message = $db->db_write_array('sites', $sql_data_array);
					$fieldRef = $db->db_insert_id();
				}else{
					$sql_data_array = array('state' => $state,
											'town' => $town,
											'name' => $name,
											'type' => $type,
											'directions' => $directions,
											'modifiedBy' => $_SESSION['user_id'],
											'modified' => 'now'
											);
					$param = 'fieldRef='.$fieldRef;
					$message = $db->db_write_array('sites', $sql_data_array, 'update', $param);
				}
				//proceed
				if($message == ''){
					$params = 'f='.$fieldRef.'&sn='.$state.'&nmh=1';
					redirect(set_href(FILENAME_ADMIN_FIELD_NEW, $params));
				}
			}
			break;
	}
}
if($fieldRef > 0){
	$sql = 'SELECT state, town, name, type, directions
			FROM sites
			WHERE fieldRef='.$fieldRef;
	$fields = $db->db_query($sql);
	$state = $fields->field['state'];
	$town = $fields->field['town'];
	$name = $fields->field['name'];
	$type = $fields->field['type'];
	$directions = $fields->field['directions'];
	$name = ($name != '' ? $name : 'HS');
	$type = ($type != '' ? $type : 'U');
}
?>