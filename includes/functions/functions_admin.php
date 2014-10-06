<?php
/*------------------------------------------------------------
DRAW FIELD DROP DOWN
------------------------------------------------------------*/
function draw_game_field_select($name, $selected_value, $onChange = ''){
	global $db;
	$option_array = array();
	$sql = 'SELECT f.fieldRef, f.town, f.name, s.name AS state
			FROM sites f
			INNER JOIN states s
				ON f.state = s.abbrev
			ORDER BY s.name, f.town';
	$fields = $db->db_query($sql);
	while(!$fields->eof){
		$fieldRef = $fields->field['fieldRef'];
		$town = $fields->field['town'];
		$field_name = $fields->field['name'];
		$state = $fields->field['state'];
		$field_name = set_team_name($town, $field_name);
		
		$option_array[] = array('value' => $fieldRef,
								'label' => $field_name,
								'group' => $state
								);
		$fields->move_next();
	}
	echo draw_select_element_group($name, $option_array, $selected_value, $onChange);
}

/*------------------------------------------------------------
DRAW STATE DROP DOWN
------------------------------------------------------------*/
function draw_team_state_select($name, $selected_value, $page_ref, $onChange = ''){
	global $db;
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	$sql = 'SELECT name, abbrev
			FROM states
			ORDER BY name';
	$states = $db->db_query($sql);
	while(!$states->eof){
		$state_abbrev = $states->field['abbrev'];
		$state_name = $states->field['name'];
		
		$param = 'sn='.$state_abbrev;
		$href = set_href($page_ref, $param);
		$option_array[] = array('value' => $href,
								'label' => $state_name
								);
		
		$states->move_next();
	}
	echo draw_select_element($name, $option_array, $selected_value, $onChange);
}

/*------------------------------------------------------------
DRAW GAME DROP DOWN
------------------------------------------------------------*/
function draw_game_select($name, $teamRef, $selected_value, $onChange){
	global $db;
	$option_array = array();
	$option_array[] = array('value' => 0, 'label' => '');
	$sql = 'SELECT gm.gameRef, gm.date, t2.town AS opponent
			FROM games gm
			INNER JOIN teams t1
				ON (gm.usTeamRef = t1.teamRef OR gm.themTeamRef = t1.teamRef)
			INNER JOIN teams t2
				ON (gm.usTeamRef = t2.teamRef OR gm.themTeamRef = t2.teamRef)
				AND t1.teamRef != t2.teamRef
			WHERE t1.teamRef = "' . $teamRef . '"
			ORDER BY gm.date DESC';
	$games = $db->db_query($sql);
	while(!$games->eof){
		//get data
		$gameRef = $games->field['gameRef'];
		$date = $games->field['date'];
		$opponent = $games->field['opponent'];
		//process data
		$date = date('m/d/y', strtotime($date));
		$label = $date.' '.$opponent;
		$option_array[] = array('value' => $gameRef,
								'label' => $label
								);
		$games->move_next();
	}
	echo draw_select_element($name, $option_array, $selected_value, $onChange);
}

/*------------------------------------------------------------
DRAW FOUL DROP-DOWN
------------------------------------------------------------*/
function draw_violation_select($name, $selected_value = ''){
	global $db;
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	$sql = 'SELECT description, releasable
			FROM fouls
			ORDER BY description';
	$fouls = $db->db_query($sql);
	while(!$fouls->eof){
		$description	= $fouls->field['description'];
		$test			= $fouls->field['releasable'];
		
		$value = $description.'-'.$test;
		$label = $description;
		$option_array[] = array('value' => $value,
								'label' => $label
								);
		$fouls->move_next();
	}
	echo draw_select_element2($name, $option_array, $selected_value);
}

/*------------------------------------------------------------
DRAW PLAYING SURFACE DROP-DOWN
------------------------------------------------------------*/
function draw_surface_select($name, $selected_value = ''){
	$option_array = array();
	$option_array[] = array('value' => 0, 'label' => '');
	for($i = 0; $i < 4; $i++){
		switch($i){
			case 0:
				$value = 'GP';
				$label = 'Grass: Practice';
				break;
			case 1:
				$value = 'GC';
				$label = 'Grass: Competition';
				break;
			case 2:
				$value = 'T';
				$label = 'Turf';
				break;
			case 3:
				$value = 'U';
				$label = 'Unknown surface';
				break;
		}
		$option_array[] = array('value' => $value,
								'label' => $label
								);
	}
	echo draw_select_element($name, $option_array, $selected_value);
}

/*------------------------------------------------------------
BUILD GAME-EDIT PLAYER DROP-DOWN
------------------------------------------------------------*/
function draw_game_player_select($name, $roster, $selected_value, $onChange, $params){
	$option_array = array();
	$option_array[] = array('value' => 0, 'label' => '');
	$count = $roster->count_records();
	for($i = 0; $i < $count; $i++){
		$jerseyNo		= $roster->result['jerseyNo'][$i];
		$player_name	= $roster->result['name'][$i];
		$position		= $roster->result['position'][$i];

		$label = $position.' '.$jerseyNo.' '.$player_name;
		$value = $jerseyNo;
		$option_array[] = array('value' => $value,
								'label' => $label
								);
	}
	echo draw_select_element($name, $option_array, $selected_value, $onChange, $params);
}

//--------------------------------------------------/
//DRAW TEAM SEASON DROP-DOWN LIST
//--------------------------------------------------/
function draw_team_season_select2($team_obj, $page_ref, $selected_value = ''){
	global $_SESSION;
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	if(isset($team_obj)){
		while(!$team_obj->eof){
			$tr = $team_obj->field['teamRef'];
			$sr = $team_obj->field['season'];
			
			$param = 'tmr='.$_SESSION['user_tmr'].'&tr='.$tr.'&s='.$sr.'&pmr=0';
			$href = set_href($page_ref, $param);
			$option_array[] = array('value' => $href,
									'label' => $sr
									);
			$team_obj->move_next();
		}
	}
	$onChange = 'change_season(this.options[this.selectedIndex].value);';
	echo 'Season: '.draw_select_element2('season', $option_array, $selected_value, $onChange);
}

/*------------------------------------------------------------
DRAW PLAYER DROP-DOWN
------------------------------------------------------------*/
function draw_player_select2($tr, $selected_value = '', $page_ref){
	global $db;
	global $_SESSION;
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	
	$sql = 'SELECT IF(pm.FName!=\'\', CONCAT_WS(\' \', pm.FName, pm.LName), pm.LName) AS player_name, pm.reference, p.jerseyNo, t.season
			FROM playerMaster pm
			INNER JOIN players p
				ON pm.reference=p.playerMasterRef
			INNER JOIN teams t
				USING(teamRef)
			WHERE t.teamRef='.$tr.'
			ORDER BY p.jerseyNo';
	$players = $db->db_query($sql);
	while(!$players->eof){
		$pmr			= $players->field['reference'];
		$jerseyNo		= $players->field['jerseyNo'];
		$player_name	= $players->field['player_name'];
		$sr				= $players->field['season'];
		
		$label = $jerseyNo.' '.$player_name;
		$params = 'tmr='.$_SESSION['user_tmr'].'&tr='.$tr.'&s='.$sr.'&pmr='.$pmr;
		$href = set_href(FILENAME_ADMIN_PLAYER, $params);
		$option_array[] = array('value' => $href,
								'label' => $label
								);
		$players->move_next();
	}
	$onChange = 'change_player(this.options[this.selectedIndex].value);';
	echo 'Player: '.draw_select_element('player', $option_array, $selected_value, $onChange);
}

/*------------------------------------------------------------
DRAW CONFERENCE-UPDATE SEASON DROP-DOWN
------------------------------------------------------------*/
function draw_admin_ranking_season_select($season){
	global $db;
	$option_array = array();
	$current_year = date('Y');
	$option_array[] = array('value' => $current_year, 'label' => $current_year);
	$sql = 'SELECT DISTINCT YEAR(date) AS year
			FROM gamesShort
			ORDER BY date DESC';
	$result = $db->db_query($sql);
	while(!$result->eof){
		$year = $result->field['year'];
		if($year != $current_year){
			$option_array[] = array('value' => $year,
									'label' => $year
									);
		}
		$result->move_next();
	}
	echo 'Season: '.draw_select_element('season', $option_array, $season);
}

/*------------------------------------------------------------
DRAW BLOG FORM TYPE DROP-DOWN
------------------------------------------------------------*/
function draw_blog_form_type_select($name, $selected_value, $onChange){
	$option_array = array();
	$option_array[] = array('value' => 'B',
							'label' => 'Save to Blog'
							);
	$option_array[] = array('value' => 'E',
							'label' => 'Send as Email'
							);
	echo draw_select_element($name, $option_array, $selected_value, $onChange);
}

/*------------------------------------------------------------
DRAW BLOG INDIVIDUAL EMAIL DROP-DOWN
------------------------------------------------------------*/
function draw_blog_email_select($name, $teamMasterRef, $teamRef, $selected_value, $onChange){
	global $db;
	$option_array = array();
	$option_array[] = array('label' => '',
							'value' => '',
							'group' => ''
							);
	for($i = 0; $i < 5; $i++){
		switch($i){
			case 0:
				$group = 'Players:';
				$sql = 'SELECT IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS name, pm.email
						FROM players p
						INNER JOIN playerMaster pm
							ON pm.reference=p.playerMasterRef
						WHERE p.teamRef='.$teamRef.'
							AND pm.email!=\'\'
						ORDER BY pm.LName';
				break;
			case 1:
				$group = 'Staff:';
				$sql = 'SELECT name, email
						FROM officials
						WHERE teamRef='.$teamRef.'
							AND email!=\'\'
						ORDER BY name';
				break;
			case 2:
				$group = 'Parents:';
				$sql = 'SELECT pm.parentName AS name, pm.parentEmail
						FROM playerMaster pm
						INNER JOIN players p
							ON pm.reference=p.playerMasterRef
						WHERE p.teamRef='.$teamRef.'
							AND pm.parentEmail!=\'\'
						ORDER BY pm.LName';
				break;
			case 3:
				$group = 'Boosters:';
				$sql = 'SELECT IF(FName!=\'\', CONCAT_WS(\' \', FName, LName), LName) AS name, email
						FROM people
						WHERE teamMasterRef='.$teamMasterRef.'
							AND email!=\'\'
						ORDER BY LName';
				break;
			case 4:
				$group = 'Alumni:';
				$sql = 'SELECT DISTINCT IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName),p.LName) AS name, pm.email
						FROM players p
						INNER JOIN playerMaster pm
							ON p.playerMasterRef=pm.reference
						INNER JOIN teams t
							ON p.teamRef=t.teamRef
						WHERE t.teamMasterRef='.$teamMasterRef.'
							AND t.teamRef!='.$teamRef.'
							AND pm.email!=\'\'
						GROUP BY pm.reference
						ORDER BY p.LName';
				break;
		}
		$result = $db->db_query($sql);
		if(count($result->result['name']) > 0){
			while(!$result->eof){
				$name = $result->field['name'];
				$email = $result->field['email'];
				$option_array[] = array('label' => $name,
										'value' => $email,
										'group' => $group
										);
				$result->move_next();
			}
		}
	}
	echo draw_select_element_group2($name, $option_array, $selected_value, $onChange);
}

/*------------------------------------------------------------
DRAW USER AFFILIATION DROP-DOWN
------------------------------------------------------------*/
function draw_affiliation_select($name, $selected_value){
	global $db;
	$option_array = array();
	$option_array[] = array('value' =>	'0:Administrator',
							'label' => 'Administrator',
							'group' => 'Administrator'
							);
	$sql = 'SELECT s.name AS state, tm.gender, tm.teamMasterRef, tm.town
			FROM teamsMaster tm
			INNER JOIN states s
				ON tm.state=s.abbrev
			ORDER BY tm.state, tm.gender, tm.town';
	$teams = $db->db_query($sql);
	while(!$teams->eof){
		$state = strtoupper($teams->field['state']);
		$gt = $teams->field['gender'];
		$teamMasterRef = $teams->field['teamMasterRef'];
		$town = $teams->field['town'];
		
		$gender = set_gender($gt);
		$option_array[] = array('value' => $teamMasterRef.':'.$town,
								'label' => $town,
								'group' => $state.'-'.$gender.':'
								);
		$teams->move_next();
	}
	echo draw_select_element_group2($name, $option_array, $selected_value);
}

/*------------------------------------------------------------
DRAW SCHOOL YEAR DROP DOWN
------------------------------------------------------------*/
function draw_school_year_select($name, $selected_value){
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	$option_array[] = array('value' => 'Y1',
							'label' => 'Freshman'
							);
	$option_array[] = array('value' => 'Y2',
							'label' => 'Sophmore'
							);
	$option_array[] = array('value' => 'Y3',
							'label' => 'Junior'
							);
	$option_array[] = array('value' => 'Y4',
							'label' => 'Senior'
							);
	echo draw_select_element($name, $option_array, $selected_value);
}

/*------------------------------------------------------------
DRAW SCHOOL YEAR DROP DOWN
------------------------------------------------------------*/
function draw_semester_select($name, $selected_value){
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	$option_array[] = array('value' => 'S1',
							'label' => 'Fall'
							);
	$option_array[] = array('value' => 'S2',
							'label' => 'Winter'
							);
	$option_array[] = array('value' => 'S3',
							'label' => 'Spring'
							);
	$option_array[] = array('value' => 'S4',
							'label' => 'Summer'
							);
	$option_array[] = array('value' => 'SC',
							'label' => 'Cumulative'
							);
	echo draw_select_element($name, $option_array, $selected_value);
}

/*------------------------------------------------------------
DRAW SCHOOL YEAR DROP DOWN
------------------------------------------------------------*/
function draw_class_rank_select($name, $selected_value){
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	$option_array[] = array('value' => 'TT',
							'label' => 'Top 10%'
							);
	$option_array[] = array('value' => 'Q1',
							'label' => 'Top Quartile'
							);
	$option_array[] = array('value' => 'Q2',
							'label' => 'Second Quartile'
							);
	$option_array[] = array('value' => 'H1',
							'label' => 'Top Half'
							);
	$option_array[] = array('value' => 'Q3',
							'label' => 'Third Quartile'
							);
	$option_array[] = array('value' => 'Q4',
							'label' => 'Bottom Quartile'
							);
	echo draw_select_element($name, $option_array, $selected_value);
}

/*------------------------------------------------------------
DRAW SPORT DROP DOWN
------------------------------------------------------------*/
function draw_sport_select($name, $selected_value, $onChange){
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	$option_array[] = array('value' => 'L',
							'label' => 'Lacrosse'
							);
	$option_array[] = array('value' => 'O',
							'label' => 'Other'
							);
	echo draw_select_element($name, $option_array, $selected_value, $onChange);
}

/*------------------------------------------------------------
DRAW COLLEGE BOARD DROP DOWN
------------------------------------------------------------*/
function draw_test_select($name, $selected_value, $onChange){
	global $db;
	$option_array = array();
	$option_array[] = array('value' => 0, 'label' => '');
	$sql = 'SELECT reference, name
			FROM collegeTests
			ORDER BY name';
	$boards = $db->db_query($sql);
	while(!$boards->eof){
		$value = $boards->field['reference'];
		$label = $boards->field['name'];
		$option_array[] = array('value' => $value,
								'label' => $label
								);
		$boards->move_next();
	}
	echo draw_select_element($name, $option_array, $selected_value, $onChange);
}

/*------------------------------------------------------------
DRAW COLLEGE BOARD  PART II
------------------------------------------------------------*/
function draw_subtest($name, $selected_value){
}

/*------------------------------------------------------------
DRAW PLAYER NOTE TYPE DROP-DOWN
------------------------------------------------------------*/
function draw_note_type_select($name, $selected_value, $onChange){
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	for($i = 0; $i < 6; $i++){
		switch($i){
			case 0;
				$value = 'N';
				$label = 'Note';
				break;
			case 1;
				$value = 'E';
				$label = 'Send email from here';
				break;
			case 2;
				$value = 'S';
				$label = 'Email sent from other system';
				break;
			case 3;
				$value = 'R';
				$label = 'Email received';
				break;
			case 4;
				$value = 'L';
				$label = 'Letter';
				break;
			case 5;
				$value = 'T';
				$label = 'Phone call';
				break;
		}
		$option_array[] = array('value' => $value,
								'label' => $label
								);
	}
	echo draw_select_element($name, $option_array, $selected_value, $onChange);
}

/*------------------------------------------------------------
DRAW TEAM STAFF DROP-DOWN
------------------------------------------------------------*/
function draw_staff_type_select($name, $selected_value){
	$option_array = array();
	$option_array[] = array('value' => 0,
							'label' => ''
							);
	$option_array[] = array('value' => 1,
							'label' => 'Head Coach'
							);
	$option_array[] = array('value' => 2,
							'label' => 'Assistant Coach'
							);
	$option_array[] = array('value' => 3,
							'label' => 'Trainer'
							);
	$option_array[] = array('value' => 4,
							'label' => 'Manager'
							);
	$option_array[] = array('value' => 6,
							'label' => 'Parent Coordinator'
							);
	$option_array[] = array('value' => 5,
							'label' => 'Other'
							);
	echo draw_select_element($name, $option_array, $selected_value);
}

/*------------------------------------------------------------
BUILD PLAYER ADDRESS
------------------------------------------------------------*/
function get_address($street1 = '', $city = '', $state = '', $ZIP_Code = '', $street2 = ''){
	$r = array('street' => 'n/a', 'city' => '');
	if($street1 != ''){
		if($street2 != ''){
			$r['street'] = $street1.', '.$street2;
		}else{
			$r['street'] = $street1;
		}
	}
	if($city != ''){
		$r['city'] = $city;
	}
	if($state != ''){
		$r['city'] .= ', '.$state;
	}
	if($ZIP_Code != ''){
		$r['city'] .= ' '.$ZIP_Code;
	}
	return $r;
}

/*------------------------------------------------------------
GET CLASS YEAR (TEXT)
------------------------------------------------------------*/
function get_class_year_text($class){
	$r = '';
	switch($class){
		case 'Y1':
			$r = 'Freshman';
			break;
		case 'Y2':
			$r = 'Sophmore';
			break;
		case 'Y3':
			$r = 'Junior';
			break;
		case 'Y4':
			$r = 'Senior';
			break;
	}
	return $r;
}

/*------------------------------------------------------------
GET TEAM ROSTER
------------------------------------------------------------*/
function get_team_roster($teamRef){
	global $db;
	$sql = 'SELECT jerseyNo, position, IF(FName!=\'\', CONCAT_WS(\' \', FName, LName), LName) AS name
			FROM players
			WHERE teamRef='.$teamRef.'
			ORDER BY jerseyNo';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET FIELD SURFACE
------------------------------------------------------------*/
function get_surface($type){
	$r = '';
	switch($type){
		case 'GP':
			$r = 'Grass: practice';
			break;
		case 'GC':
			$r = 'Grass: Competition';
			break;
		case 'T':
			$r = 'Turf';
			break;
		default:
			$r = 'Unknown';
	}
	return $r;
}

/*------------------------------------------------------------
GET GAME DATA
------------------------------------------------------------*/
function get_game($gameRef){
	global $db;
	$sql = 'SELECT gm.date, gm.usTeamRef, gm.themTeamRef, gm.fieldRef, TIME_TO_SEC(gm.startTime) AS time, gm.referee, gm.umpire, gm.fieldJudge, gm.seasonType, gm.conference, gm.conditions, gm.scorekeeper, gm.timekeeper,
				IF(t1.name!=\'\', CONCAT_WS(\' \', t1.town, t1.name), t1.town) AS us_team, t1.town AS us_town,
				IF(t2.name!=\'\', CONCAT_WS(\' \', t2.town, t2.name), t2.town) AS them_team, t2.town AS them_town,
				IF(f.name!=\'\', CONCAT_WS(\' \', f.town, f.name), f.town) AS field_name, f.town AS field_town
			FROM games gm
			INNER JOIN teams t1
				ON gm.usTeamRef=t1.teamRef
			INNER JOIN teams t2
				ON gm.themTeamRef=t2.teamRef
			INNER JOIN sites f
				ON gm.fieldRef=f.fieldRef
			WHERE gameRef='.$gameRef;
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET GAME PLAY DATA
------------------------------------------------------------*/
function get_game_play_data($gameRef, $teamRef){
	global $db;
	$sql = 'SELECT pl.reference, pl.started, pl.played, pl.position, pl.shotsQ1, pl.shotsQ2, pl.shotsQ3, pl.shotsQ4, pl.shotsOT, pl.gbQ1, pl.gbQ2, pl.gbQ3, pl.gbQ4, pl.gbOT,
				p.jerseyNo, IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS name, p.LName
			FROM plays pl
			INNER JOIN players p
				ON pl.teamRef=p.teamRef
				AND pl.playerRef=p.jerseyNo
			WHERE pl.gameRef='.$gameRef.'
				AND pl.teamRef='.$teamRef.'
			ORDER BY pl.started DESC, pl.playerRef ASC';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET GAME SCORING DATA
------------------------------------------------------------*/
function get_game_scoring_data($gameRef, $teamRef){
	global $db;
	$sql = 'SELECT g.reference, g.scorer, g.assist, g.goalCode, g.quarter, TIME_TO_SEC(g.timeClock) AS clock,
			p1.LName AS scorer_name,
			IF(g.assist!=0, p2.LName, \'\') AS assist_name
			FROM goals g
			LEFT JOIN players p1
				ON g.teamRef=p1.teamRef AND g.scorer=p1.jerseyNo
			LEFT JOIN players p2
				ON g.teamRef=p2.teamRef AND g.assist=p2.jerseyNo
			WHERE g.gameRef='.$gameRef.'
				AND g.teamRef='.$teamRef.'
			ORDER BY g.quarter ASC, clock DESC';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET GAME PENALTY DATA
------------------------------------------------------------*/
function get_game_penalty_data($gameRef, $teamRef){
	global $db;
	$sql = 'SELECT pn.reference, pn.playerRef, pn.startQtr, TIME_TO_SEC(pn.startTime) AS clock, pn.duration, pn.infraction, p.LName
			FROM penalties pn
			INNER JOIN players p
				ON pn.teamRef=p.teamRef AND pn.playerRef=p.jerseyNo
			WHERE pn.gameRef='.$gameRef.'
				AND pn.teamRef='.$teamRef.'
			ORDER BY startQtr ASC, startTime DESC';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET GAME SAVE DATA
------------------------------------------------------------*/
function get_game_goalie_data($gameRef, $teamRef){
	global $db;
	$sql = 'SELECT sv.reference, sv.savedQ1, sv.savedQ2, sv.savedQ3, sv.savedQ4, sv.savedOT, sv.allowedQ1, sv.allowedQ2, sv.allowedQ3, sv.allowedQ4, sv.allowedOT,
				p.jerseyNo, p.LName
			FROM saves sv
			INNER JOIN players p
				ON sv.teamRef=p.teamRef
				AND sv.playerRef=p.jerseyNo
			WHERE sv.gameRef='.$gameRef.'
				AND sv.teamRef='.$teamRef.'
			ORDER BY sv.playerRef';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET GAME FACEOFF DATA
------------------------------------------------------------*/
function get_game_faceoff_data($gameRef, $teamRef){
	global $db;
	$sql = 'SELECT fo.reference, fo.wonQ1, fo.wonQ2, fo.wonQ3, fo.wonQ4, fo.wonOT, fo.lostQ1, fo.lostQ2, fo.lostQ3, fo.lostQ4, fo.lostOT,
				p.jerseyNo, p.LName
			FROM faceoffs fo
			INNER JOIN players p
				ON fo.teamRef=p.teamRef
				AND fo.playerRef=p.jerseyNo
			WHERE fo.gameRef='.$gameRef.'
				AND fo.teamRef='.$teamRef.'
			ORDER BY fo.playerRef';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET GAME CLEAR DATA
------------------------------------------------------------*/
function get_game_clear_data($gameRef, $teamRef){
	global $db;
	$sql = 'SELECT reference, clearedQ1, clearedQ2, clearedQ3, clearedQ4, clearedOT, failedQ1, failedQ2, failedQ3, failedQ4, failedOT
			FROM clears
			WHERE gameRef='.$gameRef.'
				AND teamRef='.$teamRef;
	$r = $db->db_query($sql);
	return $r;
}
function get_team_clear_data($recordID){
	global $db;
	$sql = 'SELECT teamRef, clearedQ1, clearedQ2, clearedQ3, clearedQ4, clearedOT, failedQ1, failedQ2, failedQ3, failedQ4, failedOT
			FROM clears
			WHERE reference='.$recordID;
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET PLAYER PLAY DATA
------------------------------------------------------------*/
function get_player_play_data($recordID){
	global $db;
	$sql = 'SELECT pl.playerRef, pl.teamRef, pl.started, pl.played, pl.position, pl.shotsQ1, pl.shotsQ2, pl.shotsQ3, pl.shotsQ4, pl.shotsOT, pl.gbQ1, pl.gbQ2, pl.gbQ3, pl.gbQ4, pl.gbOT
			FROM plays pl
			WHERE pl.reference='.$recordID;
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET PLAYER SCORING DATA
------------------------------------------------------------*/
function get_player_scoring_data($recordID){
	global $db;
	$sql = 'SELECT g.teamRef, g.quarter, g.timeClock, g.scorer, g.assist
			FROM goals g
			WHERE reference='.$recordID;
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET PLAYER PENALTY DATA
------------------------------------------------------------*/
function get_player_penalty_data($recordID){
	global $db;
	$sql = 'SELECT pn.teamRef, pn.playerRef, pn.startQtr, TIME_TO_SEC(pn.startTime) AS clock, pn.duration, pn.infraction
			FROM penalties pn
			WHERE pn.reference='.$recordID;
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET PLAYER SAVE DATA
------------------------------------------------------------*/
function get_player_goalie_data($recordID){
	global $db;
	$sql = 'SELECT sv.teamRef, sv.playerRef, sv.savedQ1, sv.savedQ2, sv.savedQ3, sv.savedQ4, sv.savedOT, sv.allowedQ1, sv.allowedQ2, sv.allowedQ3, sv.allowedQ4, sv.allowedOT
			FROM saves sv
			WHERE sv.reference='.$recordID;
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET PLAYER FACEOFF DATA
------------------------------------------------------------*/
function get_player_faceoff_data($recordID){
	global $db;
	$sql = 'SELECT fo.teamRef, fo.playerRef, fo.wonQ1, fo.wonQ2, fo.wonQ3, fo.wonQ4, fo.wonOT, fo.lostQ1, fo.lostQ2, fo.lostQ3, fo.lostQ4, fo.lostOT
			FROM faceoffs fo
			WHERE fo.reference='.$recordID;
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET PLAYER ATHLETIC DATA
------------------------------------------------------------*/
function get_player_athletics($playerMasterRef){
	global $db;
	$sql = 'SELECT reference, date, year, sport, description
			FROM playerAthletics
			WHERE playerMasterRef='.$playerMasterRef.'
			ORDER BY sport, year DESC';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET PLAYER ACADEMIC DATA
------------------------------------------------------------*/
function get_player_academics($playerMasterRef){
	global $db;
	$sql = 'SELECT reference, date, semester, classes, activities, gpa, rank, major, colleges
			FROM playerAcademics
			WHERE playerMasterRef='.$playerMasterRef.'
			ORDER BY date DESC';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET PLAYER TEST SCORE DATA
------------------------------------------------------------*/
function get_player_tests($playerMasterRef){
	global $db;
	$sql = 'SELECT p.reference, p.date, t.name
			FROM playerTests p
			INNER JOIN collegeTests t
				ON p.test=t.reference
			WHERE p.playerMasterRef='.$playerMasterRef.'
			ORDER BY p.date DESC';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET PLAYER LETTERS DATA
------------------------------------------------------------*/
function get_player_letters($playerMasterRef){
	global $db;
	$sql = 'SELECT reference, date, current, comments
			FROM playerComments
			WHERE playerMasterRef='.$playerMasterRef.'
			ORDER BY date DESC';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET PLAYER NOTES DATA
------------------------------------------------------------*/
function get_player_notes($playerMasterRef){
	global $db;
	$sql = 'SELECT reference, type, date, contact, subject
			FROM contactNotes
			WHERE playerRef='.$playerMasterRef.'
			ORDER BY created DESC';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
SET VIOLATION DATA
------------------------------------------------------------*/
function set_penalty($clock, $start_quarter, $duration, $gameRef, $teamRef, $releasable){
	global $db;
	//1. compute end time and end quarter
	$start_time = strtotime($clock);
	//add 10 seconds per NCAA rules (Appendix II Sec. I par g)
	$duration = ($duration * 60) + 10;
	$tmp_end_time = $start_time - $duration;
	if($tmp_end_time > 0){
		$end_quarter = $start_quarter;
		$end_time = $tmp_end_time;
	}else{
		if($start_quarter == '4'){
			$end_quarter = 'OT';
			$end_time = (4 * 60) + $tmp_end_time;
		}elseif(substr($start_quarter, 0, 1) == 'O'){
			if(substr($start_quarter, -1) == 'T'){
				$end_quarter = 'O2';
			}else{
				$end_quarter = 'O'.(intval(substr($start_quarter, -1)) + 1);
			}
			$end_time = (4 * 60) + $tmp_end_time;
		}else{
			$end_quarter = strval(intval($start_quarter) + 1);
			$end_time = (12 * 60) + $tmp_end_time;
		}
	}
	//2. compute and update goal codes
	$goal_code = '';
	$start1 = $start_time;
	$start2 = 0;
	$end1 = $end_time;
	$end2 = 0;
	if($start_quarter != $end_quarter){
		if(substr($end_quarter, 0, 1) == 'O'){
			$start2 = 4 * 60;
			$end2 = $end_time;
		}else{
			$start2 = 12 * 60;
			$end2 = $end_time;
		}
	}
	$sql = 'SELECT quarter, timeClock, teamRef, reference
			FROM goals
			WHERE gameRef='.$gameRef.'
				AND (quarter=\''.$start_quarter.'\' OR quarter=\''.$end_quarter.'\')
			ORDER BY quarter ASC, timeClock DESC';
	$goals = $db->db_query($sql);
	if($goals->result['reference'] > 0){
		while(!$goals->eof){
			//get data
			$goal_quarter = $goals->field['quarter'];
			$goal_clock = $goals->field['timeClock'];
			$goal_teamRef = $goals->field['teamRef'];
			$goalID = $goals->field['reference'];
			//process data
			$goal_time = strtotime($goal_clock);
			if($goal_quarter == $start_quarter){
				if($start1 > $goal_time && $end1 <= $goal_time){
					if($goal_teamRef == $teamRef){
						$goal_code = 'DN';
					}else{
						$goal_code = 'UP';
						if($releasable == 'T'){
							$end_quarter = $start_quarter;
							$end_time = $goal_time;
							$end1 = $goal_time;
						}
					}
					$sql = 'UPDATE goals
							SET goalCode=\''.$goal_code.'\'
							WHERE reference='.$goalID;
					$message = $db->db_write($sql);
				}
			}elseif($goal_quarter == $end_quarter){
				if($start2 > $goal_time && $end2 <= $goal_time){
					if($goal_teamRef == $teamRef){
						$goal_code = 'DN';
					}else{
						$goal_code = 'UP';
						if($releasable == 'T'){
							$end_time = $goal_time;
							$end2 = $goal_time;
						}
					}
					$sql = 'UPDATE goals
							SET goalCode=\''.$goal_code.'\'
							WHERE reference='.$goalID;
					$message = $db->db_write($sql);
				}
			}
			
			$goals->move_next();
		}
	}
	//return data
	$r = array('end_quarter' => $end_quarter,
			   'end_time' => $end_time
			   );
	return $r;
}
?>