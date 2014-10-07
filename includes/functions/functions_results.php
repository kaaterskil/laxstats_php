<?php
/**
 * Returns an html select element with seasons
 * @param string $selected_value
 * @param int $page_ref
 */
function draw_results_season_select($selected_value, $page_ref){
	global $db;
	$option_array = array();
	$current_month = date('n');
	$sql = 'SELECT DISTINCT YEAR(date) AS season
			FROM games
			ORDER BY season DESC';
	$seasons = $db->db_query($sql);
	while(!$seasons->eof){
		$season = $seasons->field['season'];
		
		$param = 's='.$season.'&m='.$current_month;
		$href = set_href($page_ref, $param);
		$option_array[] = array('value' => $href, 'label' => $season);
		
		$seasons->move_next();
	}
	$onChange = 'changeYear(this.options[this.selectedIndex].value);';
	echo 'Season: ' . draw_select_element2('season', $option_array, $selected_value, $onChange);
}

/**
 * Returns an html string of months with games
 * @param string $season
 * @param string $selected_month
 * @param int $page_ref
 * @return string
 */
function set_months($season, $selected_month, $page_ref){
	global $db;
	$r = '';
	$sql = 'SELECT DISTINCT MONTH(date) AS month
			FROM games
			WHERE YEAR(date) = "' . $season . '"
			ORDER BY month';
	$months = $db->db_query($sql);
	while(!$months->eof){
		$mr = $months->field['month'];
		$month = get_month_name($mr);
		if($mr == $selected_month){
			$r .= $month.' | ';
		} else {
			$param = 's='.$season.'&m='.$mr;
			$href = set_href($page_ref, $param);
			$r .= '<a href="' . $href . '">' . $month . '</a> | ';
		}
		$months->move_next();
	}
	if(count($months->result['month']) > 0){
		$length = strlen($r) - 3;
		$r = substr($r, 0, $length);
	}
	return $r;
}

/**
 * Returns the month name for the specified month
 * @param int $month
 * @return string
 */
function get_month_name($month){
	$months = ["", "January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December"];
	return $months[intval($month)];
}

/**
 * Returns the team record for the specified team and date
 * @param int $teamRef
 * @param string $date
 * @return string
 */
function get_team_record_results($teamRef, $date){
	global $db;
	$wins = 0;
	$losses = 0;
	$sql = 'SELECT gm.date,
				SUM(IF(g.teamRef = t.teamRef, 1, 0)) AS us,
				SUM(IF(g.teamRef != t.teamRef, 1, 0)) AS them
			FROM goals g
			INNER JOIN games gm
				USING(gameRef)
			INNER JOIN teams t
				ON gm.usTeamRef = t.teamRef OR gm.themTeamRef = t.teamRef
			WHERE t.teamRef = "' . $teamRef . '"
				AND gm.date < "' . $date . '"
				AND gm.final != "F"
			GROUP BY gm.gameRef';
	$record = $db->db_query($sql);
	while(!$record->eof){
		$us = $record->field['us'];
		$them = $record->field['them'];
		if($us > $them){
			$wins++;
		} else {
			$losses++;
		}
		$record->move_next();
	}
	$r = ' (' . $wins . '-' . $losses . ')';
	return $r;
}

/**
 * Returns scoreboard gamea data for the specified time period
 * @param string $season
 * @param string $month
 * @return query_result
 */
function get_scoreboard_games($season, $month){
	global $db;
	$sql = 'SELECT gm.gameRef, gm.date, gm.fieldRef, gm.seasonType,
				CONCAT(f.town, " ", f.name) AS field,
				IF(t2.town = f.town, t2.town, t1.town) AS home_team,
				IF(t2.town = f.town, UPPER(t2.shortName), UPPER(t1.shortName)) AS home_abbrev,
				IF(t2.town = f.town, t2.teamRef, t1.teamRef) AS home_tr,
				IF(t2.town = f.town, t2.teamMasterRef, t1.teamMasterRef) AS home_tmr,
				IF(t2.town = f.town, t1.town, t2.town) AS visitor_team,
				IF(t2.town = f.town, UPPER(t1.shortName), UPPER(t2.shortName)) AS visitor_abbrev,
				IF(t2.town = f.town, t1.teamRef, t2.teamRef) AS visitor_tr,
				IF(t2.town = f.town, t1.teamMasterRef, t2.teamMasterRef) AS visitor_tmr,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t2.teamRef, 1, 0)),
					SUM(IF(g.teamRef = t1.teamRef, 1, 0))) AS home_score,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 1, 1, 0)),
					SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 1, 1, 0))) AS home_goalsQ1,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 2, 1, 0)),
					SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 2, 1, 0))) AS home_goalsQ2,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 3, 1, 0)),
					SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 3, 1, 0))) AS home_goalsQ3,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 4, 1, 0)),
					SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 4, 1, 0))) AS home_goalsQ4,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t2.teamRef AND g.quarter LIKE "O%", 1, 0)),
					SUM(IF(g.teamRef = t1.teamRef AND g.quarter LIKE "O%", 1, 0))) AS home_goalsOT,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t1.teamRef, 1, 0)),
					SUM(IF(g.teamRef = t2.teamRef, 1, 0))) AS visitor_score,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 1, 1, 0)),
					SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 1, 1, 0))) AS visitor_goalsQ1,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 2, 1, 0)),
					SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 2, 1, 0))) AS visitor_goalsQ2,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 3, 1, 0)),
					SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 3, 1, 0))) AS visitor_goalsQ3,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 4, 1, 0)),
					SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 4, 1, 0))) AS visitor_goalsQ4,
				IF(t2.town = f.town,
					SUM(IF(g.teamRef = t1.teamRef AND g.quarter LIKE "O%", 1, 0)),
					SUM(IF(g.teamRef = t2.teamRef AND g.quarter LIKE "O%", 1, 0))) AS visitor_goalsOT
			FROM games gm
			INNER JOIN sites f
				ON gm.fieldRef = f.fieldRef
			INNER JOIN goals g
				ON gm.gameRef = g.gameRef
			INNER JOIN teams t1
				ON gm.usTeamRef = t1.teamRef
			INNER JOIN teams t2
				ON gm.themTeamRef = t2.teamRef
			WHERE YEAR(gm.date) = "' . $season . '"
				AND MONTH(gm.date) = "' . $month . '"
				AND gm.final!= \'F\'
			GROUP BY gm.gameRef
			ORDER BY gm.date DESC, gm.startTime, gm.gameRef';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns scoreboard shot data for the specified time period
 * @param string $season
 * @param string $month
 * @return query_result
 */
function get_scoreboard_shots($season, $month){
	global $db;
	$sql = 'SELECT gm.gameRef,
				IF(t2.town = f.town,
					SUM(IF(pl.teamRef = t2.teamRef, pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT, 0)),
					SUM(IF(pl.teamRef = t1.teamRef, pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT, 0))) AS home_shots,
				IF(t2.town = f.town,
					SUM(IF(pl.teamRef = t1.teamRef, pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT, 0)),
					SUM(IF(pl.teamRef = t2.teamRef, pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT, 0))) AS visitor_shots
			FROM games gm
			INNER JOIN sites f
				ON gm.fieldRef = f.fieldRef
			INNER JOIN plays pl
				ON gm.gameRef = pl.gameRef
			INNER JOIN teams t1
				ON gm.usTeamRef = t1.teamRef
			INNER JOIN teams t2
				ON gm.themTeamRef = t2.teamRef
			WHERE YEAR(gm.date) = "' . $season . '"
				AND MONTH(gm.date) = "' . $month . '"
				AND gm.final!= "F"
			GROUP BY gm.gameRef
			ORDER BY gm.date DESC, gm.startTime, gm.gameRef';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns scoreboard goal keeper data for the specified time period
 * @param string $season
 * @param string $month
 * @return query_result
 */
function get_scoreboard_goalkeepers($season, $month){
	global $db;
	$sql = 'SELECT gm.gameRef, pm.reference, p.teamRef,
				IF(pm.FName != "",
					CONCAT(SUBSTRING(pm.FName, 1, 1), ". ", pm.LName),
					pm.LName) AS name
			FROM playerMaster pm
			INNER JOIN players p
				ON pm.reference = p.playerMasterRef
			RIGHT JOIN plays pl
				ON p.teamRef = pl.teamRef
				AND p.jerseyNo = pl.playerRef
			INNER JOIN games gm
				USING(gameRef)
			WHERE YEAR(gm.date) = "' . $season . '"
				AND MONTH(gm.date) = "' . $month . '"
				AND gm.final != "F"
				AND p.position LIKE "G%"
				AND pl.started = "T"
			ORDER BY gm.date DESC, gm.gameRef';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns player data for the scoreboard
 * @param string $season
 * @param string $month
 * @return query_result
 */
function get_scoreboard_players($season, $month){
	global $db;
	$sql = 'SELECT gm.gameRef, pm.reference, p.teamRef,
				IF(pm.FName != "",
					CONCAT(SUBSTRING(pm.FName, 1, 1), ". ", pm.LName),
					pm.LName) AS name,
				SUM(IF(g.teamRef = p.teamRef AND g.scorer = p.jerseyNo, 1, 0)) AS goals,
				SUM(IF(g.teamRef = p.teamRef AND g.assist = p.jerseyNo, 1, 0)) AS assists
			FROM playerMaster pm
			INNER JOIN players p
				ON pm.reference = p.playerMasterRef
			INNER JOIN goals g
				ON p.teamRef = g.teamRef
				AND (p.jerseyNo = g.scorer OR p.jerseyNo = g.assist)
			INNER JOIN games gm
				USING(gameRef)
			WHERE YEAR(gm.date) = "' . $season . '"
				AND MONTH(gm.date) = "' . $month . '"
				AND gm.final != "F"
			GROUP BY pm.reference, gm.date
			ORDER BY gm.date DESC, gm.gameRef, p.teamRef';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the schedule for the specified time period
 * @param string $start_month
 * @param string $end_month
 * @return query_result
 */
function get_schedule($start_month, $end_month){
	global $db;
	$sql = 'SELECT DISTINCT gm.gameRef, gm.date, gm.startTime,
				TIME_TO_SEC(gm.startTime) AS time_as_seconds,
				gm.fieldRef, gm.final, gm.created, gm.modified,
				f.town AS site, CONCAT(f.town, " ", f.name) AS field,
				IF(t2.town = f.town, "at", "vs") AS versus,
				IF(t2.town = f.town, t2.town, t1.town) AS home_team,
				IF(t2.town = f.town, t2.teamRef, t1.teamRef) AS home_tr,
				IF(t2.town = f.town, t1.town, t2.town) AS visitor_team,
				IF(t2.town = f.town, t1.teamRef, t2.teamRef) AS visitor_tr,
				SUM(IF(g.teamRef = t1.teamRef, 1, 0)) AS home_score,
				SUM(IF(g.teamRef = t2.teamRef, 1, 0)) AS visitor_score
			FROM games gm
			RIGHT JOIN sites f
				USING(fieldRef)
			INNER JOIN goals g
				ON gm.gameRef = g.gameRef
			INNER JOIN teams t1
				ON t1.teamRef = gm.usTeamRef
			INNER JOIN teams t2
				ON t2.teamRef = gm.themTeamRef
			WHERE date >= "' . date('Y-m-d', $start_month) . '"
				AND date <= "' . date('Y-m-d', $end_month) . '"
			GROUP BY gm.gameRef
			ORDER BY date, startTime';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the scorers for the specified game
 * @param int $gameRef
 * @return query_result
 */
function get_schedule_scorers($gameRef){
	global $db;
	$sql = 'SELECT pm.reference, pm.LName, COUNT(g.scorer) AS goals, g.teamRef
			FROM playerMaster pm
			INNER JOIN players p
				ON pm.reference = p.playerMasterRef
			INNER JOIN goals g
				ON p.teamRef = g.teamRef
				AND p.jerseyNo = g.scorer
			WHERE g.gameRef = "' . $gameRef . '"
			GROUP BY pm.reference
			ORDER BY g.teamRef, goals DESC, p.jerseyNo';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns the goal keepers for the specified game
 * @param int $gameRef
 * @return query_result
 */
function get_schedule_goalies($gameRef){
	global $db;
	$sql = 'SELECT pm.reference, pm.LName, s.teamRef,
				s.savedQ1 + s.savedQ2 + s.savedQ3 + s.savedQ4 + s.savedOT AS saves
			FROM playerMaster pm
			INNER JOIN players p
				ON pm.reference = p.playerMasterRef
			INNER JOIN saves s
				ON p.teamRef = s.teamRef
				AND p.jerseyNo = s.playerRef
			WHERE s.gameRef = "' . $gameRef . '"
			GROUP BY pm.reference
			ORDER BY p.depth, saves DESC';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns an html string of goalkeepers, links and game data
 * @param object $goalie_obj
 * @param int $gameRef
 * @param int $winner_tr
 * @return string
 */
function set_goalkeeper_string($goalie_obj, $gameRef, $winner_tr){
	$winning_goalie = '';
	$losing_goalie = '';
	$goalie_obj->move();
	while(!$goalie_obj->eof){
		if($goalie_obj->field['gameRef'] == $gameRef){
			//get data
			$player_pmr = $goalie_obj->field['reference'];
			$player_tr = $goalie_obj->field['teamRef'];
			$player_name = $goalie_obj->field['name'];
			//process data
			$param = 'pmr='.$player_pmr;
			$player_href = set_href(FILENAME_PLAYER_SUMMARY, $param);
			if($player_tr == $winner_tr){
				$winning_goalie = ', <a href="' . $player_href . '">' . $player_name . '</a>';
			} else {
				$losing_goalie = ', <a href="' . $player_href . '">' . $player_name . '</a>';
			}
		}
		$goalie_obj->move_next();
	}
	$winning_goalie = '<b>W: </b>' . substr($winning_goalie, 2);
	$losing_goalie = '<b>L: </b>' . substr($losing_goalie, 2);
	$r = $winning_goalie . '; ' . $losing_goalie . '.';
	return $r;
}


/**
 * Returns an html string of scorers and assists, statistics and links.
 * @param boolean $test
 * @param array $player_array
 * @param int $winner_tr
 * @param int $home_tr
 * @param string $home_abbrev
 * @param string $visitor_abbrev
 * @return string
 */
function set_player_string($test, $player_array, $winner_tr, $home_tr, $home_abbrev, $visitor_abbrev){
	$winners = '';
	$losers = '';
	for($i = 0; $i < count($player_array['player_pmr']); $i++){
		//get data
		$player_pmr		 = $player_array['player_pmr'][$i];
		$player_tr		 = $player_array['player_tr'][$i];
		$player_name	 = $player_array['player_name'][$i];
		$statistic		 = ($test == 1 ? $player_array['goals'][$i] : $player_array['assists'][$i]);
		//process data
		$param = 'pmr=' . $player_pmr;
		$player_href = set_href(FILENAME_PLAYER_SUMMARY, $param);
		if($statistic > 0){
			if($player_tr == $winner_tr){
				$winners .= ', <a href="' . $player_href . '">' . $player_name . '</a> (' . $statistic . ')';
			} else {
				$losers .= ', <a href="' . $player_href . '">'.$player_name . '</a> (' . $statistic . ')';
			}
		}
	}
	if($test){
		$winners = ($winners != '' ? substr($winners, 2) : 'No goals');
		$losers = ($losers != '' ? substr($losers, 2) : 'No goals');
	} else {
		$winners = ($winners != '' ? substr($winners, 2) : 'No assists');
		$losers = ($losers != '' ? substr($losers, 2) : 'No assists');
	}
	if($winner_tr == $home_tr){
		$winners = '<b>' . $home_abbrev . ': </b>' . $winners;
		$losers = '<b>' . $visitor_abbrev . ': </b>' . $losers;
	} else {
		$winners = '<b>' . $visitor_abbrev . ': </b>'. $winners;
		$losers = '<b>' . $home_abbrev . ': </b>'. $losers;
	}
	$r = $winners . '; ' . $losers . '.';
	return $r;
}

/**
 * Returns box score game data
 * @param int $gameRef
 * @return query_result
 */
function get_box_score_game($gameRef){
	global $db;
	$sql = 'SELECT gm.season, gm.seasonType, gm.date, TIME_TO_SEC(gm.startTime) AS time,
				gm.usTeamRef, gm.themTeamRef, gm.fieldRef, gm.conditions, gm.scorekeeper,
				gm.timekeeper, gm.referee, gm.umpire, gm.fieldJudge, gm.conference,
				t1.town AS us_town, t1.name AS us_name, t1.shortName AS us_short_name,
				t2.town AS them_town, t2.name AS them_name, t2.shortName AS them_short_name,
				SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 1, 1, 0)) AS us_q1,
				SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 2, 1, 0)) AS us_q2,
				SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 3, 1, 0)) AS us_q3,
				SUM(IF(g.teamRef = t1.teamRef AND g.quarter = 4, 1, 0)) AS us_q4,
				SUM(IF(g.teamRef = t1.teamRef AND g.quarter LIKE \'O%\', 1, 0)) AS us_ot,
				SUM(IF(g.teamRef = t1.teamRef, 1, 0)) AS us_score,
				SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 1, 1, 0)) AS them_q1,
				SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 2, 1, 0)) AS them_q2,
				SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 3, 1, 0)) AS them_q3,
				SUM(IF(g.teamRef = t2.teamRef AND g.quarter = 4, 1, 0)) AS them_q4,
				SUM(IF(g.teamRef = t2.teamRef AND g.quarter LIKE \'O%\', 1, 0)) AS them_ot,
				SUM(IF(g.teamRef = t2.teamRef, 1, 0)) AS them_score,
				s.town AS field, s.name AS field_name
			FROM games gm
			INNER JOIN teams t1
				ON gm.usTeamRef = t1.teamRef
			INNER JOIN teams t2
				ON gm.themTeamRef = t2.teamRef
			INNER JOIN goals g
				ON gm.gameRef = g.gameRef
			INNER JOIN sites s
				ON gm.fieldRef = s.fieldRef
			WHERE gm.gameRef = "' . $gameRef . '"
			GROUP BY gm.gameRef';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Return box score scoring data
 * @param int $gameRef
 * @return query_result
 */
function get_box_score_scoring($gameRef){
	global $db;
	$sql = 'SELECT g.teamRef, g.quarter, g.timeClock, g.teamRef, g.goalCode,
				IF(p1.FName != "", CONCAT_WS(" ", p1.FName, p1.LName), p1.LName) AS scorer,
				IF(g.assist > 0,
					IF(p2.FName != "",
						CONCAT_WS(" ", "Assist:", p2.FName, p2.LName),
						CONCAT_WS(" ", "Assist:", p2.LName)),
					"Unassisted") AS assist
			FROM goals g
			INNER JOIN players p1
				ON g.teamRef = p1.teamRef AND g.scorer = p1.jerseyNo
			LEFT JOIN players p2
				ON g.teamRef = p2.teamRef AND g.assist = p2.jerseyNo
			WHERE g.gameRef = "' . $gameRef . '"
			ORDER BY g.quarter ASC, g.timeClock DESC';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns box score penalty data
 * @param int $gameRef
 * @return query_result
 */
function get_box_score_penalties($gameRef){
	global $db;
	$sql = 'SELECT pn.teamRef, pn.duration, pn.startQtr, pn.startTime, pn.infraction,
				IF(p.FName != "", CONCAT_WS(" ", p.FName, p.LName), p.LName) AS player
			FROM penalties pn
			INNER JOIN players p
				ON pn.teamRef = p.teamRef AND pn.playerRef = p.jerseyNo
			WHERE pn.gameRef = "' . $gameRef . '"
			ORDER BY startQtr ASC, startTime DESC';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns box score line-up
 * @param int $teamRef
 * @param int $gameRef
 * @return query_result
 */
function get_box_score_lineup($teamRef, $gameRef){
	global $db;
	$sql = 'SELECT p.jerseyNo,
				IF(p.FName != "", CONCAT_WS(" ", p.FName, p.LName), p.LName) AS player_name,
				IF(pl.gameRef = "' . $gameRef . '", pl.position, p.position) AS position,
				IF(pl.gameRef = "' . $gameRef . '",
					IF(pl.position = "A" OR pl.position = "M" OR pl.position = "", 1, 2),
					IF(p.position = "A" OR p.position = "M" OR p.position = "", 1, 2)) AS sequence,
				IF(pl.gameRef = "' . $gameRef . '", pl.started, NULL) AS started
			FROM players p
			LEFT JOIN plays pl
				ON p.teamRef = pl.teamRef
				AND p.jerseyNo = pl.playerRef
				AND pl.gameRef = "' . $gameRef . '"
			WHERE p.teamRef = "' . $teamRef . '"
			GROUP BY p.jerseyNo
			ORDER BY started DESC, sequence, position, p.jerseyNo';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns box score offensive data
 * @param int $teamRef
 * @param int $gameRef
 * @return query_result
 */
function get_box_score_offense($teamRef, $gameRef){
	global $db;
	$sql = 'SELECT pl.position, p.jerseyNo, p.playerMasterRef,
				IF(p.FName != "", CONCAT_WS(" ", p.FName, p.LName), p.LName) AS player_name,
				SUM(IF(pl.playerRef = g.scorer, 1, 0)) AS goals,
				SUM(IF(pl.playerRef = g.assist, 1, 0)) AS assists,
				SUM(IF(pl.playerRef = g.scorer, 1, 0)) + SUM(IF(pl.playerRef = g.assist, 1, 0)) AS points,
				pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT AS shots,
				IF(pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT > 0,
					FORMAT(SUM(IF(pl.playerRef = g.scorer, 1, 0)) / (pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT), 3),
					FORMAT(0, 3)) AS shot_pct,
				pl.gbQ1 + pl.gbQ2 + pl.gbQ3 + pl.gbQ4 + pl.gbOT AS gb
			FROM plays pl
			INNER JOIN players p
				ON pl.teamRef = p.teamRef AND pl.playerRef = p.jerseyNo
			LEFT JOIN goals g
				ON pl.gameRef = g.gameRef AND pl.teamRef = g.teamRef
			WHERE pl.gameRef = "' . $gameRef . '"
				AND pl.teamRef = "' . $teamRef . '"
			GROUP BY pl.playerRef
			ORDER BY points DESC, goals DESC, assists DESC, shot_pct DESC, shots DESC,
				gb DESC, p.jerseyNo';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns box score faceoff data
 * @param int $teamRef
 * @param int $gameRef
 * @return query_result
 */
function get_box_score_faceoffs($teamRef, $gameRef){
	global $db;
	$sql = 'SELECT p.playerMasterRef,
				IF(p.FName != "", CONCAT_WS(" ", p.FName, p.LName), p.LName) AS player_name,
				fo.wonQ1 + fo.wonQ2 + fo.wonQ3 + fo.wonQ4 + fo.wonOT AS won,
				fo.lostQ1 + fo.lostQ2 + fo.lostQ3 + fo.lostQ4 + fo.lostOT AS lost
			FROM faceoffs fo
			INNER JOIN players p
				ON fo.teamRef = p.teamRef AND fo.playerRef = p.jerseyNo
			INNER JOIN plays pl
				ON fo.gameRef = pl.gameRef
				AND fo.teamRef = pl.teamRef
				AND fo.playerRef = pl.playerRef
			WHERE fo.gameRef = "' . $gameRef . '"
				AND fo.teamRef = "' . $teamRef . '"
			ORDER BY won DESC, p.jerseyNo';
	$r = $db->db_query($sql);
	return $r;
}

/**
 * Returns box score goalie data
 * @param int $teamRef
 * @param int $gameRef
 * @return query_result
 */
function get_box_score_saves($teamRef, $gameRef){
	global $db;
	$sql = 'SELECT p.playerMasterRef,
				IF(p.FName != "", CONCAT_WS(" ", p.FName, p.LName), p.LName) AS player_name,
				sv.savedQ1 + sv.savedQ2 + sv.savedQ3 + sv.savedQ4 + sv.savedOT AS saved,
				sv.allowedQ1 + sv.allowedQ2 + sv.allowedQ3 + sv.allowedQ4 + sv.allowedOT AS allowed
			FROM saves sv
			INNER JOIN players p
				ON sv.teamRef = p.teamRef AND sv.playerRef = p.jerseyNo
			INNER JOIN plays pl
				ON sv.gameRef = pl.gameRef
				AND sv.teamRef = pl.teamRef
				AND sv.playerRef = pl.playerRef
			WHERE sv.gameRef = "' . $gameRef . '"
				AND sv.teamRef = "' . $teamRef . '"
			ORDER BY saved DESC, p.jerseyNo';
	$r = $db->db_query($sql);
	return $r;
}
?>