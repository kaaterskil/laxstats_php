<?php
$masthead_logo = MASTHEAD_PLAYER_STATS;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Player Stats');

$sql = 'SELECT t1.season, gm.gameRef, gm.date, t2.town AS opponent, f.town AS field, p.teamRef,
			SUM(IF(g.scorer = p.jerseyNo AND g.teamRef = t1.teamRef, 1, 0)
				+ IF(g.assist = p.jerseyNo AND g.teamRef = t1.teamRef, 1, 0)) AS statistic
		FROM sites f
		INNER JOIN games gm
			ON f.fieldRef = gm.fieldRef
		INNER JOIN goals g
			ON gm.gameRef = g.gameRef
		INNER JOIN teams t1
			ON (gm.usTeamRef = t1.teamRef OR gm.themTeamRef = t1.teamRef)
		INNER JOIN teams t2
			ON (gm.usTeamRef = t2.teamRef OR gm.themTeamRef = t2.teamRef)
			AND t2.teamRef != t1.teamRef
		INNER JOIN players p
			ON t1.teamRef = p.teamRef
		INNER JOIN playerMaster pm
			ON p.playerMasterRef = pm.reference
		WHERE pm.reference = "' . $playerMasterRef . '"
			AND gm.final != "F"
		GROUP BY gm.gameRef
		ORDER BY t1.season DESC, statistic DESC, gm.date DESC';
$high_points = $db->db_query($sql);
		
$sql = 'SELECT t1.season, gm.gameRef, gm.date, t2.town AS opponent, f.town AS field, p.teamRef,
			SUM(IF(g.scorer = p.jerseyNo AND g.teamRef = t1.teamRef, 1, 0)) AS statistic
		FROM sites f
		RIGHT JOIN games gm
			ON f.fieldRef = gm.fieldRef
		RIGHT JOIN goals g
			ON gm.gameRef = g.gameRef
		RIGHT JOIN teams t1
			ON (gm.usTeamRef = t1.teamRef OR gm.themTeamRef = t1.teamRef)
		RIGHT JOIN teams t2
			ON (gm.usTeamRef = t2.teamRef OR gm.themTeamRef = t2.teamRef)
			AND t2.teamRef != t1.teamRef
		INNER JOIN players p
			ON t1.teamRef = p.teamRef
		INNER JOIN playerMaster pm
			ON p.playerMasterRef = pm.reference
		WHERE pm.reference = "' . $playerMasterRef . '"
			AND gm.final != "F"
		GROUP BY gm.gameRef
		ORDER BY t1.season DESC, statistic DESC, gm.date DESC';
$high_goals = $db->db_query($sql);
		
$sql = 'SELECT t1.season, gm.gameRef, gm.date, t2.town AS opponent, f.town AS field, p.teamRef,
			SUM(IF(g.assist = p.jerseyNo AND g.teamRef = t1.teamRef,1,0)) AS statistic
		FROM sites f
		RIGHT JOIN games gm
			ON f.fieldRef = gm.fieldRef
		RIGHT JOIN goals g
			ON gm.gameRef = g.gameRef
		RIGHT JOIN teams t1
			ON (gm.usTeamRef = t1.teamRef OR gm.themTeamRef = t1.teamRef)
		RIGHT JOIN teams t2
			ON (gm.usTeamRef = t2.teamRef OR gm.themTeamRef = t2.teamRef)
			AND t2.teamRef != t1.teamRef
		INNER JOIN players p
			ON t1.teamRef = p.teamRef
		INNER JOIN playerMaster pm
			ON p.playerMasterRef = pm.reference
		WHERE pm.reference = "'.$playerMasterRef.'"
			AND gm.final != "F"
		GROUP BY gm.gameRef
		ORDER BY t1.season DESC, statistic DESC, gm.date DESC';
$high_assists = $db->db_query($sql);
		
$sql = 'SELECT t1.season, gm.gameRef, gm.date, t2.town AS opponent, f.town AS field, p.teamRef,
			SUM(IF(pl.teamRef = p.teamRef AND pl.playerRef = p.jerseyNo,
				shotsQ1 + shotsQ2 + shotsQ3 + shotsQ4 + shotsOT, 0)) AS statistic
		FROM sites f
		RIGHT JOIN games gm
			ON f.fieldRef = gm.fieldRef
		RIGHT JOIN plays pl
			ON gm.gameRef = pl.gameRef
		RIGHT JOIN teams t1
			ON (gm.usTeamRef = t1.teamRef OR gm.themTeamRef = t1.teamRef)
		RIGHT JOIN teams t2
			ON (gm.usTeamRef = t2.teamRef OR gm.themTeamRef = t2.teamRef)
			AND t2.teamRef != t1.teamRef
		INNER JOIN players p
			ON t1.teamRef = p.teamRef
		INNER JOIN playerMaster pm
			ON p.playerMasterRef = pm.reference
		WHERE pm.reference = "' . $playerMasterRef . '"
			AND gm.final != "F"
		GROUP BY gm.gameRef
		ORDER BY t1.season DESC, statistic DESC, gm.date DESC';
$high_shots = $db->db_query($sql);
		
$sql = 'SELECT t1.season, gm.gameRef, gm.date, t2.town AS opponent, f.town AS field, p.teamRef,
			SUM(IF(pl.teamRef = p.teamRef AND pl.playerRef = p.jerseyNo,
				gbQ1 + gbQ2 + gbQ3 + gbQ4 + gbOT, 0)) AS statistic
		FROM sites f
		RIGHT JOIN games gm
			ON f.fieldRef = gm.fieldRef
		RIGHT JOIN plays pl
			ON gm.gameRef = pl.gameRef
		RIGHT JOIN teams t1
			ON (gm.usTeamRef = t1.teamRef OR gm.themTeamRef = t1.teamRef)
		RIGHT JOIN teams t2
			ON (gm.usTeamRef = t2.teamRef OR gm.themTeamRef = t2.teamRef)
			AND t2.teamRef != t1.teamRef
		INNER JOIN players p
			ON t1.teamRef = p.teamRef
		INNER JOIN playerMaster pm
			ON p.playerMasterRef = pm.reference
		WHERE pm.reference = "' . $playerMasterRef . '"
			AND gm.final != "F"
		GROUP BY gm.gameRef
		ORDER BY t1.season DESC, statistic DESC, gm.date DESC';
$high_gb = $db->db_query($sql);
?>