<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'New/Edit History');
$page_header = ($playing_field > 0 ? 'EDIT ATHLETIC HISTORY' : 'NEW ATHLETIC HISTORY');

//declare variables
$recordID = $selection;
$date = date('m/d/Y');
$year = '';
$sport = 'L';
$description = '';
$description_label = 'List achievements:';

//set action link
$params = get_all_get_params(array('p', 'a')).'&a=s';
$href_action = set_href(FILENAME_ADMIN_ATHLETICS, $params);

$message = '';
if($action != ''){
	switch($action){
		case 's':
			//retrieve POST variables
			$recordID = $_POST['recordID'];
			$date = $db->db_sanitize($_POST['date']);
			$year = $_POST['year'];
			$sport = $_POST['sport'];
			$description = $db->db_sanitize($_POST['description']);
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
					$sql_data_array = array('date' => $date,
											'year' => $year,
											'sport' => $sport,
											'description' => $description,
											'modifiedBy' => $_SESSION['user_id'],
											'modified' => 'now'
											);
					$param = 'reference='.$recordID;
					$message = $db->db_write_array('playerAthletics', $sql_data_array, 'update', $param);
				}else{
					$sql_data_array = array('reference' => NULL,
											'playerMasterRef' => $playerMasterRef,
											'date' => $date,
											'year' => $year,
											'sport' => $sport,
											'description' => $description,
											'modifiedBy' => $_SESSION['user_id'],
											'created' => 'now',
											'modified' => 'now'
											);
					$message = $db->db_write_array('playerAthletics', $sql_data_array);
					$recordID = $db->db_insert_id();
				}
			}
			//proceed
			if($message == ''){
				$params = get_all_get_params(array('p', 'se', 'a'));
				redirect(set_href(FILENAME_ADMIN_ATHLETICS, $params));
			}
			break;
	}
}

if($recordID > 0){
	$sql = 'SELECT date, year, sport, description
			FROM playerAthletics
			WHERE reference='.$recordID;
	$entry = $db->db_query($sql);
	$date = $entry->field['date'];
	$year = $entry->field['year'];
	$sport = $entry->field['sport'];
	$description = $entry->field['description'];
	$date = date('m/d/Y', strtotime($date));
	$description_label = ($descritpion == 'L' ? 'List achievements:' : 'List sport(s), position(s), achievements:');
}
?>