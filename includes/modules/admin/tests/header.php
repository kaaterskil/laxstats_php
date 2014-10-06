<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'New/Edit History');
$page_header = ($playing_field > 0 ? 'EDIT ACADEMIC HISTORY' : 'NEW ACADEMIC HISTORY');

//declare variables
$recordID = $selection;
$date = date('m/d/Y');
$year = '';
$semester = '';
$gpa = '';
$gpaMax = '4.00';
$rank = '';
$classes = '';
$activities = '';
$major = '';
$colleges = '';

//set action link
$params = get_all_get_params(array('p', 'a')).'&a=s';
$href_action = set_href(FILENAME_ADMIN_ACADEMICS, $params);

$message = '';
if($action != ''){
	switch($action){
		case 's':
			//retrieve POST variables
			$recordID = $_POST['recordID'];
			$date = $db->db_sanitize($_POST['date']);
			$year = $_POST['year'];
			$semester = $_POST['semester'];
			$gpa = $db->db_sanitize($_POST['gpa']);
			$gpaMax = $db->db_sanitize($_POST['gpaMax']);
			$rank = $_POST['rank'];
			$classes = $db->db_sanitize($_POST['classes']);
			$activities = $db->db_sanitize($_POST['activities']);
			$major = $db->db_sanitize($_POST['major']);
			$colleges = $db->db_sanitize($_POST['colleges']);
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
											'semester' => $semester,
											'classes' => $classes,
											'activities' => $activities,
											'gpa' => $gpa,
											'gpaMax' => $gpaMax,
											'rank' => $rank,
											'major' => $major,
											'colleges' => $colleges,
											'modifiedBy' => $_SESSION['user_id'],
											'modified' => 'now'
											);
					$param = 'reference='.$recordID;
					$message = $db->db_write_array('playerAcademics', $sql_data_array, 'update', $param);
				}else{
					$sql_data_array = array('reference' => NULL,
											'playerMasterRef' => $playerMasterRef,
											'date' => $date,
											'year' => $year,
											'semester' => $semester,
											'classes' => $classes,
											'activities' => $activities,
											'gpa' => $gpa,
											'gpaMax' => $gpaMax,
											'rank' => $rank,
											'major' => $major,
											'colleges' => $colleges,
											'modifiedBy' => $_SESSION['user_id'],
											'created' => 'now',
											'modified' => 'now'
											);
					$message = $db->db_write_array('playerAcademics', $sql_data_array);
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
	$sql = 'SELECT date, year, semester, classes, activities, gpa, gpaMax, rank, major, colleges
			FROM playerAcademics
			WHERE reference='.$recordID;
	$entry = $db->db_query($sql);
	$date = $entry->field['date'];
	$year = $entry->field['year'];
	$semester = $entry->field['semester'];
	$classes = $entry->field['classes'];
	$activities = $entry->field['activities'];
	$gpa = $entry->field['gpa'];
	$gpaMax = $entry->field['gpaMax'];
	$rank = $entry->field['rank'];
	$major = $entry->field['major'];
	$colleges = $entry->field['colleges'];
	$date = date('m/d/Y', strtotime($date));
}
?>