<?php
/***************************************************/
//TEAM FUNCTIONS
/***************************************************/
//--------------------------------------------------/
//GET TEAM PAGE HEADLINE
//--------------------------------------------------/
function get_team_headline($teamRef, $season){
	global $db;
	$sql = 'SELECT town, name
			FROM teams
			WHERE teamRef='.$teamRef;
	$team = $db->db_query($sql);
	$town = $team->field['town'];
	$name = $team->field['name'];
	
	$team_name = set_team_name($town, $name);
	$page_title = strtoupper($team_name).'<br>'.$season;
	
	$r = array();
	$r[] = $page_title;
	$r[] = $town;
	return($r);
}

//--------------------------------------------------/
// GET TEAM RECORD
//--------------------------------------------------/
function get_team_record($teamRef, $param){
	global $db;
	$us = 0;
	$them = 0;
	$wins = 0;
	$losses = 0;
	$games = 0;
	$dt = null;
	$sql = 'SELECT g.date, s.teamRef, COUNT(s.scorer) AS score
			FROM goals s
			INNER JOIN games g
				USING (gameRef)
			WHERE g.final!=\'F\' AND (g.usTeamRef='.$teamRef.' OR g.themTeamRef='.$teamRef.') '.$param.'
			GROUP BY g.date, s.teamRef
			ORDER BY date';
	$goals = $db->db_query($sql);
	if($goals->limit > 0){
		while(!$goals->eof){
			$date = $goals->field['date'];
			$tr = $goals->field['teamRef'];
			$score = $goals->field['score'];
			
			if($date != $dt){
				if($dt != null){
					if($us > $them){
						$wins++;
					}else{
						$losses++;
					}
					$games++;
					$us = 0;
					$them = 0;
				}
				$dt = $date;
			}
			if($tr != $teamRef){
				$them = $score;
			}else{
				$us = $score;
			}
			$goals->move_next();
		}
		if($us > $them){
			$wins++;
		}else{
			$losses++;
		}
		$games++;
		$r = array('wins' => $wins, 'losses' => $losses, 'games' => $games);
	}else{
		$r = array('wins' => 0, 'losses' => 0, 'games' => 0);
	}
	return $r;
}

//--------------------------------------------------/
//DRAW TEAM DROP-DOWN LIST
//--------------------------------------------------/
function draw_team_select($town, $season, $page_ref){
	global $db;
	$option_array = array();
	$sql = 'SELECT s.name, tm.gender, tm.teamMasterRef, t.teamRef, t.town
			FROM teams t
			INNER JOIN teamsMaster tm
				USING (teamMasterRef)
			INNER JOIN states s
				ON tm.state=s.abbrev
			WHERE t.season=\''.$season.'\'
			ORDER BY tm.state, tm.gender, t.town';
	$teams = $db->db_query($sql);
	while(!$teams->eof){
		$state = strtoupper($teams->field['name']);
		$gt = $teams->field['gender'];
		$tmr = $teams->field['teamMasterRef'];
		$tr = $teams->field['teamRef'];
		$tn = $teams->field['town'];
		
		$gender = set_gender($gt);
		$param = 'tmr='.$tmr.'&tr='.$tr.'&s='.$season.'&ty=F&se=All';
		$href = set_href($page_ref, $param);
		$option_array[] = array('group' => $state.'-'.$gender.':',
								'value' => $href,
								'label' => $tn
								);
	
		$teams->move_next();
	}
	$onChange = 'changeTeam(this.options[this.selectedIndex].value);';
	echo 'Team: '.draw_select_element_group2('team', $option_array, $town, $onChange);
}
function draw_team_select2($name, $selected_value, $onChange = ''){
	global $db;
	$option_array = array();
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
		$option_array[] = array('value' => $teamMasterRef,
								'label' => $town,
								'group' => $state.'-'.$gender.':'
								);
		$teams->move_next();
	}
	echo draw_select_element_group($name, $option_array, $selected_value, $onChange);
}

//--------------------------------------------------/
//GET TEAM PRIOR-YEAR ROSTER DROP-DOWN
//--------------------------------------------------/
function draw_returning_player_select($name, $teamMasterRef, $prior_year){
	global $db;
	$option_array = array();
	$option_array[] = array('value' => 0, 'label' => '');
	$sql = 'SELECT p.reference, IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS name, p.jerseyNo
			FROM players p
			INNER JOIN teams t
				USING(teamRef)
			WHERE t.teamMasterRef='.$teamMasterRef.'
				AND t.season=\''.$prior_year.'\'
			ORDER BY p.jerseyNo';
	$roster = $db->db_query($sql);
	while(!$roster->eof){
		$playerRef = $roster->field['reference'];
		$player_name = $roster->field['name'];
		$jerseyNo = $roster->field['jerseyNo'];
		$label = $jerseyNo.' '.$player_name;
		
		$option_array[] = array('value' => $playerRef,
								'label' => $label
								);
		$roster->move_next();
	}
	echo draw_select_element($name, $option_array);
}

//--------------------------------------------------/
//DRAW TEAM SEASON DROP-DOWN LIST
//--------------------------------------------------/
function draw_team_season_select($teamMasterRef, $season, $page_ref){
	global $db;
	$option_array = array();
	$sql = 'SELECT DISTINCT season, teamRef
			FROM teams
			WHERE teamMasterRef='.$teamMasterRef.'
			ORDER BY season DESC';
	$seasons = $db->db_query($sql);
	while(!$seasons->eof){
		$tr = $seasons->field['teamRef'];
		$sr = $seasons->field['season'];
		
		if($page_ref == FILENAME_ADMIN_PHOTOS){
			$param = 'tmr='.$teamMasterRef.'&tr='.$tr.'&s='.$sr;
		}else{
			$param = 'tmr='.$teamMasterRef.'&tr='.$tr.'&s='.$sr.'&ty=F&se=All';
		}
		$href = set_href($page_ref, $param);
		$option_array[] = array('value' => $href, 'label' => $sr);
		
		$seasons->move_next();
	}
	$onChange = 'changeYear(this.options[this.selectedIndex].value);';
	echo 'Season: '.draw_select_element2('season', $option_array, $season, $onChange);
}

//--------------------------------------------------/
//DRAW TEAM GENDER DROP-DOWN LIST
//--------------------------------------------------/
function draw_team_gender_select($selected_value){
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	for($i = 0; $i < 4; $i++){
		switch($i){
			case 0:
				$value = 'B';
				$label = 'Boys';
				break;
			case 1:
				$value = 'G';
				$label = 'Girls';
				break;
			case 2:
				$value = 'M';
				$label = 'Men';
				break;
			case 3:
				$value = 'W';
				$label = 'Women';
				break;
		}
		$option_array[] = array('value' => $value, 'label' => $label);
	}
	echo draw_select_element('gender', $option_array, $selected_value);
}

//--------------------------------------------------/
//DRAW TEAM TYPE DROP-DOWN LIST
//--------------------------------------------------/
function draw_team_type_select($selected_value){
	$option_array = array();
	$option_array[] = array('value' => '', 'label' => '');
	for($i = 0; $i < 4; $i++){
		switch($i){
			case 0:
				$value = 'V';
				$label = 'Varsity';
				break;
			case 1:
				$value = 'J';
				$label = 'Junior Varsity';
				break;
			case 2:
				$value = 'F';
				$label = 'Freshman';
				break;
			case 3:
				$value = 'Y';
				$label = 'Youth';
				break;
		}
		$option_array[] = array('value' => $value, 'label' => $label);
	}
	echo draw_select_element('type', $option_array, $selected_value);
}

//--------------------------------------------------/
//SET TEAM GENDER
//--------------------------------------------------/
function set_gender($gender){
	switch($gender){
		case 'B':
			$r = 'BOYS';
			break;
		case 'G':
			$r = 'GIRLS';
			break;
		case 'M':
			$r = 'MEN';
			break;
		case 'W':
			$r = 'WOMEN';
			break;
	}
	return $r;
}

//--------------------------------------------------/
//SET TEAM LETTER
//--------------------------------------------------/
function set_team_letter($letter){
	switch($letter){
		case 'F':
			$r = 'Freshman';
			break;
		case 'J':
			$r = 'Junior Varsity';
			break;
		case 'Y':
			$r = 'Youth';
			break;
		default:
			$r = 'Varsity';
	}
	return $r;
}

//--------------------------------------------------/
//SET STAFF TITLES
//--------------------------------------------------/
function set_staff_title($type){
	switch($type){
		case '1':
			$r = 'Head Coach:';
			break;
		case '2':
			$r = 'Assistant Coach:';
			break;
		case '3':
			$r = 'Trainer:';
			break;
		case '4':
			$r = 'Manager:';
			break;
		case '6':
			$r = 'Parent Coordinator:';
			break;
		default:
			$r = 'Other:';
	}
	return $r;
}
function set_staff_short_title($type){
	switch($type){
		case '1':
			$r = 'Head Coach';
			break;
		case '2':
			$r = 'Asst Coach';
			break;
		case '3':
			$r = 'Trainer';
			break;
		case '4':
			$r = 'Manager';
			break;
		case '6':
			$r = 'Parent Coord';
			break;
		default:
			$r = 'Other';
	}
	return $r;
}

//--------------------------------------------------/
//GET TEAM TYPE TEXT
//--------------------------------------------------/
function get_team_type($v){
	$r = '';
	switch($v){
		case 'Y':
			$r='Youth';
			break;
		case 'F':
			$r='Freshman';
			break;
		case 'J':
			$r='JV';
			break;
		case 'V':
			$r='Varsity';
			break;
		default:
			$r = $v;
			break;
	}
	return $r;
}

//--------------------------------------------------/
//GET TEAM GAMES
//--------------------------------------------------/
function get_games_played($teamRef, $param){
	global $db;
	$sql = 'SELECT COUNT(*) AS games
			FROM games
			WHERE final!=\'F\' AND (usTeamRef='.$teamRef.' OR themTeamRef='.$teamRef.') '.$param;
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET TEAM GOAL SUMMARY
//--------------------------------------------------/
function get_team_goals_summary($param){
	global $db;
	$sql = 'SELECT COUNT(*) AS tot_goals,
				SUM(IF(quarter=\'1\', 1, 0)) AS goals_q1,
				SUM(IF(quarter=\'2\', 1, 0)) AS goals_q2,
				SUM(IF(quarter=\'3\', 1, 0)) AS goals_q3,
				SUM(IF(quarter=\'4\', 1, 0)) AS goals_q4,
				SUM(IF(quarter LIKE \'O%\', 1, 0)) AS goals_ot,
				SUM(IF(assist>0 AND quarter=\'1\', 1, 0)) AS assists_q1,
				SUM(IF(assist>0 AND quarter=\'2\', 1, 0)) AS assists_q2,
				SUM(IF(assist>0 AND quarter=\'3\', 1, 0)) AS assists_q3,
				SUM(IF(assist>0 AND quarter=\'4\', 1, 0)) AS assists_q4,
				SUM(IF(assist>0 AND quarter LIKE \'O%\', 1, 0)) AS assists_ot,
				SUM(IF(assist=0, 1, 0)) AS unassisted,
				SUM(IF(assist>0, 1, 0)) AS assisted,
				SUM(IF(goalCode=\'UP\', 1, 0)) AS man_up,
				SUM(IF(goalCode=\'DN\', 1, 0)) AS man_down
			FROM goals p
			INNER JOIN games g
				USING (gameRef)
			WHERE '.$param.'
				AND final!=\'F\'';
	$result = $db->db_query($sql);
	return($result);
}

//--------------------------------------------------/
//GET TEAM PLAYING STATS SUMMARY
//--------------------------------------------------/
function get_team_plays_summary($param){
	global $db;
	$sql = 'SELECT SUM(p.shotsQ1) AS shots_q1,
				SUM(p.shotsQ2) AS shots_q2,
				SUM(p.shotsQ3) AS shots_q3,
				SUM(p.shotsQ4) AS shots_q4,
				SUM(p.shotsOT) AS shots_ot,
				SUM(p.shotsQ1 + p.shotsQ2 + p.shotsQ3 + p.shotsQ4 + p.shotsOT) AS tot_shots,
				SUM(p.gbQ1) AS gb_q1,
				SUM(p.gbQ2) AS gb_q2,
				SUM(p.gbQ3) AS gb_q3,
				SUM(p.gbQ4) AS gb_q4,
				SUM(p.gbOT) AS gb_ot,
				SUM(p.gbQ1 + p.gbQ2 + p.gbQ3 + p.gbQ4 + p.gbOT) AS gb
			FROM plays p
			INNER JOIN games g
				USING (gameRef)
			WHERE '.$param.'
				AND final!=\'F\'';
	$result = $db->db_query($sql);
	return($result);
}

//--------------------------------------------------/
//GET TEAM FACEOFF STATS SUMMARY
//--------------------------------------------------/
function get_team_faceoffs_summary($param){
	global $db;
	$sql = 'SELECT
				SUM(p.wonQ1) AS won_q1,
				SUM(p.wonQ2) AS won_q2,
				SUM(p.wonQ3) AS won_q3,
				SUM(p.wonQ4) AS won_q4,
				SUM(p.wonOT) AS won_ot,
				SUM(p.wonQ1 + p.wonQ2 + p.wonQ3 + p.wonQ4 + p.wonOT) AS won,
				SUM(p.lostQ1) AS lost_q1,
				SUM(p.lostQ2) AS lost_q2,
				SUM(p.lostQ3) AS lost_q3,
				SUM(p.lostQ4) AS lost_q4,
				SUM(p.lostOT) AS lost_ot,
				SUM(p.lostQ1 + p.lostQ2 + p.lostQ3 + p.lostQ4 + p.lostOT) AS lost
			FROM faceoffs p
			INNER JOIN games g
				USING (gameRef)
			WHERE '.$param.'
				AND final!=\'F\'';
	$result = $db->db_query($sql);
	return($result);
}

//--------------------------------------------------/
//GET TEAM CLEAR STATS SUMMARY
//--------------------------------------------------/
function get_team_clears_summary($param){
	global $db;
	$sql = 'SELECT
				SUM(p.clearedQ1) AS cleared_q1,
				SUM(p.clearedQ2) AS cleared_q2,
				SUM(p.clearedQ3) AS cleared_q3,
				SUM(p.clearedQ4) AS cleared_q4,
				SUM(p.clearedOT) AS cleared_ot,
				SUM(p.clearedQ1 + p.clearedQ2 + p.clearedQ3 + p.clearedQ4 + p.clearedOT) AS cleared,
				SUM(p.failedQ1) AS failed_q1,
				SUM(p.failedQ2) AS failed_q2,
				SUM(p.failedQ3) AS failed_q3,
				SUM(p.failedQ4) AS failed_q4,
				SUM(p.failedOT) AS failed_ot,
				SUM(p.failedQ1 + p.failedQ2 + p.failedQ3 + p.failedQ4 + p.failedOT) AS failed
			FROM clears p
			INNER JOIN games g
				USING (gameRef)
			WHERE '.$param.'
				AND final!=\'F\'';
	$result = $db->db_query($sql);
	return($result);
}

//--------------------------------------------------/
//GET TEAM PENALTY STATS SUMMARY
//--------------------------------------------------/
function get_team_penalties_summary($param){
	global $db;
	$sql = 'SELECT COUNT(p.reference) AS penalties,
				SUM(p.duration) AS minutes
			FROM penalties p
			INNER JOIN games g
			USING (gameRef)
			WHERE '.$param.'
				AND final!=\'F\'';
	$result = $db->db_query($sql);
	return($result);
}

//--------------------------------------------------/
//GET TEAM SAVE STATS SUMMARY
//--------------------------------------------------/
function get_team_saves_summary($param){
	global $db;
	$sql = 'SELECT SUM(p.savedQ1 + p.savedQ2 + p.savedQ3 + p.savedQ4 + p.savedOT) AS tot_saves,
				SUM(p.allowedQ1 + p.allowedQ2 + p.allowedQ3 + p.allowedQ4 + p.allowedOT) AS tot_ga,
				SUM(p.savedQ1) AS saves_q1,
				SUM(p.savedQ2) AS saves_q2,
				SUM(p.savedQ3) AS saves_q3,
				SUM(p.savedQ4) AS saves_q4,
				SUM(p.savedOT) AS saves_ot,
				SUM(p.allowedQ1) AS ga_q1,
				SUM(p.allowedQ2) AS ga_q2,
				SUM(p.allowedQ3) AS ga_q3,
				SUM(p.allowedQ4) AS ga_q4,
				SUM(p.allowedOT) AS ga_ot
			FROM saves p
			INNER JOIN games g
				USING (gameRef)
			WHERE '.$param.'
				AND final!=\'F\'';
	$result = $db->db_query($sql);
	return($result);
}

//--------------------------------------------------/
//GET TEAM GAMES
//--------------------------------------------------/
function get_games($teamRef, $param){
	global $db;
	$sql = 'SELECT g.gameRef, g.date, g.startTime, g.fieldRef, g.usTeamRef, g.themTeamRef, g.away, g.seasonType, g.final, g.created, g.modified, t.town, t.teamMasterRef, t.teamRef, f.town AS field
			FROM teams t
			INNER JOIN games g
				ON t.teamRef=g.usTeamRef OR t.teamRef=g.themTeamRef
			INNER JOIN sites f
				USING (fieldRef)
			WHERE (g.usTeamRef='.$teamRef.' OR g.themTeamRef='.$teamRef.')
				AND t.teamRef!='.$teamRef.'
				AND '.$param.'
			ORDER BY g.date';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET TEAM SCORES
//--------------------------------------------------/
function get_team_scores($teamRef){
	global $db;
	$sql = 'SELECT gm.gameRef,
				SUM(IF(g.teamRef='.$teamRef.', 1, 0)) AS score_us,
				SUM(IF(g.teamRef='.$teamRef.', 0, 1)) AS score_them
			FROM goals g
			INNER JOIN games gm
				USING(gameRef)
			WHERE (gm.usTeamRef='.$teamRef.' OR gm.themTeamRef='.$teamRef.')
				AND gm.final!=\'F\'
			GROUP BY gm.gameRef
			ORDER BY gm.gameRef';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET TEAM GOAL STATS BY GAME
//--------------------------------------------------/
function get_team_goals($teamRef){
	global $db;
	$sql = 'SELECT g.gameRef,
				COUNT(g.scorer) AS goals,
				SUM(IF(g.quarter=\'1\', 1, 0)) AS goals_q1,
				SUM(IF(g.quarter=\'2\', 1, 0)) AS goals_q2,
				SUM(IF(g.quarter=\'3\', 1, 0)) AS goals_q3,
				SUM(IF(g.quarter=\'4\', 1, 0)) AS goals_q4,
				SUM(IF(g.quarter LIKE \'O%\', 1, 0)) AS goals_ot,
				SUM(IF(g.assist>0, 1, 0)) AS assists,
				SUM(IF(g.assist>0, 0, 1)) AS unassisted,
				SUM(IF(g.goalCode=\'UP\', 1, 0)) AS man_up,
				SUM(IF(g.goalCode=\'DN\', 1, 0)) AS man_down
			FROM goals g
			INNER JOIN games gm
				ON g.gameRef=gm.gameRef AND g.teamRef='.$teamRef.'
			WHERE (gm.usTeamRef='.$teamRef.' OR gm.themTeamRef='.$teamRef.')
				AND gm.final!=\'F\'
			GROUP BY gm.gameRef
			ORDER BY gm.gameRef';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET TEAM PLAYING STATS BY GAME
//--------------------------------------------------/
function get_team_plays($teamRef){
	global $db;
	$sql = 'SELECT gm.gameRef,
				SUM(p.shotsQ1 + p.shotsQ2 + p.shotsQ3 + p.shotsQ4 + p.shotsOT) AS shots,
				SUM(p.gbQ1 + p.gbQ2 + p.gbQ3 + p.gbQ4 + p.gbOT) AS gb
			FROM plays p
			INNER JOIN games gm
				ON p.gameRef=gm.gameRef AND p.teamRef='.$teamRef.'
			WHERE (gm.usTeamRef='.$teamRef.' OR gm.themTeamRef='.$teamRef.')
				AND gm.final!=\'F\'
			GROUP BY gm.gameRef
			ORDER BY gm.gameRef';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET TEAM FACEOFF STATS BY GAME
//--------------------------------------------------/
function get_team_faceoffs($teamRef){
	global $db;
	$sql = 'SELECT gm.gameRef,
				SUM(fo.wonQ1 + fo.wonQ2 + fo.wonQ3 + fo.wonQ4 + fo.wonOT) AS fo_won,
				SUM(fo.lostQ1 + fo.lostQ2 + fo.lostQ3 + fo.lostQ4 + fo.lostOT) AS fo_lost
			FROM faceoffs fo
			INNER JOIN games gm
				ON fo.gameRef=gm.gameRef AND fo.teamRef='.$teamRef.'
			WHERE (gm.usTeamRef='.$teamRef.' OR gm.themTeamRef='.$teamRef.')
				AND gm.final!=\'F\'
			GROUP BY gm.gameRef
			ORDER BY gm.gameRef';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET TEAM PENALTY STATS BY GAME
//--------------------------------------------------/
function get_team_penalties($teamRef){
	global $db;
	$sql = 'SELECT gm.gameRef,
				COUNT(pn.reference) AS penalties,
				SUM(pn.duration) AS minutes
			FROM penalties pn
			INNER JOIN games gm
				ON pn.gameRef=gm.gameRef AND pn.teamRef='.$teamRef.'
			WHERE (gm.usTeamRef='.$teamRef.' OR gm.themTeamRef='.$teamRef.')
				AND gm.final!=\'F\'
			GROUP BY gm.gameRef
			ORDER BY gm.gameRef';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET PLAYER GOALS
//--------------------------------------------------/
function get_teamPlayer_goals($teamRef, $param = ''){
	global $db;
	$sql = 'SELECT s.scorer, COUNT(s.scorer) AS goals
			FROM goals s
			INNER JOIN games g
				USING (gameRef)
			WHERE s.teamRef='.$teamRef.'
				AND final!=\'F\''.$param.'
			GROUP BY s.scorer';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET PLAYER GOALS
//--------------------------------------------------/
function get_teamPlayer_assists($teamRef, $param = ''){
	global $db;
	$sql = 'SELECT s.assist, COUNT(s.assist) AS assists
			FROM goals s
			INNER JOIN games g
				USING (gameRef)
			WHERE s.teamRef='.$teamRef.'
				AND final!=\'F\''.$param.'
			GROUP BY s.assist';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET PLAYER SHOTS AND GBS
//--------------------------------------------------/
function get_teamPlayer_plays($teamRef, $param = ''){
	global $db;
	$sql = 'SELECT p.playerRef AS jerseyNo,
				SUM(p.shotsQ1 + p.shotsQ2 + p.shotsQ3 + p.shotsQ4 + p.shotsOT) AS sh,
				SUM(p.gbQ1 + p.gbQ2 + p.gbQ3 + p.gbQ4 + p.gbOT) AS gb
			FROM plays p
			INNER JOIN games g
				USING (gameRef)
			WHERE p.teamRef ='.$teamRef.'
				AND final!=\'F\''.$param.'
			GROUP BY p.playerRef';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET PLAYER FACEOFFS
//--------------------------------------------------/
function get_teamPlayer_faceoffs($teamRef, $param = ''){
	global $db;
	$sql = 'SELECT fo.playerRef AS jerseyNo,
				SUM(fo.wonQ1 + fo.wonQ2 + fo.wonQ3 + fo.wonQ4 + fo.wonOT) AS won,
				SUM(fo.lostQ1 + fo.lostQ2 + fo.lostQ3 + fo.lostQ4 + fo.lostOT) AS lost
			FROM faceoffs fo
			INNER JOIN games g
				USING (gameRef)
			WHERE fo.teamRef ='.$teamRef.'
				AND final!=\'F\''.$param.'
			GROUP BY fo.playerRef
			ORDER BY won DESC';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET PLAYER SAVES
//--------------------------------------------------/
function get_teamPlayer_saves($teamRef, $param = ''){
	global $db;
	$sql = 'SELECT s.playerRef AS jerseyNo,
				SUM(s.savedQ1 + s.savedQ2 + s.savedQ3 + s.savedQ4 + s.savedOT) AS saved,
				SUM(s.allowedQ1 + s.allowedQ2 + s.allowedQ3 + s.allowedQ4 + s.allowedOT) AS allowed,
				COUNT(s.gameRef) AS games
			FROM saves s
			INNER JOIN games g
				USING (gameRef)
			WHERE s.teamRef ='.$teamRef.'
				AND final!=\'F\''.$param.'
			GROUP BY s.playerRef
			ORDER BY saved DESC';
	$result = $db->db_query($sql);
	return $result;
}

//--------------------------------------------------/
//GET MAN-UP OPPORTUNITIES
//--------------------------------------------------/
function get_manUp_opps_summary($param){
	global $db;
	$period = null;
	$opportunities = 0;
	$counter = 0;
	
	$sql = 'SELECT p.startQtr, p.startTime, p.endQtr, p.endTime
			FROM penalties p
			INNER JOIN games g
				USING (gameRef)
			WHERE '.$param.'
				AND final!=\'F\'
			ORDER BY p.gameRef, p.startQtr ASC, p.startTime DESC, p.duration DESC';
	$penalties = $db->db_query($sql);
	while(!$penalties->eof){
		$starting_period = $penalties->field['startQtr'];
		$start = $penalties->field['startTime'];
		$ending_period = $penalties->field['endQtr'];
		$end = $penalties->field['endTime'];

		$pattern = '/([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})/';
		$match = preg_match($pattern, $start, $a);
		$penalty_start = (intval($a[2]) * 60) + intval($a[3]);
		$match = preg_match($pattern, $end, $a);
		$penalty_end = (intval($a[2]) * 60) + intval($a[3]);
		//test for a new period and set the counter with available minutes
		//12-minute regular periods
		//4-minute overtime periods
		if($starting_period != $period){
			if(substr($starting_period, 0, 1) == 'O'){
				$counter = 4 * 60;
			}else{
				$counter = 12 * 60;
			}
			$period = $starting_period;
		}
		//test the time the penalty starts against the tme on the counter
		//increment if the penalty starts at a lower time
		if($penalty_start < $counter){
				$opportunities++;
		}
		//adjust the counter to the ending time of the penalty
		$counter = $penalty_end;
		if($ending_period != $period){
			$period = $ending_period;
		}
		
		$penalties->move_next();
	}
	$r = ($opportunities < 1 ? 0 : $opportunities);
	return $r;
}

//--------------------------------------------------/
//DRAW STAT BOX
//--------------------------------------------------/
function get_stat_box($player, $goals_array, $plays_array, $saves_array){
	$playerMasterRef = $player['playerMasterRef'];
	$position = $player['position'];
	
	//get stats
	$elements = array_keys($goals_array['playerMasterRef'], $playerMasterRef);
	$games = count($elements);
	if($games > 0){
		$stats = array();
		//get data
		for($i = 0; $i < count($elements); $i++){
			$e = $elements[$i];
			$goals = (isset($goals_array['goals'][$e])? $goals_array['goals'][$e] : 0);
			$shots = (isset($plays_array['shots'][$e]) ? $plays_array['shots'][$e] : 0);
			$gb = (isset($plays_array['gb'][$e]) ? $plays_array['gb'][$e] : 0);
			$saves = (isset($saves_array['saves'][$e]) ? $saves_array['saves'][$e] : 0);
			$ga = (isset($saves_array['ga'][$e]) ? $saves_array['ga'][$e] : 0);
			
			$stats['goals'][] = $goals;
			$stats['shots'][] = $shots;
			$stats['gb'][] = $gb;
			$stats['saves'][] = $saves;
			$stats['ga'][] = $ga;
		}
		//get totals
		$tot_goals = array_sum($stats['goals']);
		$tot_shots = array_sum($stats['shots']);
		$tot_gb = array_sum($stats['gb']);
		$total_saves = array_sum($stats['saves']);
		$total_ga = array_sum($stats['ga']);
		$shot_pct = ($tot_shots > 0 ? number_format($tot_goals / $tot_shots, 3) : '0.000');
		//get mean values
		$avg_goals = number_format($tot_goals / $games, 1);
		$avg_shots = number_format($tot_shots / $games, 1);
		$avg_gb = number_format($tot_gb / $games, 1);
		$avg_saves = number_format($total_saves / $games, 1);
		$avg_ga = number_format($total_ga / $games, 1);
		
		if($games > 1){
			//get sum of the squares of the variances
			$var_goals = 0;
			$var_shots = 0;
			$var_gb = 0;
			$var_saves = 0;
			$var_ga = 0;
			for($i = 0; $i < $games; $i++){
				$var_goals += pow($stats['goals'][$i] - $avg_goals, 2);
				$var_shots += pow($stats['shots'][$i] - $avg_shots, 2);
				$var_gb += pow($stats['gb'][$i] - $avg_gb, 2);
				$var_saves += pow($stats['saves'][$i] - $avg_saves, 2);
				$var_ga += pow($stats['ga'][$i] - $avg_ga, 2);
			}
			//get standard deviation
			$std_goals = pow($var_goals / ($games - 1), 0.5);
			$std_shots = pow($var_shots / ($games - 1), 0.5);
			$std_gb = pow($var_gb / ($games - 1), 0.5);
			$std_saves = pow($var_saves / ($games - 1), 0.5);
			$std_ga = pow($var_ga / ($games - 1), 0.5);
			//get 99.7% confidence range - high
			$goal_range_high = number_format($avg_goals + ($std_goals * 3), 0);
			$shot_range_high = number_format($avg_shots + ($std_shots * 3), 0);
			$gb_range_high = number_format($avg_gb + ($std_gb * 3), 0);
			$saves_range_high = number_format($avg_saves + ($std_saves * 3), 0);
			$ga_range_high = number_format($avg_ga + ($std_ga * 3), 0);
			//get 99.7% confidence range - low
			$goal_range_low = ($avg_goals >= $std_goals * 3 ? number_format($avg_goals - ($std_goals * 3), 0) : '0');
			$shot_range_low = ($avg_shots >= $std_shots * 3 ? number_format($avg_shots - ($std_shots * 3), 0) : '0');
			$gb_range_low = ($avg_gb >= $std_gb * 3 ? number_format($avg_gb - ($std_gb * 3), 0) : '0');
			$saves_range_low = ($avg_saves >= $std_saves * 3 ? number_format($avg_saves - ($std_saves * 3), 0) : '0');
			$ga_range_low = ($avg_ga >= $std_ga * 3 ? number_format($avg_ga - ($std_ga * 3), 0) : '0');
			//get margin of error
			$goal_error = number_format(2.576 * ($std_goals / pow($games, 0.5)), 1);
			$shot_error = number_format(2.576 * ($std_shots / pow($games, 0.5)), 1);
			$gb_error = number_format(2.576 * ($std_gb / pow($games, 0.5)), 1);
			$saves_error = number_format(2.576 * ($std_saves / pow($games, 0.5)), 1);
			$ga_error = number_format(2.576 * ($std_ga / pow($games, 0.5)), 1);
		}else{
			//get 99.7% confidence range - high
			$goal_range_high = $stats['goals'][0];
			$shot_range_high = $stats['shots'][0];
			$gb_range_high = $stats['gb'][0];
			$saves_range_high = $stats['saves'][0];
			$ga_range_high = $stats['ga'][0];
			//get 99.7% confidence range - low
			$goal_range_low = 0;
			$shot_range_low = 0;
			$gb_range_low = 0;
			$saves_range_low = 0;
			$ga_range_low = 0;
			//get margin of error
			$goal_error = 0;
			$shot_error = 0;
			$gb_error = 0;
			$saves_error = 0;
			$ga_error = 0;
		}
		//draw output
		switch($position){
			case 'A':
			case 'M':
				$result = array('avg_goals' => $avg_goals,
								'goal_error' => $goal_error,
								'goal_range_low' => $goal_range_low,
								'goal_range_high' => $goal_range_high,
								'avg_shots' => $avg_shots,
								'shot_error' => $shot_error,
								'shot_range_low' => $shot_range_low,
								'shot_range_high' => $shot_range_high,
								'shot_pct' => $shot_pct,
								'games' => $games,
								'playerMasterRef' => $playerMasterRef
								);
				draw_offensive_stat_box($result);
				break;
			case 'D':
			case 'DM':
			case 'LSM':
				$result = array('avg_gb' => $avg_gb,
								'games' => $games,
								'playerMasterRef' => $playerMasterRef
								);
				draw_defensive_stat_box($result);
				break;
			case 'G':
			case 'GK':
				$result = array('avg_saves' => $avg_saves,
								'saves_error' => $saves_error,
								'avg_ga' => $avg_ga,
								'ga_error' => $ga_error,
								'games' => $games,
								'playerMasterRef' => $playerMasterRef
								);
				draw_goalie_stat_box($result);
				break;
		}
	}
}
?>