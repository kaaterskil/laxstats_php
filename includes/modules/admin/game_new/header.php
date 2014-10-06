<?php
//test privileges
test_privileges(1);
//set headers
$masthead_logo = MASTHEAD_ADMIN_GAME_NEW;
if($_SESSION['user_affiliation'] == 'Administrator'){
	$tpl_menubar = MENUBAR_ADMIN3;
}else{
	$tpl_menubar = MENUBAR_ADMIN2;
}
define('PAGE_TITLE', 'New Game');
define('PAGE_HEADER', 'NEW GAME: SETUP');

$gameRef= 0;
$date = date('m/d/Y');
$start_time = date('g:i a', strtotime('16:00:00'));
$fieldRef = 0;
$home_tmr = 0;
$visitor_tmr = 0;
$post_season = 'F';
$exhibition = 'F';
$conference = 'T';
$weather = '';
$referee = '';
$umpire = '';
$field_judge = '';
$scorekeeper = '';
$timekeeper = '';
$season = date('Y');

$params = 'a=s';
$href_action = set_href(FILENAME_ADMIN_GAME_NEW, $params);
$href_fields = set_href(FILENAME_ADMIN_FIELD);
$params = 'se=A';
$href_team_index = set_href(FILENAME_ADMIN_TEAM_INDEX, $params);

$message = '';
if($action != ''){
	switch($action){
		case 's':
			//retrieve POST variables
			$date			= $db->db_sanitize($_POST['date']);
			$start_time		= $db->db_sanitize($_POST['start_time']);
			$fieldRef		= $_POST['fieldRef'];
			$home_tmr		= $_POST['home_tmr'];
			$visitor_tmr	= $_POST['visitor_tmr'];
			$post_season	= (isset($_POST['post_season']) ? $_POST['post_season'] : 'F');
			$exhibition		= (isset($_POST['exhibition']) ? $_POST['exhibition'] : 'F');
			$weather		= $db->db_sanitize($_POST['weather']);
			$referee		= $db->db_sanitize($_POST['referee']);
			$umpire			= $db->db_sanitize($_POST['umpire']);
			$field_judge	= $db->db_sanitize($_POST['field_judge']);
			$scorekeeper	= $db->db_sanitize($_POST['scorekeeper']);
			$timekeeper		= $db->db_sanitize($_POST['timekeeper']);
			$season			= $_POST['season'];
			$conference		= ($exhibition == 'F' ? 'T' : 'F');
			
			//validation
			//test for current subscription
			$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//test if entering another team's game
			if($message == '' && $home_tmr != $_SESSION['user_tmr'] && $visitor_tmr != $_SESSION['user_tmr']){
				$message = 'You cannot enter someone else\'s game.';
			}
			if($message == ''){
				//process date and time
				$date_test = validate_date($date);
				if($date_test === false){
					$date_str = date('Y-m-d');
					$message .= 'The date must be in mm/dd/YY or mm/dd/YYYY format. ';
				}else{
					$date_str = date('Y-m-d', strtotime($date_test));
				}
				$time_test = validate_time($start_time, $date_str);
				if($time_test === false){
					$time_str = date('H:i', (60 * 60 * 16));
					$timestamp = date('YmdHis', strtotime($date_str) + (60 * 60 * 16));
					$message .= 'The time must be in one of the following four formats: a) HH, b) HH am|pm, c) HH:MM, or d) HH:MM am|pm. ';
				}else{
					$time_str = date('H:i:s', $time_test);
					$timestamp = date('YmdHis', $time_test);
				}
				//test for empty fields
				if(empty($home_tmr) || $home_tmr == 0){
					$message .= 'Please select a home team. ';
				}
				if(empty($visitor_tmr) || $visitor_tmr == 0){
					$message .= 'Please select a visitor team. ';
				}
				if(empty($fieldRef) || $fieldRef == 0){
					$message .= 'Please select a playing field. ';
				}
				//test for current team seasons
				$sql = 'SELECT t1.teamRef AS home_tr, t2.teamRef AS visitor_tr
						FROM teams t1, teams t2
						WHERE t1.teamMasterRef='.$home_tmr.'
							AND t2.teamMasterRef='.$visitor_tmr.'
							AND (t1.season=\''.$season.'\' AND t2.season=\''.$season.'\')';
				$test = $db->db_query($sql);
				$home_tr = $test->field['home_tr'];
				$visitor_tr = $test->field['visitor_tr'];
				if($home_tr == NULL){
					$message .= 'You must create the home team\'s season first. ';
				}
				if($visitor_tr == NULL){
					$message .= 'You must create the visitor team\'s season first. ';
				}
				//test for duplicate game
				if($message == '' && $home_tr > 0 && $visitor_tr > 0){
					$sql = 'SELECT COUNT(*) AS games
							FROM games
							WHERE ((usTeamRef='.$home_tr.' AND themTeamRef='.$visitor_tr.')
								OR (usTeamRef='.$visitor_tr.' AND themTeamRef='.$home_tr.'))
								AND date=\''.$date.'\'';
					$test = $db->db_query($sql);
					if($test->field['games'] > 0){
						$message .= 'A game already exists for these two teams on this date. ';
					}
				}
				//write to disk
				if($message == ''){
					$sql_data_array = array('gameRef' => NULL,
											'season' => $season,
											'seasonType' => $post_season,
											'timestamp' => $timestamp,
											'date' => $date_str,
											'startTime' => $time_str,
											'usTeamRef' => $home_tr,
											'themTeamRef' => $visitor_tr,
											'fieldRef' => $fieldRef,
											'conditions' => $weather,
											'scorekeeper' => $scorekeeper,
											'timekeeper' => $timekeeper,
											'referee' => $referee,
											'umpire' => $umpire,
											'fieldJudge' => $field_judge,
											'conference' => $conference,
											'final' => 'F',
											'modifiedBy' => $_SESSION['user_id'],
											'created' => 'now',
											'modified' => 'now'
											);
					$message = $db->db_write_array('games', $sql_data_array);
				}
				//proceed
				if($message == ''){
					$gameRef = $db->db_insert_id();
					$params = 'gr='.$gameRef.'&sc=0';
					redirect(set_href(FILENAME_ADMIN_GAME_EDIT, $params));
				}
			}
	}
}
?>