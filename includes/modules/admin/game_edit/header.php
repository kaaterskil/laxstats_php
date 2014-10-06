<?php
//test privileges
test_privileges(1);

//set headers
$masthead_logo = MASTHEAD_ADMIN_GAME_EDIT;
if($_SESSION['user_affiliation'] == 'Administrator'){
	$tpl_menubar = MENUBAR_ADMIN3;
}else{
	$tpl_menubar = MENUBAR_ADMIN2;
}
define('PAGE_TITLE', 'Edit Game');
define('PAGE_HEADER', 'EDIT GAME');

//declare game variables
$date = date('m/d/Y');
$usTeamRef = 0;
$themTeamRef = 0;
$fieldRef = 0;
$time = 0;
$referee = '';
$umpire = '';
$field_judge = '';
$post_season = 'F';
$conference = 'T';
$weather = '';
$scorekeeper = '';
$timekeeper = '';
$us_team = '';
$them_team = '';
$us_town = '';
$them_town = '';
$field_name = '';
$field_town = '';
$edit_game_date = '';
$edit_game_time = '';
$edit_fieldRef = 0;
$edit_post_season = 'F';
$edit_exhibition = 'F';
$edit_referee = '';
$edit_umpire = '';
$edit_field_judge = '';
$edit_weather = '';
$edit_scorekeeper = '';
$edit_timekeeper = '';
$edit_season = '';

$edit_played = '';
$edit_started = '';
$edit_position = '';
$edit_shotsQ1 = '';
$edit_shotsQ2 = '';
$edit_shotsQ3 = '';
$edit_shotsQ4 = '';
$edit_shotsOT = '';
$edit_gbQ1 = '';
$edit_gbQ2 = '';
$edit_gbQ3 = '';
$edit_gbQ4 = '';
$edit_gbOT = '';
$edit_tot_shots = '';
$edit_tot_gb = '';

$edit_teamRef1 = 0;
$edit_teamRef2 = 0;
$edit_teamRef3 = 0;
$edit_teamRef4 = 0;
$edit_teamRef5 = 0;
$edit_teamRef6 = 0;

$edit_quarter = '';
$edit_clock = '';
$edit_scorer = 0;
$edit_assist = 0;

$edit_playerRef = '';
$edit_duration = '';
$edit_infraction = '';

$edit_savedQ1 = '';
$edit_savedQ2 = '';
$edit_savedQ3 = '';
$edit_savedQ4 = '';
$edit_savedOT = '';
$edit_allowedQ1 = '';
$edit_allowedQ2 = '';
$edit_allowedQ3 = '';
$edit_allowedQ4 = '';
$edit_allowedOT = '';
$edit_tot_saved = '';
$edit_tot_allowed = '';

$edit_wonQ1 = '';
$edit_wonQ2 = '';
$edit_wonQ3 = '';
$edit_wonQ4 = '';
$edit_wonOT = '';
$edit_lostQ1 = '';
$edit_lostQ2 = '';
$edit_lostQ3 = '';
$edit_lostQ4 = '';
$edit_lostOT = '';
$edit_tot_won = '';
$edit_tot_lost = '';

$edit_clearedQ1 = '';
$edit_clearedQ2 = '';
$edit_clearedQ3 = '';
$edit_clearedQ4 = '';
$edit_clearedOT = '';
$edit_failedQ1 = '';
$edit_failedQ2 = '';
$edit_failedQ3 = '';
$edit_failedQ4 = '';
$edit_failedOT = '';
$edit_tot_cleared = '';
$edit_tot_failed = '';

//set links
$params = 'gr='.$gameRef.'&a=egm';
$href_edit_game = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
$params = 'gr='.$gameRef.'&a=sgm';
$href_action_game = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
$params = 'gr='.$gameRef.'&a=spl';
$href_action_play = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
$params = 'gr='.$gameRef.'&a=sg';
$href_action_scoring = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
$params = 'gr='.$gameRef.'&a=spn';
$href_action_penalty = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
$params = 'gr='.$gameRef.'&a=sgk';
$href_action_goalie = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
$params = 'gr='.$gameRef.'&a=sfo';
$href_action_faceoff = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
$params = 'gr='.$gameRef.'&a=scl';
$href_action_clear = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
$params = 'gr='.$gameRef.'&a=sf';
$href_action_final = set_href(FILENAME_ADMIN_GAME_EDIT, $params);

//define actions
$game_message = '';
$play_message = '';
$scoring_message = '';
$penalty_message = '';
$goalie_message = '';
$faceoff_message = '';
$clear_message = '';
$final_message = '';
if($action != ''){
	switch($action){
		/*------------------------------------------------------------
		GET DATA
		------------------------------------------------------------*/
		//edit game
		case 'egm':
			if($gameRef > 0){
				//get game data
				$game = get_game($gameRef);
				$edit_date				= $game->field['date'];
				$edit_fieldRef			= $game->field['fieldRef'];
				$edit_time				= $game->field['time'];
				$edit_post_season		= $game->field['seasonType'];
				$edit_conference		= $game->field['conference'];
				$edit_weather			= $game->field['conditions'];
				$edit_referee			= $game->field['referee'];
				$edit_umpire			= $game->field['umpire'];
				$edit_field_judge		= $game->field['fieldJudge'];
				$edit_scorekeeper		= $game->field['scorekeeper'];
				$edit_timekeeper		= $game->field['timekeeper'];
				//process data
				$edit_exhibition		= ($edit_conference == 'T' ? 'F' : 'T');
				$edit_game_timestamp	= strtotime($edit_date) + $edit_time;
				$edit_game_date			= date('m/d/Y', $edit_game_timestamp);
				$edit_game_time			= date('g:i a', $edit_game_timestamp);
				$edit_season			= date('Y', $edit_game_timestamp);
			}
			break;
			
		//edit play
		case 'epl':
			$edit_play = get_player_play_data($recordID);
			$edit_playerRef		= $edit_play->field['playerRef'];
			$edit_teamRef1		= $edit_play->field['teamRef'];
			$edit_played		= $edit_play->field['played'];
			$edit_started		= $edit_play->field['started'];
			$edit_position		= $edit_play->field['position'];
			$edit_shotsQ1		= $edit_play->field['shotsQ1'];
			$edit_shotsQ2		= $edit_play->field['shotsQ2'];
			$edit_shotsQ3		= $edit_play->field['shotsQ3'];
			$edit_shotsQ4		= $edit_play->field['shotsQ4'];
			$edit_shotsOT		= $edit_play->field['shotsOT'];
			$edit_gbQ1			= $edit_play->field['gbQ1'];
			$edit_gbQ2			= $edit_play->field['gbQ2'];
			$edit_gbQ3			= $edit_play->field['gbQ3'];
			$edit_gbQ4			= $edit_play->field['gbQ4'];
			$edit_gbOT			= $edit_play->field['gbOT'];
			$edit_tot_shots		= $edit_shotsQ1 + $edit_shotsQ2 + $edit_shotsQ3 + $edit_shotsQ4 + $edit_shotsOT;
			$edit_tot_gb		= $edit_gbQ1 + $edit_gbQ2 + $edit_gbQ3 + $edit_gbQ4 + $edit_gbOT;
			//delete record
			$sql = 'DELETE FROM plays WHERE reference='.$recordID;
			$play_message = $db->db_write($sql);
			break;
			
		//edit goal
		case 'eg':
			$edit_goal = get_player_scoring_data($recordID);
			$edit_teamRef2		= $edit_goal->field['teamRef'];
			$edit_quarter		= $edit_goal->field['quarter'];
			$edit_clock			= $edit_goal->field['timeClock'];
			$edit_scorer		= $edit_goal->field['scorer'];
			$edit_assist		= $edit_goal->field['assist'];
			$edit_clock			= substr($edit_clock, 3);
			//delete record
			$sql = 'DELETE FROM goals WHERE reference='.$recordID;
			$scoring_message = $db->db_write($sql);
			break;
		
		//edit penalty
		case 'epn':
			$edit_penalty = get_player_penalty_data($recordID);
			$edit_teamRef3		= $edit_goal->field['teamRef'];
			$edit_playerRef		= $edit_goal->field['playerRef'];
			$edit_quarter		= $edit_goal->field['startQtr'];
			$edit_clock			= $edit_goal->field['clock'];
			$edit_duration		= $edit_goal->field['duration'];
			$edit_infraction	= $edit_goal->field['infraction'];
			$edit_clock			= substr($edit_clock, 3);
			//delete record
			$sql = 'DELETE FROM penalties WHERE reference='.$recordID;
			$penalty_message = $db->db_write($sql);
			break;
		
		//edit save
		case 'egk':
			$edit_goalie = get_player_goalie_data($recordID);
			$edit_teamRef4		= $edit_goalie->field['teamRef'];
			$edit_playerRef		= $edit_goalie->field['playerRef'];
			$edit_savedQ1		= $edit_goalie->field['savedQ1'];
			$edit_savedQ2		= $edit_goalie->field['savedQ2'];
			$edit_savedQ3		= $edit_goalie->field['savedQ3'];
			$edit_savedQ4		= $edit_goalie->field['savedQ4'];
			$edit_savedOT		= $edit_goalie->field['savedOT'];
			$edit_allowedQ1		= $edit_goalie->field['allowedQ1'];
			$edit_allowedQ2		= $edit_goalie->field['allowedQ2'];
			$edit_allowedQ3		= $edit_goalie->field['allowedQ3'];
			$edit_allowedQ4		= $edit_goalie->field['allowedQ4'];
			$edit_allowedOT		= $edit_goalie->field['allowedOT'];
			$edit_tot_saved		= $edit_savedQ1 + $edit_savedQ2 + $edit_savedQ3 + $edit_savedQ4 + $edit_savedOT;
			$edit_tot_allowed	= $edit_allowedQ1 + $edit_allowedQ2 + $edit_allowedQ3 + $edit_allowedQ4 + $edit_allowedOT;
			//delete record
			$sql = 'DELETE FROM saves WHERE reference='.$recordID;
			$goalie_message = $db->db_write($sql);
			break;
		
		//edit faceoff
		case'efo':
			$edit_faceoff = get_player_faceoff_data($recordID);
			$edit_teamRef5	= $edit_faceoff->field['teamRef'];
			$edit_playerRef	= $edit_faceoff->field['playerRef'];
			$edit_wonQ1		= $edit_faceoff->field['wonQ1'];
			$edit_wonQ2		= $edit_faceoff->field['wonQ2'];
			$edit_wonQ3		= $edit_faceoff->field['wonQ3'];
			$edit_wonQ4		= $edit_faceoff->field['wonQ4'];
			$edit_wonOT		= $edit_faceoff->field['wonOT'];
			$edit_lostQ1	= $edit_faceoff->field['lostQ1'];
			$edit_lostQ2	= $edit_faceoff->field['lostQ2'];
			$edit_lostQ3	= $edit_faceoff->field['lostQ3'];
			$edit_lostQ4	= $edit_faceoff->field['lostQ4'];
			$edit_lostOT	= $edit_faceoff->field['lostOT'];
			$edit_tot_won	= $edit_wonQ1 + $edit_wonQ2 + $edit_wonQ3 + $edit_wonQ4 + $edit_wonOT;
			$edit_tot_lost	= $edit_lostQ1 + $edit_lostQ2 + $edit_lostQ3 + $edit_lostQ4 + $edit_lostOT;
			//delete record
			$sql = 'DELETE FROM faceoffs WHERE reference='.$recordID;
			$faceoff_message = $db->db_write($sql);
			break;
		
		//edit clear
		case'ecl':
			$edit_clears = get_team_clear_data($recordID);
			$edit_teamRef6		= $edit_faceoff->field['teamRef'];
			$edit_clearedQ1		= $edit_clears->field['clearedQ1'];
			$edit_clearedQ2		= $edit_clears->field['clearedQ2'];
			$edit_clearedQ3		= $edit_clears->field['clearedQ3'];
			$edit_clearedQ4		= $edit_clears->field['clearedQ4'];
			$edit_clearedOT		= $edit_clears->field['clearedOT'];
			$edit_failedQ1		= $edit_clears->field['failedQ1'];
			$edit_failedQ2		= $edit_clears->field['failedQ2'];
			$edit_failedQ3		= $edit_clears->field['failedQ3'];
			$edit_failedQ4		= $edit_clears->field['failedQ4'];
			$edit_failedOT		= $edit_clears->field['failedOT'];
			$edit_tot_cleared	= $edit_clearedQ1 + $edit_clearedQ2 + $edit_clearedQ3 + $edit_clearedQ4 + $edit_clearedOT;
			$edit_tot_failed	= $edit_failedQ1 + $edit_failedQ2 + $edit_failedQ3 + $edit_failedQ4 + $edit_failedOT;
			//delete record
			$sql = 'DELETE FROM clears WHERE reference='.$recordID;
			$clear_message = $db->db_write($sql);
			break;
		
		/*------------------------------------------------------------
		DELETIONS
		------------------------------------------------------------*/
		//delete play
		case 'dpl':
			$sql = 'DELETE FROM plays WHERE reference='.$recordID;
			$play_message = $db->db_write($sql);
			if($play_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
			
		//delete goal
		case 'dg':
			$sql = 'DELETE FROM goals WHERE reference='.$recordID;
			$scoring_message = $db->db_write($sql);
			if($scoring_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
		
		//delete penalty
		case 'dpn':
			$sql = 'DELETE FROM penalties WHERE reference='.$recordID;
			$penalty_message = $db->db_write($sql);
			if($penalty_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
		
		//delete save
		case 'dgk':
			$sql = 'DELETE FROM saves WHERE reference='.$recordID;
			$goalie_message = $db->db_write($sql);
			if($penalty_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
		
		//delete faceoff
		case 'dfo':
			$sql = 'DELETE FROM faceoffs WHERE reference='.$recordID;
			$goalie_message = $db->db_write($sql);
			if($faceoff_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
		
		//delete clear
		case 'dcl':
			$sql = 'DELETE FROM clears WHERE reference='.$recordID;
			$goalie_message = $db->db_write($sql);
			if($clear_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
			
		/*------------------------------------------------------------
		INSERTIONS
		------------------------------------------------------------*/
		//save game
		case 'sgm':
			//retrieve POST variables
			$game_date		= $db->db_sanitize($_POST['game_date']);
			$game_time		= $db->db_sanitize($_POST['game_time']);
			$fieldRef		= $_POST['fieldRef'];
			$post_season	= (isset($_POST['post_season']) ? 'T' : 'F');
			$conference		= (isset($_POST['exhibition']) ? 'F' : 'T');
			$weather		= $db->db_sanitize($_POST['weather']);
			$referee		= $db->db_sanitize($_POST['referee']);
			$umpire			= $db->db_sanitize($_POST['umpire']);
			$field_judge	= $db->db_sanitize($_POST['field_judge']);
			$scorekeeper	= $db->db_sanitize($_POST['scorekeeper']);
			$timekeeper		= $db->db_sanitize($_POST['timekeeper']);
			$season			= $_POST['season'];
			//validation
			$game_message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			if($game_message == ''){
				$date_test = validate_date($game_date);
				if($date_test === false){
					$date_str = date('Y-m-d');
					$game_message .= 'The date must be in mm/dd/YY or mm/dd/YYYY format. ';
				}else{
					$date_str = date('Y-m-d', strtotime($date_test));
				}
				$time_test = validate_time($game_time, $date_str);
				if($time_test === false){
					$time_str = date('H:i:s', (60 * 60 * 16));
					$timestamp = date('YmdHis', strtotime($date_str) + (60 * 60 * 16));
					$game_message .= 'The time must be in one of the following four formats: a) HH, b) HH am|pm, c) HH:MM, or d) HH:MM am|pm. ';
				}else{
					$time_str = date('H:i:s', $time_test);
					$timestamp = date('YmdHis', $time_test);
				}
				if(empty($fieldRef) || $fieldRef == 0){
					$game_message .= 'Please select a playing field. ';
				}
			}
			//write to disk
			if($game_message == ''){
				$sql_data_array = array('season'		=> $season,
										'seasonType'	=> $post_season,
										'timestamp'		=> $timestamp,
										'date'			=> $date_str,
										'startTime'		=> $time_str,
										'fieldRef'		=> $fieldRef,
										'conditions'	=> $weather,
										'scorekeeper'	=> $scorekeeper,
										'timekeeper'	=> $timekeeper,
										'referee'		=> $referee,
										'umpire'		=> $umpire,
										'fieldJudge'	=> $field_judge,
										'conference'	=> $conference,
										'final'			=> 'F',
										'modifiedBy'	=> $_SESSION['user_id'],
										'modified'		=> 'now'
										);
				$param = 'gameRef='.$gameRef;
				$game_message = $db->db_write_array('games', $sql_data_array, 'update', $param);
			}
			//proceed
			if($game_message == ''){
				$params = 'gr='.$gameRef.'&sc=0';
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
			
		//save play
		case 'spl':
			//retrieve POST variables
			$team				= $_POST['team'];
			$usTeamRef			= $_POST['usTeamRef'];
			$themTeamRef		= $_POST['themTeamRef'];
			$us_playerRef		= $_POST['roster_home'];
			$them_playerRef		= $_POST['roster_visitor'];
			$position			= $db->db_sanitize($_POST['position']);
			$played				= (isset($_POST['played']) ? 'T' : 'F');
			$started			= (isset($_POST['started']) ? 'T' : 'F');
			$shotsQ1			= (intval($_POST['va1']) > 0 ? intval($_POST['va1']) : NULL);
			$shotsQ2			= (intval($_POST['va2']) > 0 ? intval($_POST['va2']) : NULL);	
			$shotsQ3			= (intval($_POST['va3']) > 0 ? intval($_POST['va3']) : NULL);
			$shotsQ4			= (intval($_POST['va4']) > 0 ? intval($_POST['va4']) : NULL);
			$shotsOT			= (intval($_POST['vaOT']) > 0 ? intval($_POST['vaOT']) : NULL);
			$gbQ1				= (intval($_POST['vb1']) > 0 ? intval($_POST['vb1']) : NULL);
			$gbQ2				= (intval($_POST['vb2']) > 0 ? intval($_POST['vb2']) : NULL);
			$gbQ3				= (intval($_POST['vb3']) > 0 ? intval($_POST['vb3']) : NULL);
			$gbQ4				= (intval($_POST['vb4']) > 0 ? intval($_POST['vb4']) : NULL);
			$gbOT				= (intval($_POST['vbOT']) > 0 ? intval($_POST['vbOT']) : NULL);
			$offsetY			= $_POST['offsetY'];
			//set team
			if($team == 'home'){
				$teamRef = $usTeamRef;
				$playerRef = $us_playerRef;
			}else{
				$teamRef = $themTeamRef;
				$playerRef = $them_playerRef;
			}
			//test for active subscription
			$play_message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//validate
			if($play_message == ''){
				//1. test fields
				if(!ereg('^(A|M|D|GK|G|DM|LSM)$', $position)){
					$play_message = 'Please enter a valid position. ';
				}
				//2. test for duplicate player
				$sql = 'SELECT COUNT(pl.playerRef) AS players
						FROM plays pl
						WHERE gameRef='.$gameRef.'
							AND teamRef='.$teamRef.'
							AND playerRef='.$playerRef;
				$test = $db->db_query($sql);
				if($test->field['players'] > 0){
					$play_message .= 'That player has already been entered. ';
				}
				//3. Test for more than 10 starters
				if($started == 'T'){
					$sql = 'SELECT COUNT(pl.playerRef) AS starters
							FROM plays pl
							WHERE gameRef='.$gameRef.'
								AND teamRef='.$teamRef.'
								AND started=\'T\'';
					$test = $db->db_query($sql);
					if($test->field['starters'] > 10){
						$play_message .= 'There are already 10 starters. ';
					}
				}
			}
			//write to disk
			if($play_message == ''){
				$sql_data_array = array('reference'		=> NULL,
										'gameRef'		=> $gameRef,
										'teamRef'		=> $teamRef,
										'playerRef'		=> $playerRef,
										'played'		=> $played,
										'started'		=> $started,
										'position'		=> $position,
										'shotsQ1'		=> $shotsQ1,
										'shotsQ2'		=> $shotsQ2,
										'shotsQ3'		=> $shotsQ3,
										'shotsQ4'		=> $shotsQ4,
										'shotsOT'		=> $shotsOT,
										'gbQ1'			=> $gbQ1,
										'gbQ2'			=> $gbQ2,
										'gbQ3'			=> $gbQ3,
										'gbQ4'			=> $gbQ4,
										'gbOT'			=> $gbOT,
										'modifiedBy'	=> $_SESSION['user_id'],
										'created'		=> 'now',
										'modified'		=> 'now'
										);
				$play_message = $db->db_write_array('plays', $sql_data_array);
			}
			//proceed
			if($play_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
			
		//save goal
		case 'sg':
			//get POST variables
			$team			= $_POST['team'];
			$usTeamRef		= $_POST['usTeamRef'];
			$themTeamRef	= $_POST['themTeamRef'];
			$us_scorer		= $_POST['roster_home_scorer'];
			$them_scorer	= $_POST['roster_visitor_scorer'];
			$us_assist		= $_POST['roster_home_assist'];
			$them_assist	= $_POST['roster_visitor_assist'];
			$quarter		= $db->db_sanitize($_POST['quarter']);
			$clock			= $db->db_sanitize($_POST['clock']);
			$offsetY		= $_POST['offsetY'];
			//set team
			if($team == 'home'){
				$teamRef = $usTeamRef;
				$scorer = $us_scorer;
				$assist = $us_assist;
			}else{
				$teamRef = $themTeamRef;
				$scorer = $them_scorer;
				$assist = $them_assist;
			}
			//test for active subscription
			$scoring_message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//validation
			if($scoring_message == ''){
				//1. test fields
				if($scorer == 0 || $scorer == NULL){
					$scoring_message = 'You must select a scorer. ';
				}
				if(!ereg('^[1-4|OT|ot]|[oO][2-9]|[oO][1-9][0-9]$', $quarter)){
					$scoring_message .= 'Please identify the period using the format 1-4, OT, O2, O3... ';
				}
				if(!ereg('^(0?[0-9]|[1][0-5]):(0?[0-9]|[1-5][0-9])$', $clock, $parts)){
					$scoring_message .= 'Please enter a valid clock time. ';
				}else{
					$minutes = intval($parts[1]);
					$seconds = intval($parts[2]);
					$time = ($minutes * 60) + $seconds;
					$clock = date('H:i:s', $time);
				}
				//2. test if scorer exists in play list
				$sql = 'SELECT IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS player_name, 
							COUNT(pl.playerRef) AS player
						FROM players p
						LEFT JOIN plays pl
						ON pl.teamRef=p.teamRef AND pl.playerRef=p.jerseyNo
						WHERE p.teamRef='.$teamRef.' 
							AND p.jerseyNo='.$scorer.'
							AND pl.gameRef='.$gameRef.'
						GROUP BY pl.playerRef';
				$test = $db->db_query($sql);
				if($test->field['player'] == 0){
					$scoring_message .= $test->field['player_name'].' must be added to the play list. ';
				}
				//3. test if assist exists in play list
				if($assist > 0){
					$sql = 'SELECT IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS player_name, 
								COUNT(pl.playerRef) AS player
							FROM players p
							LEFT JOIN plays pl
							ON pl.teamRef=p.teamRef AND pl.playerRef=p.jerseyNo
							WHERE p.teamRef='.$teamRef.' 
								AND p.jerseyNo='.$assist.'
								AND pl.gameRef='.$gameRef.'
							GROUP BY pl.playerRef';
					$test = $db->db_query($sql);
					if($test->field['player'] == 0){
						$scoring_message .= $test->field['player_name'].' must be added to the play list. ';
					}
				}
				//4. test for duplicate
				$sql = 'SELECT COUNT(*) AS duplicates
						FROM goals
						WHERE gameRef='.$gameRef.'
							AND teamRef='.$teamRef.'
							AND quarter=\''.$quarter.'\'
							AND timeClock=\''.$clock.'\'';
				$test = $db->db_query($sql);
				if($test->field['duplicates'] > 0){
					$scoring_message .= 'A goal has already been entered for that time.';
				}
			}
			//write to disk
			if($scoring_message == ''){
				$sql_data_array = array('reference' => NULL,
										'gameRef' => $gameRef,
										'teamRef' => $teamRef,
										'quarter' => $quarter,
										'timeClock' => $clock,
										'scorer' => $scorer,
										'assist' => $assist,
										'modifiedBy' => $_SESSION['user_id'],
										'created' => 'now',
										'modified' => 'now'
										);
				$scoring_message = $db->db_write_array('goals', $sql_data_array);
			}
			//proceed
			if($scoring_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
			
		//save penalty
		case 'spn':
			//retrieve POST variables
			$team				= $_POST['team'];
			$usTeamRef			= $_POST['usTeamRef'];
			$themTeamRef		= $_POST['themTeamRef'];
			$us_playerRef		= $_POST['roster_home'];
			$them_playerRef		= $_POST['roster_visitor'];
			$offsetY			= $_POST['offsetY'];
			$start_quarter		= $db->db_sanitize($_POST['period']);
			$clock				= $db->db_sanitize($_POST['clock']);
			$infraction			= $_POST['infraction'];
			$duration			= (floatval($_POST['duration']) ? floatval($_POST['duration']) : 0.0);
			//set team
			if($team == 'home'){
				$teamRef = $usTeamRef;
				$playerRef = $us_playerRef;
			}else{
				$teamRef = $themTeamRef;
				$playerRef = $them_playerRef;
			}
			//test for active subscription
			$penalty_message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//validate
			if($penalty_message == ''){
				//1. test fields
				if($infraction == ''){
					$penalty_message = 'You must select a violation. ';
				}else{
					$releasable = substr($infraction, -1);
					$infraction = substr($infraction, 0, -2);
				}
				if(!ereg('^[1-4|OT|ot]|[oO][2-9]|[oO][1-9][0-9]$', $start_quarter)){
					$penalty_message .= 'Please enter a period using the format 1-4, OT, O2, O3... ';
				}
				if(!ereg('^(0?[0-9]|[1][0-5]):(0?[0-9]|[1-5][0-9])$', $clock, $parts)){
					$penalty_message .= 'Please enter a valid clock time. ';
				}else{
					$minutes = intval($parts[1]);
					$seconds = intval($parts[2]);
					$time = ($minutes * 60) + $seconds;
					$start_time = date('H:i:s', $time);
				}
				if(floatval($duration) < 0.5){
					$penalty_message .= 'You must enter a duration for the penalty. ';
				}
				//2. test for duplicate
				$sql = 'SELECT COUNT(reference) AS duplicates
						FROM penalties
						WHERE gameRef='.$gameRef.'
							AND teamRef='.$teamRef.'
							AND playerRef='.$playerRef.'
							AND startQtr=\''.$start_quarter.'\'
							AND startTime=\''.$start_time.'\'';
				$test = $db->db_query($sql);
				if($test->field['duplicates'] > 0){
					$penalty_message .= 'A penalty for this player has already been entered for this clock time.';
				}
				//3. test if player exists on the playlist
				$sql = 'SELECT IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS player_name, 
							COUNT(pl.playerRef) AS player
						FROM players p
						LEFT JOIN plays pl
						ON pl.teamRef=p.teamRef AND pl.playerRef=p.jerseyNo
						WHERE p.teamRef='.$teamRef.' 
							AND p.jerseyNo='.$playerRef.'
							AND pl.gameRef='.$gameRef.'
						GROUP BY pl.playerRef';
				$test = $db->db_query($sql);
				if($test->field['player'] == 0){
					$penalty_message .= $test->field['player_name'].' must be added to the play list. ';
				}
			}
			if($penalty_message == ''){
				//set goal codes and end time
				$end = set_penalty($start_time, $start_quarter, $duration, $gameRef, $teamRef, $releasable);
				$end_quarter = $end['end_quarter'];
				$end_time = date('H:i:s', $end['end_time']);
				//write to disk
				$sql_data_array = array('reference'		=> NULL,
										'gameRef'		=> $gameRef,
										'teamRef'		=> $teamRef,
										'playerRef'		=> $playerRef,
										'duration'		=> $duration,
										'startQtr'		=> $start_quarter,
										'startTime'		=> $start_time,
										'endQtr'		=> $end_quarter,
										'endTime'		=> $end_time,
										'infraction'	=> $infraction,
										'releasable'	=> $releasable,
										'modifiedBy'	=> $_SESSION['user_id'],
										'created'		=> 'now',
										'modified'		=> 'now'
										);
				$penalty_message = $db->db_write_array('penalties', $sql_data_array);
			}
			//proceed
			if($penalty_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
			
		//save save
		case 'sgk':
			//retrieve POST variables
			$team = $_POST['team'];
			$usTeamRef = $_POST['usTeamRef'];
			$themTeamRef = $_POST['themTeamRef'];
			$us_playerRef = $_POST['roster_home'];
			$them_playerRef = $_POST['roster_visitor'];
			$offsetY = $_POST['offsetY'];
			$savedQ1 = (intval($_POST['va1']) > 0 ? intval($_POST['va1']) : NULL);
			$savedQ2 = (intval($_POST['va2']) > 0 ? intval($_POST['va2']) : NULL);	
			$savedQ3 = (intval($_POST['va3']) > 0 ? intval($_POST['va3']) : NULL);
			$savedQ4 = (intval($_POST['va4']) > 0 ? intval($_POST['va4']) : NULL);
			$savedOT = (intval($_POST['vaOT']) > 0 ? intval($_POST['vaOT']) : NULL);
			$allowedQ1 = (intval($_POST['vb1']) > 0 ? intval($_POST['vb1']) : NULL);
			$allowedQ2 = (intval($_POST['vb2']) > 0 ? intval($_POST['vb2']) : NULL);
			$allowedQ3 = (intval($_POST['vb3']) > 0 ? intval($_POST['vb3']) : NULL);
			$allowedQ4 = (intval($_POST['vb4']) > 0 ? intval($_POST['vb4']) : NULL);
			$allowedOT = (intval($_POST['vbOT']) > 0 ? intval($_POST['vbOT']) : NULL);
			//set team
			if($team == 'home'){
				$teamRef = $usTeamRef;
				$playerRef = $us_playerRef;
			}else{
				$teamRef = $themTeamRef;
				$playerRef = $them_playerRef;
			}
			//test for active subscription
			$goalie_message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//validation
			if($goalie_message == ''){
				//1. test for player
				if($playerRef == 0 || $playerRef == NULL){
					$goalie_message = 'You must select a player. ';
				}
				//2. test for duplicate
				$sql = 'SELECT COUNT(reference) AS duplicates
						FROM saves
						WHERE gameRef='.$gameRef.'
							AND teamRef='.$teamRef.'
							AND playerRef='.$playerRef;
				$test = $db->db_query($sql);
				if($test->field['duplicates'] > 0){
					$goalie_message .= 'This player has already been entered. ';
				}
				//3. test if player exists on the playlist
				$sql = 'SELECT IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS player_name, pl.playerRef
						FROM players p
						LEFT JOIN plays pl
							ON p.teamRef=pl.teamRef
							AND p.jerseyNo=pl.playerRef
						WHERE pl.gameRef='.$gameRef.'
							AND p.teamRef='.$teamRef.'
							AND p.jerseyNo='.$playerRef;
				$test = $db->db_query($sql);
				if($test->field['playerRef'] == NULL){
					$goalie_message .= $test->field['player_name'].' must be added to the play list. ';
				}
			}
			//write to disk
			if($goalie_message == ''){
				$sql_data_array = array('reference'		=> NULL,
										'gameRef'		=> $gameRef,
										'teamRef'		=> $teamRef,
										'playerRef'		=> $playerRef,
										'savedQ1'		=> $savedQ1,
										'savedQ2'		=> $savedQ2,
										'savedQ3'		=> $savedQ3,
										'savedQ4'		=> $savedQ4,
										'savedOT'		=> $savedOT,
										'allowedQ1'		=> $allowedQ1,
										'allowedQ2'		=> $allowedQ2,
										'allowedQ3'		=> $allowedQ3,
										'allowedQ4'		=> $allowedQ4,
										'allowedOT'		=> $allowedOT,
										'modifiedBy'	=> $_SESSION['user_id'],
										'created'		=> 'now',
										'modified'		=> 'now'
										);
				$goalie_message = $db->db_write_array('saves', $sql_data_array);
			}
			//proceed
			if($goalie_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
			
		//save faceoff
		case 'sfo':
			//retrieve POST variables
			$team = $_POST['team'];
			$usTeamRef = $_POST['usTeamRef'];
			$themTeamRef = $_POST['themTeamRef'];
			$us_playerRef = $_POST['roster_home'];
			$them_playerRef = $_POST['roster_visitor'];
			$offsetY = $_POST['offsetY'];
			$wonQ1 = (intval($_POST['va1']) > 0 ? intval($_POST['va1']) : NULL);
			$wonQ2 = (intval($_POST['va2']) > 0 ? intval($_POST['va2']) : NULL);	
			$wonQ3 = (intval($_POST['va3']) > 0 ? intval($_POST['va3']) : NULL);
			$wonQ4 = (intval($_POST['va4']) > 0 ? intval($_POST['va4']) : NULL);
			$wonOT = (intval($_POST['vaOT']) > 0 ? intval($_POST['vaOT']) : NULL);
			$lostQ1 = (intval($_POST['vb1']) > 0 ? intval($_POST['vb1']) : NULL);
			$lostQ2 = (intval($_POST['vb2']) > 0 ? intval($_POST['vb2']) : NULL);
			$lostQ3 = (intval($_POST['vb3']) > 0 ? intval($_POST['vb3']) : NULL);
			$lostQ4 = (intval($_POST['vb4']) > 0 ? intval($_POST['vb4']) : NULL);
			$lostOT = (intval($_POST['vbOT']) > 0 ? intval($_POST['vbOT']) : NULL);
			//set team
			if($team == 'home'){
				$teamRef = $usTeamRef;
				$playerRef = $us_playerRef;
			}else{
				$teamRef = $themTeamRef;
				$playerRef = $them_playerRef;
			}
			//test for active subscription
			$faceoff_message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//validation
			if($faceoff_message == ''){
				//1. test for data
				$tot_won = $wonQ1 + $wonQ2 + $wonQ3 + $wonQ4 + $wonOT;
				$tot_lost = $lostQ1 + $lostQ2 + $lostQ3 + $lostQ4 + $lostOT;
				if($tot_won == 0 && $tot_lost == 0){
					$faceoff_message = 'No data was entered. ';
				}
				//2. test for player
				if($playerRef == 0 || $playerRef == NULL){
					$faceoff_message .= 'You must select a player. ';
				}else{
					//3. test for duplicate
					$sql = 'SELECT COUNT(reference) AS duplicates
							FROM faceoffs
							WHERE gameRef='.$gameRef.'
								AND teamRef='.$teamRef.'
								AND playerRef='.$playerRef;
					$test = $db->db_query($sql);
					if($test->field['duplicates'] > 0){
						$faceoff_message .= 'This player has already been entered. ';
					}
				}
				//4. test if player exists on the playlist
				$sql = 'SELECT IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS player_name, pl.playerRef
						FROM players p
						LEFT JOIN plays pl
							ON p.teamRef=pl.teamRef
							AND p.jerseyNo=pl.playerRef
						WHERE pl.gameRef='.$gameRef.'
							AND p.teamRef='.$teamRef.'
							AND p.jerseyNo='.$playerRef;
				$test = $db->db_query($sql);
				if($test->field['playerRef'] == NULL){
					$faceoff_message .= $test->field['player_name'].' must be added to the play list. ';
				}
			}
			//write to disk
			if($faceoff_message == ''){
				$sql_data_array = array('reference' => NULL,
										'gameRef' => $gameRef,
										'teamRef' => $teamRef,
										'playerRef' => $playerRef,
										'wonQ1' => $wonQ1,
										'wonQ2' => $wonQ2,
										'wonQ3' => $wonQ3,
										'wonQ4' => $wonQ4,
										'wonOT' => $wonOT,
										'lostQ1' => $lostQ1,
										'lostQ2' => $lostQ2,
										'lostQ3' => $lostQ3,
										'lostQ4' => $lostQ4,
										'lostOT' => $lostOT,
										'modifiedBy' => $_SESSION['user_id'],
										'created' => 'now',
										'modified' => 'now'
										);
				$faceoff_message = $db->db_write_array('faceoffs', $sql_data_array);
			}
			//proceed
			if($faceoff_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
			
		//save clear
		case 'scl':
			//retreive POST variables
			$team = $_POST['team'];
			$usTeamRef = $_POST['usTeamRef'];
			$themTeamRef = $_POST['themTeamRef'];
			$offsetY = $_POST['offsetY'];
			$clearedQ1 = (intval($_POST['va1']) > 0 ? intval($_POST['va1']) : NULL);
			$clearedQ2 = (intval($_POST['va2']) > 0 ? intval($_POST['va2']) : NULL);	
			$clearedQ3 = (intval($_POST['va3']) > 0 ? intval($_POST['va3']) : NULL);
			$clearedQ4 = (intval($_POST['va4']) > 0 ? intval($_POST['va4']) : NULL);
			$clearedOT = (intval($_POST['vaOT']) > 0 ? intval($_POST['vaOT']) : NULL);
			$failedQ1 = (intval($_POST['vb1']) > 0 ? intval($_POST['vb1']) : NULL);
			$failedQ2 = (intval($_POST['vb2']) > 0 ? intval($_POST['vb2']) : NULL);
			$failedQ3 = (intval($_POST['vb3']) > 0 ? intval($_POST['vb3']) : NULL);
			$failedQ4 = (intval($_POST['vb4']) > 0 ? intval($_POST['vb4']) : NULL);
			$failedOT = (intval($_POST['vbOT']) > 0 ? intval($_POST['vbOT']) : NULL);
			//set team
			if($team == 'home'){
				$teamRef = $usTeamRef;
			}else{
				$teamRef = $themTeamRef;
			}
			//test for active subscription
			$clear_message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//validate
			if($clear_message == ''){
				//test for data
				$tot_cleared = $clearedQ1 + $clearedQ2 + $clearedQ3 + $clearedQ4 + $clearedOT;
				$tot_failed = $failedQ1 + $failedQ2 + $failedQ3 + $failedQ4 + $failedOT;
				if($tot_cleared == 0 && $tot_failed == 0){
					$clear_message .= 'No data was entered.';
				}
				//test for duplicate
				$sql = 'SELECT COUNT(reference) AS duplicates
						FROM clears
						WHERE gameRef='.$gameRef.'
							AND teamRef='.$teamRef;
				$test = $db->db_query($sql);
				if($test->field['duplicates'] > 0){
					$clear_message .= 'A record this team already exists. ';
				}
			}
			//write to disk
			if($clear_message == ''){
				$sql_data_array = array('reference'		=> NULL,
										'gameRef'		=> $gameRef,
										'teamRef'		=> $teamRef,
										'playerRef'		=> NULL,
										'clearedQ1'		=> $clearedQ1,
										'clearedQ2'		=> $clearedQ2,
										'clearedQ3'		=> $clearedQ3,
										'clearedQ4'		=> $clearedQ4,
										'clearedOT'		=> $clearedOT,
										'failedQ1'		=> $failedQ1,
										'failedQ2'		=> $failedQ2,
										'failedQ3'		=> $failedQ3,
										'failedQ4'		=> $failedQ4,
										'failedOT'		=> $failedOT,
										'modifiedBy'	=> $_SESSION['user_id'],
										'created'		=> 'now',
										'modified'		=> 'now'
										);
				$clear_message = $db->db_write_array('clears', $sql_data_array);
			}
			//proceed
			if($clear_message == ''){
				$params = 'gr='.$gameRef.'&sc='.$offsetY;
				redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
			}
			break;
			
		//save final game
		case 'sf':
			$final_message = validate_final_game($gameRef);
			if($final_message == ''){
				redirect(set_href(FILENAME_ADMIN_USER_HOME));
			}
			break;
	}
}
//load game data
if($gameRef > 0){
	//get game data
	$game				= get_game($gameRef);
	$home_roster		= get_team_roster($game->field['usTeamRef']);
	$visitor_roster		= get_team_roster($game->field['themTeamRef']);
}
?>