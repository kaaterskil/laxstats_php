<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'New/Edit Season');
$page_header = ($teamRef > 0 ? 'EDIT SEASON' : 'NEW SEASON');

$season = date('Y');
$division = '';
$town = '';
$name = '';
$short_name = '';
$type = '';

$params = 'nmh=1&a=s';
$href_action = set_href(FILENAME_ADMIN_SEASON, $params);

$message = '';
if($action != ''){
	if($action == 's'){
		//retrieve POST variables
		$name			= $db->db_sanitize($_POST['name']);
		$season			= $db->db_sanitize($_POST['season']);
		$division		= $db->db_sanitize($_POST['division']);
		$teamMasterRef	= $_POST['teamMasterRef'];
		$teamRef		= ($_POST['teamRef'] != '' ? $_POST['teamRef'] : 0);
		$town			= $_POST['town'];
		$short_name		= $_POST['short_name'];
		$type			= $_POST['type'];
		
		//validation
		$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
		if(empty($season)){
			$message .= 'The season must not be blank. ';
		}
		if(!ereg('^([1][9][0-9][0-9]|[2][0][0-9][0-9])$', $season)){
			$message .= 'Please enter a valid 4-digit year. ';
		}
		if($message == ''){
			$sql = 'SELECT COUNT(*) AS seasons
					FROM teams
					WHERE teamMasterRef='.$teamMasterRef.'
						AND season=\''.$season.'\'
						AND teamRef!='.$teamRef;
			$test = $db->db_query($sql);
			if($test->field['seasons'] > 0){
				$message = 'That season already exists.';
			}
		}
		
		//write to disk
		if($message == ''){
			if($teamRef == 0){
				$sql_data_array = array('teamMasterRef'	=> $teamMasterRef,
										'teamRef'		=> NULL,
										'season'		=> $season,
										'town'			=> $town,
										'name'			=> $name,
										'shortName'		=> $short_name,
										'type'			=> $type,
										'division'		=> $division,
										'modifiedBy'	=> $_SESSION['user_id'],
										'created'		=> 'now',
										'modified'		=> 'now'
										);
				$message = $db->db_write_array('teams', $sql_data_array);
			}else{
				$sql_data_array = array('teamMasterRef' => $teamMasterRef,
										'teamRef'		=> $teamRef,
										'season'		=> $season,
										'town'			=> $town,
										'name'			=> $name,
										'shortName'		=> $short_name,
										'type'			=> $type,
										'division'		=> $division,
										'modifiedBy'	=> $_SESSION['user_id'],
										'modified'		=> 'now'
										);
				$param = 'teamRef='.$teamRef;
				$message = $db->db_write_array('teams', $sql_data_array, 'update', $param);
			}
		}
		//proceed
		if($message == ''){
			$params = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&nmh=1&ct=1';
			redirect(set_href(FILENAME_ADMIN_SEASON, $params));
		}
	}
}
if($teamRef == 0){
	$sql = 'SELECT town, teamName AS name, shortName, division, type, gender
			FROM teamsMaster
			WHERE teamMasterRef='.intval($teamMasterRef);
}else{
	$sql = 'SELECT tm.town, tm.shortName, tm.gender,
				t.division, t.name, t.type, t.season
			FROM teamsMaster tm
			INNER JOIN teams t
				USING(teamMasterRef)
			WHERE tm.teamMasterRef='.intval($teamMasterRef).'
				AND t.teamRef='.intval($teamRef);
}
$team = $db->db_query($sql);
$town			= $team->field['town'];
$name			= $team->field['name'];
$division		= $team->field['division'];
$short_name		= $team->field['shortName'];
$type			= $team->field['type'];
$gender			= $team->field['gender'];
$season			= (isset($team->field['season']) ? $team->field['season'] : date('Y'));

$gender_str		= set_gender($gender);
$letter			= set_team_letter($type);
$team_string	= ucwords(strtolower($gender_str.' '.$letter));
?>