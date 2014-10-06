<?php
//test privileges
test_privileges(0);
define('PAGE_TITLE', 'New/Edit Foul');
$page_header = ($playerRef > 0 ? 'EDIT VIOLATION' : 'NEW VIOLATION');

$recordID = $selection;
$type = '';
$description = '';
$releasable = '';

$params = 'nmh=1&a=s';
$href_action = set_href(FILENAME_ADMIN_FOULS_NEW, $params);

$message = '';
if($action != ''){
	if($action == 's'){
		//retrieve POST variables
		$recordID = $_POST['foulRef'];
		$type = $_POST['type'];
		$description = $db->db_sanitize($_POST['description']);
		$releasable = (isset($_POST['releasable']) ? 'T' : 'F');
		//validate
		if(empty($description)){
			$message = 'You must enter a description. ';
		}
		if($recordID == 0){
			$sql = 'SELECT COUNT(*) AS duplicates
					FROM fouls
					WHERE description=\''.$description.'\'';
			$test = $db->db_query($sql);
			if($test->field['duplicates'] > 0){
				$message .= 'That description is already being used.';
			}
		}
		//write to disk
		if($message == ''){
			if($recordID > 0){
				$sql_data_array = array('type' => $type,
										'description' => $description,
										'releasable' => $releasable,
										'modifiedBy' => $_SESSION['user_id'],
										'modified' => 'now'
										);
				$param = 'reference='.$recordID;
				$message = $db->db_write_array('fouls', $sql_data_array, 'update', $param);
			}else{
				$sql_data_array = array('reference' => NULL,
										'type' => $type,
										'description' => $description,
										'releasable' => $releasable,
										'modifiedBy' => $_SESSION['user_id'],
										'created' => 'now',
										'modified' => 'now'
										);
				$message = $db->db_write_array('fouls', $sql_data_array);
				$recordID = $db->db_insert_id();
			}
		}
		//proceed
		if($message == ''){
			$params = 'se='.$recordID.'&nmh=1';
			redirect(set_href(FILENAME_ADMIN_FOULS_NEW, $params));
		}
	}
}

if($recordID > 0){
	$sql = 'SELECT type, description, releasable
			FROM fouls
			WHERE reference='.$recordID;
	$fouls = $db->db_query($sql);
	$type = $fouls->field['type'];
	$description = $fouls->field['description'];
	$releasable = $fouls->field['releasable'];
}
?>