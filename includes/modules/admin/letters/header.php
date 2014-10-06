<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'New/Edit Comment');
$page_header = ($selection > 0 ? 'EDIT COMMENT' : 'NEW COMMENT');

//declare variables
$recordID = $selection;
$date = date('m/d/Y');
$current = 0;
$comments = '';

//set action link
$params = get_all_get_params(array('p', 'a')).'&a=s';
$href_action = set_href(FILENAME_ADMIN_LETTERS, $params);

$message = '';
if($action != ''){
	switch($action){
		case 's':
			//retrieve POST variables
			$recordID	= $_POST['recordID'];
			$current	= $_POST['current'];
			$date		= $db->db_sanitize($_POST['date']);
			$comments	= $db->db_sanitize($_POST['comments']);

			//test for active subscription
			$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			
			//validate
			if($message == ''){
				$result = validate_date($date);
				if($result === false){
					$message = 'Please enter a valid date.';
				}else{
					$date = $result;
				}
			}
			//write to disk
			if($message == ''){
				$date = date('Y-m-d', strtotime($date));
				if($recordID > 0){
					$sql_data_array = array('date'			=> $date,
											'current'		=> $current,
											'comments'		=> $comments,
											'modifiedBy'	=> $_SESSION['user_id'],
											'modified'		=> 'now'
											);
					$param = 'reference='.$recordID;
					$message = $db->db_write_array('playerComments', $sql_data_array, 'update', $param);
				}else{
					$sql_data_array = array('reference'			=> NULL,
											'playerMasterRef'	=> $playerMasterRef,
											'date'				=> $date,
											'current'			=> $current,
											'comments'			=> $comments,
											'modifiedBy'		=> $_SESSION['user_id'],
											'created'			=> 'now',
											'modified'			=> 'now'
											);
					$message = $db->db_write_array('playerComments', $sql_data_array);
					$recordID = $db->db_insert_id();
				}
			}
			//proceed
			if($message == ''){
				$params = get_all_get_params(array('p', 'se', 'a'));
				redirect(set_href(FILENAME_ADMIN_LETTERS, $params));
			}
			break;
	}
}

if($recordID > 0){
	$sql = 'SELECT date, current, comments
			FROM playerComments
			WHERE reference='.$recordID;
	$entry = $db->db_query($sql);
	$date		= $entry->field['date'];
	$current	= $entry->field['current'];
	$comments	= $entry->field['comments'];
	$date		= date('m/d/Y', strtotime($date));
}
?>