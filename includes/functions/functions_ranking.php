<?php
/***************************************************/
//RANKINGS FUNCTIONS
/***************************************************/
//--------------------------------------------------/
//GET SEASON DROP-DOWN LIST
//--------------------------------------------------/
function draw_ranking_season_select($season, $page_ref){
	global $db;
	$option_array = array();
	$sql = 'SELECT DISTINCT YEAR(date) AS year
			FROM games
			WHERE final != "T"
			ORDER BY year DESC';
	$seasons = $db->db_query($sql);
	while(!$seasons->eof){
		$year = $seasons->field['year'];
		$param = 's='.$year;
		$href = set_href($page_ref, $param);
		
		$option_array[] = array('value' => $href, 'label' => $year);
		$seasons->move_next();
	}
	$onChange = 'changeSeason(this.options[this.selectedIndex].value);';
	echo 'Season: '.draw_select_element2('season', $option_array, $season, $onChange);
}

//--------------------------------------------------/
//GET CONFERENCE SEASON DROP-DOWN LIST
//--------------------------------------------------/
function draw_conference_season_select($conference, $season, $page_ref){
	global $db;
	$option_array = array();
	$sql = 'SELECT DISTINCT YEAR(date) AS year
			FROM gamesShort
			ORDER BY year DESC';
	$seasons = $db->db_query($sql);
	while(!$seasons->eof){
		$year = $seasons->field['year'];
		$param = 's='.$year.'&c='.$conference;
		$href = set_href($page_ref, $param);
		$option_array[] = array('value' => $href,
								'label' => $year
								);
		$seasons->move_next();
	}
	$onChange = 'change_select(this.options[this.selectedIndex].value);';
	echo 'Season: '.draw_select_element2('season', $option_array, $season, $onChange);
}

/*------------------------------------------------------------
DRAW CONFERENCE DROP-DOWN
------------------------------------------------------------*/
function draw_conference_select($season, $page_ref, $selected_value = ''){
	global $db;
	$option_array = array();
	$sql = 'SELECT DISTINCT s.name AS state, s.abbrev,
				tm.conference, tm.gender
			FROM states s
			INNER JOIN teamsMaster tm
				ON s.abbrev = tm.state
			ORDER BY s.name, tm.gender, tm.conference';
	$result = $db->db_query($sql);
	while(!$result->eof){
		//get data
		$state = $result->field['state'];
		$abbrev = $result->field['abbrev'];
		$conference = $result->field['conference'];
		$gender = $result->field['gender'];
		//process data
		$gender = ucwords(strtolower(set_gender($gender)));
		$params = 's='.$season.'&c='.$conference;
		$href = set_href($page_ref, $params);
		$label = $conference;
		$group = $state.'-'.$gender.':';
		$option_array[] = array('value' => $href,
								'label' => $label,
								'group' => $group
								);
		$result->move_next();
	}
	$onChange = 'change_select(this.options[this.selectedIndex].value);';
	echo draw_select_element_group2('conference', $option_array, $selected_value, $onChange);
}

//--------------------------------------------------/
//GET CONFERENCE TEAM DROP-DOWN LIST
//--------------------------------------------------/
function draw_conference_team_select($conference, $season, $selected_value, $page_ref){
	global $db;
	$option_array = array();
	$sql = 'SELECT teamMasterRef, town
			FROM teamsMaster
			WHERE conference = "' . $conference . '"
			ORDER BY town';
	$teams = $db->db_query($sql);
	while(!$teams->eof){
		$teamMasterRef = $teams->field['teamMasterRef'];
		$town = $teams->field['town'];
		
		$params = 'c='.$conference.'&s='.$season.'&tmr='.$teamMasterRef;
		$href = set_href($page_ref, $params);
		$option_array[] = array('value' => $href,
								'label' => $town
								);
		$teams->move_next();
	}
	$onChange = 'change_select(this.options[this.selectedIndex].value);';
	echo 'Team: '.draw_select_element2('team', $option_array, $selected_value, $onChange);
}

//--------------------------------------------------/
//GET TEAM RECORD
//--------------------------------------------------/
function get_team_ranking_record($teamMasterRef, $date){
	global $db;
	$wins = 0;
	$losses = 0;
	$sql = 'SELECT
				SUM(IF(tm.teamMasterRef = gm.hTeamRef,
					IF(gm.hScore > gm.vScore, 1, 0),
					IF(gm.vScore > gm.hScore, 1, 0))) AS wins,
				SUM(IF(tm.teamMasterRef = gm.hTeamRef,
					IF(gm.hScore > gm.vScore, 0, 1),
					IF(gm.vScore > gm.hScore, 0, 1))) AS losses
			FROM gamesShort gm
			INNER JOIN teamsMaster tm
				ON tm.teamMasterRef = gm.hTeamRef OR tm.teamMasterRef = gm.vTeamRef
			WHERE tm.teamMasterRef = "' . $teamMasterRef . '"
				AND YEAR(gm.date) = YEAR("' . $date . '")
				AND gm.date < "' . $date . '"
			GROUP BY tm.teamMasterRef';
	$record = db_query($sql);
	if(isset($record->field)){
		$wins = $record->field['wins'];
		$losses = $record->field['losses'];
	}
	$r = '('.$wins.'-'.$losses.')';
	return $r;
}

//--------------------------------------------------/
//BUILD TEAM LEADERBOARD
//--------------------------------------------------/
function team_leaderboard($obj, $title, $abbrev){
?>
	<table border="0" cellspacing="0" cellpadding="0" width="335">
			<tr>
				<td width="1" class="divider4"></td>
				<td width="297" class="chartHeaderL"><?php echo $title; ?></td>
				<td width="1" class="divider"></td>
				<td width="23" class="chartHeaderC"><?php echo $abbrev; ?></td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
	for($i = 0; $i < 10; $i++){
		$statistic = '';
		$string = ($i + 1).'. ';
		$background = set_background($i);
		if(isset($obj->result['town'][$i])){
			$town			= $obj->result['town'][$i];
			$teamRef		= $obj->result['teamRef'][$i];
			$opponent		= $obj->result['opponent'][$i];
			$date			= $obj->result['date'][$i];
			$gameRef		= $obj->result['gameRef'][$i];
			$homeTeamRef	= $obj->result['usTeamRef'][$i];
			$value			= $obj->result['statistic'][$i];
			
			$param			= 'gr='.$gameRef.'&tr='.$teamRef;
			$href			= set_href(FILENAME_BOX_SCORE, $param);
			$game_date		= date('M j', strtotime($date));
			$place			= ($teamRef == $homeTeamRef ? ' vs ' : ' at ');
			if($value > 0){
				$string .= '<a href="'.$href.'">'.$town.'</a>'.$place.$opponent.' ('.$game_date.')';
				$statistic = strval($value);
			}
		}
?>
			<tr class="<?php echo $background; ?>">
				<td class="divider"></td>
				<td class="chartL4"><?php echo $string; ?></td>
				<td class="divider"></td>
				<td class="chartC4"><?php echo $statistic; ?></td>
				<td class="divider"></td>
			</tr>
<?php
	}
?>
			</table>
<?php
}

//--------------------------------------------------/
//BUILD PLAYER LEADERBOARD
//--------------------------------------------------/
function player_leaderboard($obj, $season, $title, $abbrev){
?>
			<table border="0" cellspacing="0" cellpadding="0" width="335">
			<tr>
				<td width="1" class="divider4"></td>
				<td width="277" class="chartHeaderL"><?php echo $title; ?></td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartHeaderC"><?php echo $abbrev; ?></td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
	if(isset($obj->result['reference'])){
		$row = 0;
		while(!$obj->eof){
			//get data
			$playerMasterRef	= $obj->field['reference'];
			$first_name			= $obj->field['FName'];
			$last_name			= $obj->field['LName'];
			$town				= $obj->field['town'];
			$value				= $obj->field['statistic'];
			//process data
			$player_name		= set_player_name($first_name, $last_name);
			$param				= 'pmr='.$playerMasterRef;
			$href				= set_href(FILENAME_PLAYER_SUMMARY, $param);
			$rank				= $row + 1;
			$string				= '';
			$statistic			= '';
			if($value > 0){
				$string = $rank.'. <a href="'.$href.'">'.$player_name.'</a>, '.$town;
				$statistic = strval($value);
			}
			$background = set_background($row);
?>
			<tr class="<?php echo $background; ?>">
				<td width="1" class="divider"></td>
				<td width="277" class="chartL4"><?php echo $string; ?></td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartC4"><?php echo $statistic; ?></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
			$row++;
			$obj->move_next();
		}
	}else{
		for($i = 1; $i < 6; $i++){
			$string = $i.'.';
			$statistic = '';
			$background = set_background($i - 1);
?>
			<tr class="<?php echo $background; ?>">
				<td width="1" class="divider"></td>
				<td width="277" class="chartL4"><?php echo $string; ?></td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartC4"><?php echo $statistic; ?></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
		}
	}
	$param = 's='.$season.'&st='.$abbrev;
	$href = set_href(FILENAME_PLAYER_RANKING, $param);
?>
			<tr>
				<td width="1" class="divider"></td>
				<td colspan="3" class="chartC4"><a href="<?php echo $href; ?>">Complete Rankings</a></td>
				<td width="1" class="divider"></td>
			</tr>
			</table>
<?php
}

//---------- Top five player statistics ----------//

/**
 * Returns the top five player's points in descending order
 * @param string $season
 * @return query_result
 */
function get_top_points($season){
	global $db;
	$sql = 'SELECT pm.reference, pm.FName, pm.LName, t.town,
				SUM(IF(p.teamRef = g.teamRef AND p.jerseyNo = g.scorer, 1, 0))
				+ SUM(IF(p.teamRef = g.teamRef AND p.jerseyNo = g.assist, 1, 0)) AS statistic
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			INNER JOIN goals g
				ON gm.gameRef = g.gameRef
				AND p.teamRef = g.teamRef
				AND (p.jerseyNo = g.scorer OR p.jerseyNo = g.assist)
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.playerMasterRef
			ORDER BY statistic DESC
			LIMIT 5';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top five player's goals in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_goals($season){
	global $db;
	$sql = 'SELECT pm.reference, pm.FName, pm.LName, t.town,
				SUM(IF(p.teamRef = g.teamRef AND p.jerseyNo = g.scorer, 1, 0)) AS statistic
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			INNER JOIN goals g
				ON gm.gameRef = g.gameRef
				AND p.teamRef = g.teamRef
				AND p.jerseyNo = g.scorer
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.playerMasterRef
			ORDER BY statistic DESC
			LIMIT 5';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top five player's assists in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_assists($season){
	global $db;
	$sql = 'SELECT pm.reference, pm.FName, pm.LName, t.town,
				SUM(IF(p.teamRef = g.teamRef AND p.jerseyNo = g.assist, 1, 0)) AS statistic
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			INNER JOIN goals g
				ON gm.gameRef = g.gameRef
				AND p.teamRef = g.teamRef
				AND p.jerseyNo = g.assist
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.playerMasterRef
			ORDER BY statistic DESC
			LIMIT 5';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top five player's shots in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_shots($season){
	global $db;
	$sql = 'SELECT pm.reference, pm.FName, pm.LName, t.town,
				SUM(pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT) AS statistic
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			INNER JOIN plays pl
				ON gm.gameRef = pl.gameRef
				AND p.teamRef = pl.teamRef
				AND p.jerseyNo = pl.playerRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.playerMasterRef
			ORDER BY statistic DESC
			LIMIT 5';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top five player's ground balls in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_gb($season){
	global $db;
	$sql = 'SELECT pm.reference, pm.FName, pm.LName, t.town,
				SUM(pl.gbQ1 + pl.gbQ2 + pl.gbQ3 + pl.gbQ4 + pl.gbOT) AS statistic
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			INNER JOIN plays pl
				ON gm.gameRef = pl.gameRef
				AND p.teamRef = pl.teamRef
				AND p.jerseyNo = pl.playerRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.playerMasterRef
			ORDER BY statistic DESC
			LIMIT 5';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top five player's saves in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_saves($season){
	global $db;
	$sql = 'SELECT pm.reference, pm.FName, pm.LName, t.town,
				SUM(s.savedQ1 + s.savedQ2 + s.savedQ3 + s.savedQ4 + s.savedOT) AS statistic
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			INNER JOIN saves s
				ON gm.gameRef = s.gameRef
				AND p.teamRef = s.teamRef
				AND p.jerseyNo = s.playerRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.playerMasterRef
			ORDER BY statistic DESC
			LIMIT 5';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top five player's penalties in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_penalties($season){
	global $db;
	$sql = 'SELECT pm.reference, pm.FName, pm.LName, t.town,
				SUM(IF(p.teamRef = pn.teamRef AND p.jerseyNo = pn.playerRef, 1, 0)) AS statistic
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			INNER JOIN penalties pn
				ON gm.gameRef = pn.gameRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.playerMasterRef
			ORDER BY statistic DESC
			LIMIT 5';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top five player's penalty minutes in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_minutes($season){
	global $db;
	$sql = 'SELECT pm.reference, pm.FName, pm.LName, t.town,
				SUM(pn.duration) AS statistic
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			INNER JOIN penalties pn
				ON gm.gameRef = pn.gameRef
				AND p.teamRef = pn.teamRef
				AND p.jerseyNo = pn.playerRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.playerMasterRef
			ORDER BY statistic DESC
			LIMIT 5';
	$r = $db->db_query($sql);
	return $r;
}

//---------- Player ranking statistics ----------//

/**
 * Returns player playing statistics.
 * @param string $season
 * @return query_result
 */
function get_player_playing_stats($season){
	global $db;
	$sql = 'SELECT DISTINCT p.playerMasterRef, t.town, t.teamMasterRef, t.teamRef,
				IF(p.FName != "", CONCAT(p.FName, " " , p.LName), p.LName) AS player_name,
				SUM(IF(pl.teamRef = p.teamRef AND pl.playerRef = p.jerseyNo, pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT, 0)) AS shots,
				SUM(IF(pl.teamRef = p.teamRef AND pl.playerRef = p.jerseyNo, pl.gbQ1 + pl.gbQ2 + pl.gbQ3 + pl.gbQ4 + pl.gbOT, 0)) AS gb
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			LEFT JOIN plays pl
				ON gm.gameRef = pl.gameRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.reference
			ORDER BY p.reference';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns player goal statistics.
 * @param string $season
 * @return query_result
 */
function get_player_scoring_stats($season){
	global $db;
	$sql = 'SELECT DISTINCT p.playerMasterRef,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo, 1, 0)) AS goals,
				SUM(IF(g.teamRef = p.teamRef AND g.assist = p.jerseyNo, 1, 0)) AS assists,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo, 1, 0)
					+ IF(g.teamRef = p.teamRef AND g.assist = p.jerseyNo, 1, 0)) AS points,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo AND g.assist = 0, 1, 0)) AS unassisted,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo AND goalCode = "UP", 1, 0)) AS man_up,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo AND goalCode = "DN", 1, 0)) AS man_down
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			LEFT JOIN goals g
				ON gm.gameRef = g.gameRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.reference
			ORDER BY p.reference';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns player penalty statistics.
 * @param string $season
 * @return query_result
 */
function get_player_penalty_stats($season){
	global $db;
	$sql = 'SELECT DISTINCT p.playerMasterRef,
				SUM(IF(pn.teamRef = p.teamRef AND pn.playerRef = p.jerseyNo, pn.duration, 0)) AS minutes,
				SUM(IF(pn.teamRef = p.teamRef AND pn.playerRef = p.jerseyNo, 1, 0)) AS penalties
			FROM games gm
			INNER JOIN players p
				ON (gm.themTeamRef = p.teamRef OR gm.usTeamRef = p.teamRef)
			INNER JOIN playerMaster pm
				ON p.playerMasterRef = pm.reference
			INNER JOIN teams t
				ON p.teamRef = t.teamRef
			LEFT JOIN penalties pn
				ON gm.gameRef = pn.gameRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY p.reference
			ORDER BY p.reference';
	$r = $db->db_query($sql);
	return $r;
}

//---------- Team ranking statistics ----------//

/**
 * Returns the top ten team game goals in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_team_goals($season){
	global $db;
	$sql = 'SELECT t1.town, t1.teamRef, t2.town AS opponent, gm.date, gm.gameRef,
				gm.usTeamRef, COUNT(g.scorer) AS statistic
			FROM goals g
			INNER JOIN teams t1
				ON g.teamRef = t1.teamRef
			INNER JOIN games gm
				ON g.gameRef = gm.gameRef
			INNER JOIN teams t2
				ON (gm.themTeamRef = t2.teamRef OR gm.usTeamRef = t2.teamRef)
				AND t1.teamRef != t2.teamRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY g.gameRef, g.teamRef
			ORDER BY statistic DESC';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top ten team game assists in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_team_assists($season){
	global $db;
	$sql = 'SELECT t1.town, t1.teamRef, t2.town AS opponent, gm.date, gm.gameRef,
				gm.usTeamRef, SUM(IF(g.assist != 0, 1, 0)) AS statistic
			FROM goals g
			INNER JOIN teams t1
				ON g.teamRef = t1.teamRef
			INNER JOIN games gm
				ON g.gameRef = gm.gameRef
			INNER JOIN teams t2
				ON (gm.themTeamRef = t2.teamRef OR gm.usTeamRef = t2.teamRef)
				AND t1.teamRef != t2.teamRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY g.gameRef, g.teamRef
			ORDER BY statistic DESC';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top ten team's game shots in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_team_shots($season){
	global $db;
	$sql = 'SELECT t1.town, t1.teamRef, t2.town AS opponent,
				gm.date, gm.gameRef, gm.usTeamRef,
				SUM(pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT) AS statistic
			FROM plays pl
 			INNER JOIN teams t1
 				ON pl.teamRef = t1.teamRef
 			INNER JOIN games gm
 				ON pl.gameRef = gm.gameRef
 			INNER JOIN teams t2
 				ON (gm.themTeamRef = t2.teamRef OR gm.usTeamRef = t2.teamRef)
 				AND t1.teamRef != t2.teamRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY pl.gameRef, pl.teamRef
			ORDER BY statistic DESC, gm.date DESC
			LIMIT 10';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top ten team's game saves in desending order.
 * @param string $season
 * @return query_result
 */
function get_top_team_saves($season){
	global $db;
	$sql = 'SELECT t1.town, t1.teamRef, t2.town AS opponent,
				gm.date, gm.gameRef, gm.usTeamRef,
				SUM(s.savedQ1 + s.savedQ2 + s.savedQ3 + s.savedQ4 + s.savedOT) AS statistic
 			FROM saves s
 			INNER JOIN teams t1
 				ON s.teamRef = t1.teamRef
 			INNER JOIN games gm
 				ON s.gameRef = gm.gameRef
 			INNER JOIN teams t2
 				ON (gm.themTeamRef = t2.teamRef OR gm.usTeamRef = t2.teamRef)
 				AND t1.teamRef != t2.teamRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY s.gameRef, s.teamRef
			ORDER BY statistic DESC, gm.date DESC
			LIMIT 10';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the top ten team's game ground balls in descending order.
 * @param string $season
 * @return query_result
 */
function get_top_team_gb($season){
	global $db;
	$sql = 'SELECT t1.town, t1.teamRef, t2.town AS opponent,
				gm.date, gm.gameRef, gm.usTeamRef,
				SUM(pl.gbQ1 + pl.gbQ2 + pl.gbQ3 + pl.gbQ4 + pl.gbOT) AS statistic
			FROM plays pl
 			INNER JOIN teams t1
 				ON pl.teamRef = t1.teamRef
 			INNER JOIN games gm
 				ON pl.gameRef = gm.gameRef
 			INNER JOIN teams t2
 				ON (gm.themTeamRef = t2.teamRef OR gm.usTeamRef = t2.teamRef)
 				AND t1.teamRef != t2.teamRef
			WHERE gm.season = "' . $season . '"
				AND gm.final != "F"
			GROUP BY pl.gameRef, pl.teamRef
			ORDER BY statistic DESC, gm.date DESC
			LIMIT 10';
	$r = $db->db_query($sql);
	return $r;
}
/*------------------------------------------------------------
GET CONFERENCE TEAMS
------------------------------------------------------------*/
function get_conference_teams($season, $state, $conference = ''){
	global $db;
	if($conference != ''){
		$sql = 'SELECT tm.teamMasterRef, tm.town, tm.conference, tm.league, tm.division,
					IF(t.season=\''.$season.'\', t.division, NULL) AS t_division
				FROM teamsMaster tm
				LEFT JOIN teams t
					USING(teamMasterRef)
				WHERE tm.conference=\''.$conference.'\'
				GROUP BY tm.teamMasterRef
				ORDER BY tm.town';
	}else{
		$sql = 'SELECT tm.teamMasterRef, tm.town, tm.conference, tm.league, tm.division, t.division AS t_division
				FROM teamsMaster tm
				LEFT JOIN teams t
					USING(teamMasterRef)
				INNER JOIN states s
					ON tm.state=s.abbrev
				WHERE s.abbrev=\''.$state.'\'
				ORDER BY tm.town';
	}
	$r = $db->db_query($sql);
	return $r;
}

//---------- Conference records ----------//

/**
 * Returns the conference team game data.
 * @param int $teamMasterRef
 * @param string $season
 * @return query_result
 */
function get_conference_team_games($teamMasterRef, $season){
	global $db;
	$sql = 'SELECT gm.gameRef, tm2.conference, tm2.league, tm2.division,
				t.division AS t_division,
				IF(gm.hTeamRef = tm1.teamMasterRef, gm.hScore, gm.vScore) AS us_score,
				IF(gm.hTeamRef = tm1.teamMasterRef, gm.vScore, gm.hScore) AS them_score
			FROM gamesShort gm
			INNER JOIN teamsMaster tm1
				ON (gm.hTeamRef = tm1.teamMasterRef OR gm.vTeamRef = tm1.teamMasterRef)
			INNER JOIN teamsMaster tm2
				ON (gm.hTeamRef = tm2.teamMasterRef OR gm.vTeamRef = tm2.teamMasterRef)
				AND tm1.teamMasterRef != tm2.teamMasterRef
			LEFT JOIN teams t
				ON tm2.teamMasterRef = t.teamMasterRef
			WHERE tm1.teamMasterRef = "' . $teamMasterRef . '"
				AND YEAR(gm.date) = "' . $season . '"
			GROUP BY gm.gameRef';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the conference team game log
 * @param int $teamMasterRef
 * @param string $season
 * @return query_result
 */
function get_conference_team_log($teamMasterRef, $season){
	global $db;
	$sql = 'SELECT gm.date,
				IF(tm1.teamMasterRef=gm.vTeamRef, "at ", "") AS versus,
				tm2.teamMasterRef AS them_tmr, tm2.town AS opponent,
				tm2.conference AS them_conference, tm2.league AS them_league,
				tm2.division AS them_division, t.division AS them_dt,
				IF(tm1.teamMasterRef = gm.hTeamRef, hScore, vScore) AS us_score,
				IF(tm1.teamMasterRef = gm.hTeamRef, vScore, hScore) AS them_score
			FROM gamesShort gm
			INNER JOIN teamsMaster tm1
				ON gm.hTeamRef = tm1.teamMasterRef OR gm.vTeamRef = tm1.teamMasterRef
			LEFT JOIN teamsMaster tm2
				ON (gm.hTeamRef = tm2.teamMasterRef OR gm.vTeamRef = tm2.teamMasterRef)
				AND tm2.teamMasterRef != tm1.teamMasterRef
			LEFT JOIN teams t
				ON t.teamMasterRef = tm2.teamMasterRef
			WHERE tm1.teamMasterRef = "' . $teamMasterRef . '"
				AND YEAR(gm.date) = "' . $season . '"
			GROUP BY gm.gameRef
			ORDER BY gm.date';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns team data
 * @param int $teamMasterRef
 * @param string $season
 * @return query_result
 */
function get_conference_team_data($teamMasterRef, $season){
	global $db;
	$sql = 'SELECT tm.town, IF(tm.teamName != "", CONCAT_WS(" ", tm.town, tm.teamName), tm.town) AS team_name, tm.conference, tm.league, tm.division,
				s.name AS state, t.division AS t_division,
				SUM(IF(tm.teamMasterRef = gm.hTeamRef,
					IF(gm.hScore > gm.vScore, 1, 0),
					IF(gm.vScore>gm.hScore, 1, 0))) AS wins,
				SUM(IF(tm.teamMasterRef = gm.hTeamRef,
					IF(gm.hScore >= gm.vScore, 0, 1),
					IF(gm.vScore>=gm.hScore, 0, 1))) AS losses
			FROM gamesShort gm
			INNER JOIN teamsMaster tm
				ON tm.teamMasterRef = gm.hTeamRef OR tm.teamMasterRef = gm.vTeamRef
			LEFT JOIN teams t
				ON t.teamMasterRef = tm.teamMasterRef AND t.season = YEAR(gm.date)
			INNER JOIN states s
				ON tm.state = s.abbrev
			WHERE tm.teamMasterRef = "' . $teamMasterRef . '"
				AND YEAR(gm.date) = "' . $season . '"
			GROUP BY tm.teamMasterRef';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the team record
 * @param int $teamMasterRef
 * @param string $date
 * @return string
 */
function get_team_conference_record($teamMasterRef, $date){
	global $db;
	$wins = 0;
	$losses = 0;
	$sql = 'SELECT
				SUM(IF(tm.teamMasterRef = gm.hTeamRef,
					IF(gm.hScore > gm.vScore, 1, 0),
					IF(gm.vScore > gm.hScore, 1, 0))) AS wins,
				SUM(IF(tm.teamMasterRef = gm.hTeamRef,
					IF(gm.hScore >= gm.vScore, 0, 1),
					IF(gm.vScore >= gm.hScore, 0, 1))) AS losses
			FROM gamesShort gm
			INNER JOIN teamsMaster tm
				ON tm.teamMasterRef = gm.hTeamRef OR tm.teamMasterRef = gm.vTeamRef
			WHERE tm.teamMasterRef = "' . $teamMasterRef . '"
				AND YEAR(gm.date) = YEAR("' . $date . '")
				AND gm.date < "'.$date.'"
			GROUP BY tm.teamMasterRef';
	$result = $db->db_query($sql);
	if(count($result->result['wins']) > 0){
		$wins = $result->field['wins'];
		$losses = $result->field['losses'];
	}
	$r = '('.$wins.'-'.$losses.')';
	return($r);
}
?>