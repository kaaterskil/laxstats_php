<?php
//test privileges
test_privileges(1);
//set headers
$masthead_logo = MASTHEAD_ADMIN_TEAM;
$tpl_menubar = MENUBAR_ADMIN2;
define('PAGE_TITLE', 'Teams');
define('PAGE_HEADER', 'TEAM MAINTENANCE');

$season_message = '';
$password_message = '';
if($action != ''){
	switch($action){
		case 'ap':
			//save password
			//retrieve variables
			$password = $db->db_sanitize($_POST['password']);
			//validate
			$password_message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//write to database
			if($password_message == ''){
				$sql_data_array = array('password' => $password,
										'modifiedBy' => $user_id,
										'modified' => 'now'
										);
				$param = 'teamMasterRef='.$teamMasterRef;
				$password_message = $db->db_write_array('teamsMaster', $sql_data_array, 'update', $param);
			}
			if($password_message == ''){
				$params = 'tmr='.$teamMasterRef.'&sn='.$state.'&et='.$edit_test;
				redirect(set_href(FILENAME_ADMIN_TEAM, $params));
			}
			break;
		case 'ds':
			//delete season
			//test for activity
			$sql = 'SELECT gameRef 
					FROM games 
					WHERE usTeamRef='.$teamRef.' 
						OR themTeamRef='.$teamRef;
			$test = $db->db_query($sql);
			if(isset($test->result['gameRef'])){
				$season_message = 'There are games associated with this season. You may not delete it.';
			}
			$season_message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//delete records
			if($season_message == ''){
				$sql = 'DELETE FROM officials WHERE teamRef='.$teamRef;
				$season_message = $db->db_write($sql);
				$sql = 'DELETE FROM players WHERE teamRef='.$teamRef;
				$season_message .= $db->db_write($sql);
				$sql = 'DELETE FROM teams WHERE teamRef='.$teamRef;
				$season_message .= $db->db_write($sql);
			}
			//proceed
			if($season_message == NULL){
				$params = 'tmr='.$teamMasterRef.'&sn='.$state.'&et='.$edit_test;
				redirect(set_href(FILENAME_ADMIN_TEAM, $params));
			}
			break;
	}
}
$sql = 'SELECT tm.town, tm.teamName, tm.type, tm.conference, tm.division, tm.password,
			t.teamRef, t.season, IF(o.type<3, o.name, NULL) AS staff
		FROM teamsMaster tm
		LEFT JOIN teams t
			USING(teamMasterRef)
		LEFT JOIN officials o
			USING(teamRef)
		WHERE tm.teamMasterRef='.$teamMasterRef.'
		ORDER BY t.season DESC, o.type';
$team_obj = $db->db_query($sql);
?>