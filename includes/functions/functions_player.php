<?php
/***************************************************/
//PLAYER FUNCTIONS
/***************************************************/

/**
 * Returns the page headline for the specified player.
 * @param int $playerMasterRef
 * @return query_result
 */
function get_player_headline($playerMasterRef){
	global $db;
	$sql = 'SELECT t.town, t.name, t.teamRef, t.teamMasterRef, t.season, p.reference, p.jerseyNo, p.position, pm.FName, pm.LName, pm.birthdate, pm.height, pm.weight, pm.class, pm.photo, pm.collegeName, pm.collegeLink
			FROM teams t
			INNER JOIN players p
				USING(teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			WHERE pm.reference = "'.$playerMasterRef.'"
			ORDER BY t.season DESC';
	$r = $db->db_query($sql);
	return($r);
}

/**
 * Returns the specified player's personal information.
 * @param int $playerMasterRef
 * @param string $param
 * @return query_result
 */
function get_player_personal_info($playerMasterRef, $param = ''){
	global $db;
	$sql = 'SELECT IF(pm.FName != "", CONCAT_WS(" ", pm.FName, pm.LName),
				pm.LName) AS player_name, pm.birthdate, pm.class, pm.height,
				pm.weight, pm.dominantHand, pm.street1, pm.street2, pm.city,
				pm.state, pm.zip, pm.homePhone, pm.email, pm.parentName,
				pm.parentEmail, pm.parentRelease, pm.releaseDate, pm.school,
				pm.counselor, pm.counselorPhone, pm.photo, pm.collegeName,
				pm.collegeLink, p.jerseyNo, p.position, p.reference AS playerRef
			FROM playerMaster pm
			INNER JOIN players p
				ON p.playerMasterRef = pm.reference
			WHERE pm.reference = ' . $playerMasterRef . $param;
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns a select element containing options to all players on the team
 * representing the specified player.
 * @param int $teamRef
 * @param int $playerMasterRef
 * @param int $page_ref
 */
function draw_player_select($teamRef, $playerMasterRef, $page_ref){
	global $db;
	$option_array = array();
	$season = '';
	$sql = 'SELECT IF(pm.FName != "", CONCAT_WS(" ", pm.FName, pm.LName),
				pm.LName) AS player_name, pm.reference, p.jerseyNo, t.season
			FROM playerMaster pm
			INNER JOIN players p
				ON pm.reference = p.playerMasterRef
			INNER JOIN teams t
				USING(teamRef)
			WHERE t.teamRef = "' . $teamRef . '"
			ORDER BY p.jerseyNo';
	$players = $db->db_query($sql);
	while(!$players->eof){
		//get player data
		$pmr = $players->field['reference'];
		$jerseyNo = $players->field['jerseyNo'];
		$player_name = $players->field['player_name'];
		$season = $players->field['season'];
		
		//process data
		$params = 'pmr=' . $pmr . '&s=' . $season;
		$href = set_href($page_ref, $params);
		
		//set option
		$option_array[] = array(
			'value' => $href,
			'label' => $jerseyNo . ' ' . $player_name
		);
		
		//increment
		$players->move_next();
	}
	$params = 'pmr=' . $playerMasterRef . '&s=' . $season;
	$selected_value = set_href($page_ref, $params);
	$onChange = 'changePlayer(this.options[this.selectedIndex].value);';
	echo 'Player: '.draw_select_element('player', $option_array, $selected_value, $onChange);
}

/**
 * Returns a select element with options representing the specified player's
 * active seasons.
 * @param array $label_array
 * @param int $playerMasterRef
 * @param int $selected_value
 * @param int $page_ref
 */
function draw_player_season_select($label_array, $playerMasterRef, $selected_value, $page_ref){
	$option_array = array();
	reset($label_array);
	while(current($label_array)){
		$season = current($label_array);
		$param = 'pmr='.$playerMasterRef.'&s='.$season;
		$href = set_href($page_ref, $param);
		
		$option_array[] = array(
			'value' => $href,
			'label' => $season
		);
		next($label_array);
	}
	$onChange = 'changeSeason(this.options[this.selectedIndex].value);';
	echo ' | Season: '.draw_select_element2('player_season', $option_array, $selected_value, $onChange);
}


/**
 * Returns a select element with options representing available positions.
 * @param string $name
 * @param string $selected_value
 */
function draw_position_select($name, $selected_value){
	$option_array = array();
	for($i = 0; $i < 7; $i++){
		switch($i){
			case 0:
				$value = '';
				$label = '';
				break;
			case 1:
				$value = 'A';
				$label = 'Attack';
				break;
			case 2:
				$value = 'M';
				$label = 'Midfield';
				break;
			case 3:
				$value = 'DM';
				$label = 'Defensive Midfield';
				break;
			case 4:
				$value = 'LSM';
				$label = 'Long-stick Midfield';
				break;
			case 5:
				$value = 'D';
				$label = 'Defense';
				break;
			case 6:
				$value = 'GK';
				$label = 'Goalkeeper';
				break;
		}
		$option_array[] = array(
			'value' => $value,
			'label' => $label
		);
	}
	echo draw_select_element($name, $option_array, $selected_value);
}

/**
 * Returns a select element with available team depth options.
 * @param string $name
 * @param int $selected_value
 */
function draw_depth_select($name, $selected_value){
	$option_array = array();
	for($i = 0; $i < 5; $i++){
		switch($i){
			case 0:
				$value = 0;
				$label = '';
				break;
			case 1:
				$value = 1;
				$label = 'Starter';
				break;
			case 2:
				$value = 2;
				$label = '2';
				break;
			case 3:
				$value = 3;
				$label = '3';
				break;
			case 4:
				$value = 4;
				$label = '4';
				break;
		}
		$option_array[] = array(
			'value' => $value,
			'label' => $label
		);
	}
	echo draw_select_element($name, $option_array, $selected_value);
}


/**
 * Returns a select element with available dominant hand options.
 * @param string $name
 * @param string $selected_value
 */
function draw_hand_select($name, $selected_value){
	$option_array = array();
	for($i = 0; $i < 4; $i++){
		switch($i){
			case 0:
				$value = '';
				$label = '';
				break;
			case 1:
				$value = 'R';
				$label = 'Right handed';
				break;
			case 2:
				$value = 'L';
				$label = 'Left handed';
				break;
			case 3:
				$value = 'A';
				$label = 'Ambidextrous';
				break;
		}
		$option_array[] = array(
			'value' => $value,
			'label' => $label
		);
	}
	echo draw_select_element($name, $option_array, $selected_value);
}

/**
 * Returns the text value of the specified dominant hand.
 * @param string $hand
 * @return string
 */
function set_dominant_hand($hand){
	$r = '';
	switch($hand){
		case 'R':
			$r = 'Right';
			break;
		case 'L':
			$r = 'Left';
			break;
		case 'A':
			$r = 'Ambi';
			break;
		default:
			$r = 'n/a';
	}
	return $r;
}

/**
 * Returns the text value of the specified position.
 * @param string $position
 * @return string
 */
function get_position($position){
	$r = '';
	switch($position){
		case 'G':
		case 'GK':
			$r = 'Goalkeeper';
			break;
		case 'D':
			$r = 'Defense';
			break;
		case 'DM':
			$r = 'Defensive Midfield';
			break;
		case 'LSM':
			$r = 'Long-Stick Midfield';
			break;
		case 'A':
			$r = 'Attack';
			break;
		default:
			$r = 'Midfield';
	}
	return $r;
}

//---------- Career Statistics ----------//

/**
 * Returns the specified player's career shot and ground ball statistics by season.
 * @param int $playerMasterRef
 * @return query_result
 */
function get_career_playing_stats($playerMasterRef){
	global $db;
	$sql = 'SELECT t.season,
				COUNT(pl.played) AS played,
				SUM(IF(started = "T", 1, 0)) AS started,
				SUM(pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT) AS shots,
				SUM(pl.gbQ1 + pl.gbQ2 + pl.gbQ3 + pl.gbQ4 + pl.gbOT) AS gb
			FROM teams t
			LEFT JOIN games gm
				ON (t.teamRef = gm.usTeamRef OR t.teamRef = gm.themTeamRef)
			INNER JOIN plays pl
				ON gm.gameRef = pl.gameRef AND t.teamRef = pl.teamRef
			INNER JOIN players p
				ON pl.teamRef = p.teamRef AND pl.playerRef = p.jerseyNo
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			WHERE pm.reference = "' . $playerMasterRef . '"
				AND gm.final != "F"
			GROUP BY t.season
			ORDER BY t.season';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the specified player's career goal and assist statistics by season.
 * @param int $playerMasterRef
 * @return query_result
 */
function get_career_goal_stats($playerMasterRef){
	global $db;
	$sql = 'SELECT t.season,
				SUM(IF(g.scorer = p.jerseyNo, 1, 0)) AS goals,
				SUM(IF(g.assist = p.jerseyNo, 1, 0)) AS assists,
				SUM(IF(g.scorer = p.jerseyNo AND g.assist = 0, 1, 0)) AS unassisted,
				SUM(IF(g.scorer = p.jerseyNo AND g.goalCode = "UP", 1, 0)) AS man_up,
				SUM(IF(g.scorer = p.jerseyNo AND g.goalCode = "DN", 1, 0)) AS man_down
			FROM teams t
			LEFT JOIN games gm
				ON (t.teamRef = gm.usTeamRef OR t.teamRef = gm.themTeamRef)
			INNER JOIN goals g
				ON gm.gameRef = g.gameRef AND t.teamRef = g.teamRef
			INNER JOIN players p
				ON g.teamRef = p.teamRef
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			WHERE pm.reference = "' . $playerMasterRef . '"
				AND gm.final != "F"
			GROUP BY t.season
			ORDER BY t.season';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the specified player's career penalty statistics by season.
 * @param int $playerMasterRef
 * @return query_result
 */
function get_career_penalty_stats($playerMasterRef){
	global $db;
	$sql = 'SELECT t.season,
				SUM(pn.duration) AS minutes,
				COUNT(pn.duration) AS penalties
			FROM teams t
			LEFT JOIN games gm
				ON (t.teamRef = gm.usTeamRef OR t.teamRef = gm.themTeamRef)
			INNER JOIN penalties pn
				ON gm.gameRef = pn.gameRef AND t.teamRef = pn.teamRef
			INNER JOIN players p
				ON pn.teamRef = p.teamRef AND pn.playerRef = p.jerseyNo
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			WHERE pm.reference = "' . $playerMasterRef . '"
				AND gm.final != "F"
			GROUP BY t.season
			ORDER BY t.season';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the specified player's career faceoff statistics by season.
 * @param int $playerMasterRef
 * @return query_result
 */
function get_career_faceoff_stats($playerMasterRef){
	global $db;
	$sql = 'SELECT t.season,
				SUM(f.wonQ1 + f.wonQ2 + f.wonQ3 + f.wonQ4 + f.wonOT) AS won,
				SUM(f.lostQ1 + f.lostQ2 + f.lostQ3 + f.lostQ4 + f.lostOT) AS lost
			FROM teams t
			LEFT JOIN games gm
				ON (t.teamRef = gm.usTeamRef OR t.teamRef = gm.themTeamRef)
			INNER JOIN faceoffs f
				ON gm.gameRef = f.gameRef AND t.teamRef = f.teamRef
			INNER JOIN players p
				ON f.teamRef = p.teamRef AND f.playerRef = p.jerseyNo
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			WHERE pm.reference = "' . $playerMasterRef . '"
				AND gm.final != "F"
			GROUP BY t.season
			ORDER BY t.season';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the specified player's career goalie statistics by season.
 * @param int $playerMasterRef
 * @return query_result
 */
function get_career_goalie_stats($playerMasterRef){
	global $db;
	$sql = 'SELECT t.season,
				SUM(s.savedQ1 + s.savedQ2 + s.savedQ3 + s.savedQ4 + s.savedOT) AS saved,
				SUM(s.allowedQ1 + s.allowedQ2 + s.allowedQ3 + s.allowedQ4 + s.allowedOT) AS allowed
			FROM teams t
			LEFT JOIN games gm
				ON (t.teamRef = gm.usTeamRef OR t.teamRef = gm.themTeamRef)
			INNER JOIN saves s
				ON gm.gameRef = s.gameRef AND t.teamRef = s.teamRef
			INNER JOIN players p
				ON s.teamRef = p.teamRef AND s.playerRef = p.jerseyNo
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			WHERE pm.reference = "' . $playerMasterRef . '"
				AND gm.final != "F"
			GROUP BY t.season
			ORDER BY t.season';
	$r = $db->db_query($sql);
	return $r;
}

//---------- Game Log Statistics ----------//

/**
 * Returns the specified player's current year playing statistics by game.
 * @param int $playerRef
 * @return query_result
 */
function get_gamelog_plays($playerRef){
	global $db;
	$sql = 'SELECT gm.gameRef, gm.date, gm.startTime, gm.final, gm.seasonType,
				IF(f.town = t.town, "at ", "") AS place,
				t.town AS opponent,
				pl.played, pl.started,
				SUM(pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT) AS shots,
				SUM(pl.gbQ1 + pl.gbQ2 + pl.gbQ3 + pl.gbQ4 + pl.gbOT) AS gb
			FROM players p
			INNER JOIN games gm
				ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
			LEFT JOIN plays pl
				ON gm.gameRef = pl.gameRef
				AND p.teamRef = pl.teamRef
				AND p.jerseyNo = pl.playerRef
			LEFT JOIN sites f
				ON gm.fieldRef = f.fieldRef
			LEFT JOIN teams t
				ON (gm.themTeamRef = t.teamRef OR gm.usTeamRef = t.teamRef)
				AND t.teamRef != p.teamRef
			WHERE p.reference = "' . $playerRef . '"
			GROUP BY gm.gameRef
			ORDER BY gm.date';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the specified player's current year goal statistics by game.
 * @param int $playerRef
 * @return query_result
 */
function get_gamelog_goals($playerRef){
	global $db;
	$sql = 'SELECT gm.date,
				SUM(IF(g.teamRef = p.teamRef, 1, 0)) AS goals_us,
				SUM(IF(g.teamRef != p.teamRef, 1, 0)) AS goals_them,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo, 1, 0)) AS goals,
				SUM(IF(g.teamRef = p.teamRef AND g.assist = p.jerseyNo, 1, 0)) AS assists,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo AND g.assist < 1, 1, 0)) AS unassisted,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo AND g.goalCode = "UP", 1, 0)) AS man_up,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo AND g.goalCode = "DN", 1, 0)) AS man_down
			FROM players p
			INNER JOIN games gm
				ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
			LEFT JOIN goals g
				ON gm.gameRef = g.gameRef
			WHERE p.reference = "' . $playerRef . '"
			GROUP BY gm.gameRef
			ORDER BY gm.date';
	$r = $db->db_query($sql);
	return $r;
}


/**
 * Returns the specified player's current year penalty statistics by game.
 * @param int $playerRef
 * @return query_result
 */
function get_gamelog_penalties($playerRef){
	global $db;
	$sql = 'SELECT gm.date,
				SUM(pn.duration) AS minutes,
				COUNT(pn.duration) AS penalties
			FROM players p
			INNER JOIN games gm
				ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
			LEFT JOIN penalties pn
				ON gm.gameRef = pn.gameRef
				AND p.teamRef = pn.teamRef
				AND p.jerseyNo = pn.playerRef
			WHERE p.reference = "' . $playerRef . '"
			GROUP BY gm.gameRef
			ORDER BY gm.date';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the specified player's current year faceoff statistics by game.
 * @param int $playerRef
 * @return query_result
 */
function get_gamelog_faceoffs($playerRef){
	global $db;
	$sql = 'SELECT gm.date,
				SUM(fo.wonQ1 + fo.wonQ2 + fo.wonQ3 + fo.wonQ4 + fo.wonOT) AS won,
				SUM(fo.lostQ1 + fo.lostQ2 + fo.lostQ3 + fo.lostQ4 + fo.lostOT) AS lost
			FROM players p
			INNER JOIN games gm
				ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
			LEFT JOIN faceoffs fo
				ON gm.gameRef = fo.gameRef
				AND p.teamRef = fo.teamRef
				AND p.jerseyNo = fo.playerRef
			WHERE p.reference = "' . $playerRef . '"
			GROUP BY gm.gameRef
			ORDER BY gm.date';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the specified player's current year goalie statistics by game.
 * @param int $playerRef
 * @return query_result
 */
function get_gamelog_saves($playerRef){
	global $db;
	$sql = 'SELECT gm.date,
				SUM(s.savedQ1 + s.savedQ2 + s.savedQ3 + s.savedQ4 + s.savedOT) AS saved,
				SUM(s.allowedQ1 + s.allowedQ2 + s.allowedQ3 + s.allowedQ4 + s.allowedOT) AS allowed
			FROM players p
			INNER JOIN games gm
				ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
			LEFT JOIN saves s
				ON gm.gameRef = s.gameRef
				AND p.teamRef = s.teamRef
				AND p.jerseyNo = s.playerRef
			WHERE p.reference = "' . $playerRef . '"
			GROUP BY gm.gameRef
			ORDER BY gm.date';
	$r = $db->db_query($sql);
	return $r;
}

//---------- Split Statistics ----------//

/**
 * Returns the specified player's split playing statistics.
 * @param int $playerRef
 * @param string $select_param
 * @param string $group_param
 * @param string $sort_param
 * @return query_result
 */
function get_split_play_stats($playerRef, $select_param, $group_param, $sort_param){
	global $db;
	$sql = 'SELECT
				SUM(IF(pl.played = "T", 1, 0)) AS played,
				SUM(IF(pl.started = "T", 1, 0)) AS started,
				SUM(pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT) AS shots,
				SUM(pl.gbQ1 + pl.gbQ2 + pl.gbQ3 + pl.gbQ4 + pl.gbOT) AS gb' . $select_param . '
			FROM players p
			INNER JOIN games gm
				ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
			INNER JOIN teams t
				ON (gm.themTeamRef = t.teamRef OR gm.usTeamRef = t.teamRef)
				AND p.teamRef != t.teamRef
			INNER JOIN sites f
				ON gm.fieldRef = f.fieldRef
			LEFT JOIN plays pl
				ON gm.gameRef = pl.gameRef
				AND p.teamRef = pl.teamRef
				AND p.jerseyNo = pl.playerRef
			WHERE p.reference = "' . $playerRef . '"
				AND gm.final != "F"
			GROUP BY ' . $group_param . '
			ORDER BY ' . $sort_param;
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Return the specified player's split goal statistics.
 * @param int $playerRef
 * @param string $select_param
 * @param string $group_param
 * @param string $sort_param
 * @return query_result
 */
function get_split_goal_stats($playerRef, $select_param, $group_param, $sort_param){
	global $db;
	$sql = 'SELECT
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo, 1, 0)) AS goals,
				SUM(IF(g.teamRef = p.teamRef AND g.assist = p.jerseyNo, 1, 0)) AS assists,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo AND g.assist < 1, 1, 0)) AS unassisted,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo AND g.goalCode = "UP", 1, 0)) AS man_up,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo AND g.goalCode = "DN", 1, 0)) AS man_down' . $select_param . '
			FROM players p
			INNER JOIN games gm
				ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
			INNER JOIN teams t
				ON (gm.themTeamRef = t.teamRef OR gm.usTeamRef = t.teamRef)
				AND p.teamRef != t.teamRef
			INNER JOIN sites f
				ON gm.fieldRef = f.fieldRef
			LEFT JOIN goals g
				ON gm.gameRef = g.gameRef
				AND p.teamRef = g.teamRef
				AND (p.jerseyNo = g.scorer OR p.jerseyNo = g.assist)
			WHERE p.reference = "' . $playerRef . '"
				AND gm.final != "F"
			GROUP BY ' . $group_param . '
			ORDER BY ' . $sort_param;
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the specified player's split penalty statistics.
 * @param int $playerRef
 * @param string $select_param
 * @param string $group_param
 * @param string $sort_param
 * @return query_result
 */
function get_split_penalty_stats($playerRef, $select_param, $group_param, $sort_param){
	global $db;
	$sql = 'SELECT
				SUM(IF(pn.teamRef = p.teamRef AND pn.playerRef = p.jerseyNo, pn.duration, 0)) AS minutes,
				SUM(IF(pn.teamRef = p.teamRef AND pn.playerRef = p.jerseyNo, 1, 0)) AS penalties'.$select_param.'
			FROM players p
			INNER JOIN games gm
				ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
			INNER JOIN teams t
				ON (gm.themTeamRef = t.teamRef OR gm.usTeamRef = t.teamRef)
				AND p.teamRef != t.teamRef
			INNER JOIN sites f
				ON gm.fieldRef = f.fieldRef
			LEFT JOIN penalties pn
				ON gm.gameRef = pn.gameRef
				AND p.teamRef = pn.teamRef
				AND p.jerseyNo = pn.playerRef
			WHERE p.reference = "' . $playerRef . '"
				AND gm.final != "F"
			GROUP BY ' . $group_param . '
			ORDER BY ' . $sort_param;
	$r = $db->db_query($sql);
	return $r;
}
?>