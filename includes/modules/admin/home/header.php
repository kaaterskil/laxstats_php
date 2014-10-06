<?php
//test privileges
test_privileges(1);
//set headers
$masthead_logo = MASTHEAD_ADMIN_USER_HOME;
$tpl_menubar = MENUBAR_ADMIN1;
define('PAGE_TITLE', 'Manager\'s office');
$teamMasterRef = $_SESSION['user_tmr'];

$param = 'se=a';
$href_team_index = set_href(FILENAME_ADMIN_TEAM_INDEX, $param);
$href_fields = set_href(FILENAME_ADMIN_FIELD);
$href_game_action = set_href(FILENAME_ADMIN_GAME_NEW);

$game_message = '';
$season_message = '';
if($action != ''){
	switch($action){
		case 'ds':
			//delete season
			//test for activity
			$sql = 'SELECT COUNT(*) AS games
					FROM games
					WHERE usTeamRef='.$teamRef.' OR themTeamRef='.$teamRef;
			$test = $db->db_query($sql);
			if($test->field['games'] > 0){
				$season_message = ERROR_SEASON_GAMES_EXIST;
			}else{
				$season_message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			}
			
			//delete records
			if($season_message == ''){
				$sql = 'DELETE FROM officials WHERE teamRef='.$teamRef;
				$season_message = $db->db_write($sql);
				$sql = 'DELETE FROM players WHERE teamRef='.$teamRef;
				$season_message = $db->db_write($sql);
				$sql = 'DELETE FROM teams WHERE teamRef='.$teamRef;
				$season_message = $db->db_write($sql);
				
				//proceed
				if($season_message == ''){
					redirect(set_href(FILENAME_ADMIN_USER_HOME));
				}
			}
			break;
		case 'dg':
			//delete game
			$sql = 'DELETE FROM clears WHERE gameRef='.$gameRef;
			$game_message .= $db->db_write($sql);
			$sql = 'DELETE FROM faceoffs WHERE gameRef='.$gameRef;
			$game_message .= $db->db_write($sql);
			$sql = 'DELETE FROM goals WHERE gameRef='.$gameRef;
			$game_message .= $db->db_write($sql);
			$sql = 'DELETE FROM penalties WHERE gameRef='.$gameRef;
			$game_message .= $db->db_write($sql);
			$sql = 'DELETE FROM plays WHERE gameRef='.$gameRef;
			$game_message .= $db->db_write($sql);
			$sql = 'DELETE FROM saves WHERE gameRef='.$gameRef;
			$game_message .= $db->db_write($sql);
			$sql = 'DELETE FROM games WHERE gameRef='.$gameRef;
			$game_message .= $db->db_write($sql);
			//proceed
			if($game_message == ''){
				redirect(set_href(FILENAME_ADMIN_USER_HOME));
			}
		case 'v':
			//validate game
			$game_message = validate_final_game($gameRef);
			if($game_message == ''){
				redirect(set_href(FILENAME_ADMIN_USER_HOME));
			}
	}
}
//get team information
$sql = 'SELECT tm.town, tm.teamName, tm.type, tm.conference, tm.division,
			t.teamRef, t.season, o.name AS staff
		FROM officials o
		RIGHT JOIN teams t
			ON o.teamRef=t.teamRef
			AND o.type<3
		INNER JOIN teamsMaster tm
			USING(teamMasterRef)
		WHERE tm.teamMasterRef='.$_SESSION['user_tmr'].'
		ORDER BY t.season DESC, o.type';
$team_obj = $db->db_query($sql);
$town = $team_obj->field['town'];
$name = $team_obj->field['teamName'];
$team_name = strtoupper(set_team_name($town, $name));

//get unfinished games
$sql = 'SELECT gm.gameRef, gm.date, TIME_TO_SEC(gm.startTime) AS time_as_seconds,
			gm.created, gm.modified, t1.teamRef, t1.town, t2.town AS opponent,
			f.town AS site, f.name AS field_name
		FROM sites f
		INNER JOIN games gm
			ON f.fieldRef = gm.fieldRef
		INNER JOIN teams t1
			ON (gm.usTeamRef = t1.teamRef OR gm.themTeamRef = t1.teamRef)
		INNER JOIN teams t2
			ON (gm.usTeamRef = t2.teamRef OR gm.themTeamRef = t2.teamRef)
			AND t1.teamRef != t2.teamRef
		WHERE t1.teamMasterRef = "' . $_SESSION['user_tmr'] . '"
			AND gm.final = "F"
		ORDER BY gm.date DESC';
$game_obj = $db->db_query($sql);
?>