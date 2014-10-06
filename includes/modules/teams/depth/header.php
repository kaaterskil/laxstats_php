<?php
define('PAGE_TITLE', 'Depth Chart');
$masthead_logo = MASTHEAD_TEAM_DEPTH;
$tpl_menubar = MENUBAR_PUBLIC;

//retrieve players
$sql = 'SELECT p.playerMasterRef, p.position, p.depth, p.jerseyNo, pm.LName, pm.FName, pm.class
		FROM playerMaster pm
		LEFT JOIN players p
			ON pm.reference = p.playerMasterRef
		LEFT JOIN plays py
			ON py.teamRef = p.teamRef
			AND py.playerRef = p.jerseyNo
		WHERE p.teamRef = "' . $teamRef . '"
		GROUP BY p.jerseyNo
		ORDER BY p.position, p.depth, p.jerseyNo';
$players = $db->db_query($sql);

//retrieve career goals
$sql = 'SELECT p.playerMasterRef, COUNT(g.scorer) AS goals
		FROM players p
		INNER JOIN games gm
			ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
		LEFT JOIN goals g
			ON gm.gameRef = g.gameRef
			AND p.teamRef = g.teamRef
			AND p.jerseyNo = g.scorer
		WHERE p.teamRef = "' . $teamRef . '"
		GROUP BY p.jerseyNo, gm.gameRef
		ORDER BY p.position, p.depth, p.jerseyNo, gm.date DESC';
$goals_obj = $db->db_query($sql);

//retrieve career shots and ground balls
$sql = 'SELECT p.playerMasterRef,
			SUM(pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT) AS shots,
			SUM(pl.gbQ1 + pl.gbQ2 + pl.gbQ3 + pl.gbQ4 + pl.gbOT) AS gb
		FROM players p
		INNER JOIN games gm
			ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
		LEFT JOIN plays pl
			ON gm.gameRef = pl.gameRef
			AND p.teamRef = pl.teamRef
			AND p.jerseyNo = pl.playerRef
		WHERE p.teamRef = "' . $teamRef . '"
		GROUP BY p.jerseyNo, gm.gameRef
		ORDER BY p.position, p.depth, p.jerseyNo, gm.date DESC';
$plays = $db->db_query($sql);

//retrieve career saves and goals allowed
$sql = 'SELECT p.playerMasterRef,
			SUM(s.savedQ1 + s.savedQ2 + s.savedQ3 + s.savedQ4 + s.savedOT) AS saves,
			SUM(s.allowedQ1 + s.allowedQ2 + s.allowedQ3 + s.allowedQ4 + s.allowedOT) AS ga
		FROM players p
		INNER JOIN games gm
			ON (p.teamRef = gm.themTeamRef OR p.teamRef = gm.usTeamRef)
		LEFT JOIN saves s
			ON gm.gameRef = s.gameRef
			AND p.teamRef = s.teamRef
			AND p.jerseyNo = s.playerRef
		WHERE p.teamRef = "' . $teamRef . '"
		GROUP BY p.jerseyNo, gm.gameRef
		ORDER BY p.position, p.depth, p.jerseyNo, gm.date DESC';
$saves = $db->db_query($sql);

//build player arrays by position
$attacks = array();
$middies = array();
$defense = array();
$goalies = array();
$unknown = array();
while(!$players->eof){
	$pos = $players->field['position'];
	switch($pos){
		case 'A':
			$attacks[] = $players->field;
			break;
		case 'M':
		case 'LSM':
			$middies[] = $players->field;
			break;
		case 'D':
		case 'DM':
			$defense[] = $players->field;
			break;
		case 'G':
		case 'GK':
			$goalies[] = $players->field;
			break;
		default:
			$unknown[] = $players->field;
	}
	$players->move_next();
}
?>