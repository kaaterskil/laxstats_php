<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'New/Edit Team');
$team_name = '';
$town = '';
$short_name = '';
$state_abbrev = '';
$conference = '';
$league = '';
$division = '';
$type = '';
$gender = '';

$params = 'tmr='.$teamMasterRef.'&nmh=1&a=s';
$href_action = set_href(FILENAME_ADMIN_TEAM_NEW, $params);

$message = '';
if($action != ''){
	if($action == 's'){
		//retrieve variables
		$teamMasterRef	= $_POST['teamMasterRef'];
		$town			= $db->db_sanitize($_POST['town']);
		$team_name		= $db->db_sanitize($_POST['team_name']);
		$short_name		= $db->db_sanitize($_POST['short_name']);
		$gender			= $_POST['gender'];
		$type			= $_POST['type'];
		$state_abbrev	= $_POST['state'];
		$conference		= $db->db_sanitize($_POST['conference']);
		$league			= $db->db_sanitize($_POST['league']);
		$division		= $db->db_sanitize($_POST['division']);
		
		//validate
		$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
		if($message == ''){
			$message .= (empty($town) ? ERROR_NO_TOWN : '');
			$message .= (empty($conference) ? ERROR_NO_CONFERENCE : '');
		}
		if($message == ''){
			$sql = 'SELECT teamMasterRef
					FROM teamsMaster
					WHERE town=\''.$town.'\'
						AND state=\''.$state_abbrev.'\'
						AND teamName=\''.$team_name.'\'
						AND type=\''.$type.'\'
						AND gender=\''.$gender.'\'
						AND teamMasterRef!='.$teamMasterRef;
			$test = $db->db_query($sql);
			if(isset($test->result['teamMasterRef'])){
				$message = ERROR_DUPLICATE_TEAM;
			}
		}
		
		//write to disk
		if($message == ''){
			if($teamMasterRef > 0){
				$sql_data_array = array('teamName' => $team_name,
										'town' => $town,
										'shortName' => $short_name,
										'state' => $state_abbrev,
										'conference' => $conference,
										'league' => $league,
										'division' => $division,
										'type' => $type,
										'gender' => $gender,
										'modifiedBy' => $_SESSION['user_id'],
										'modified' => 'now'
										);
				$param = 'teamMasterRef='.$teamMasterRef;
				$message = $db->db_write_array('teamsMaster', $sql_data_array, 'update', $param);
			}else{
				$sql_data_array = array('teamMasterRef' => NULL,
										'teamName' => $team_name,
										'town' => $town,
										'shortName' => $short_name,
										'state' => $state_abbrev,
										'conference' => $conference,
										'league' => $league,
										'division' => $division,
										'type' => $type,
										'gender' => $gender,
										'modifiedBy' => $_SESSION['user_id'],
										'created' => 'now',
										'modified' => 'now'
										);
				$message = $db->db_write_array('teamsMaster', $sql_data_array, 'insert', '');
			}
		}
		
		//proceed
		if($message == ''){
			$params = 'tmr='.$teamMasterRef.'&nmh=1&ct=1';
			redirect(set_href(FILENAME_ADMIN_TEAM_NEW, $params));
		}
	}
}

//retrieve data
if($teamMasterRef > 0){
	$sql = 'SELECT teamName, town, shortName, state, conference, league, division, type, gender
			FROM teamsMaster
			WHERE teamMasterRef='.intval($teamMasterRef);
	$team = $db->db_query($sql);
	$team_name		= $team->field['teamName'];
	$town			= $team->field['town'];
	$short_name		= $team->field['shortName'];
	$state_abbrev	= $team->field['state'];
	$conference		= $team->field['conference'];
	$league			= $team->field['league'];
	$division		= $team->field['division'];
	$type			= $team->field['type'];
	$gender			= $team->field['gender'];
}
$page_header = ($teamMasterRef > 0 ? 'EDIT TEAM' : 'NEW TEAM');
?>