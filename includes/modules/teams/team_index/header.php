<?php
$masthead_logo = MASTHEAD_TEAM_INDEX;
$tpl_menubar = MENUBAR_PUBLIC;
$current_year = date('Y');

$href_fans = set_href(FILENAME_FAN);
$href_team_ranking = set_href(FILENAME_TEAM_RANKING).'&s='.$current_year;

$sql = 'SELECT DISTINCT s.name AS state, tm.teamMasterRef, t.teamRef, t.season, tm.conference, tm.town, t.name, tm.password, COUNT(gm.gameRef) AS games, pm.paidStatus
		FROM states s
		INNER JOIN teamsMaster tm
			ON s.abbrev=tm.state
		INNER JOIN teams t
			USING(teamMasterRef)
		LEFT JOIN games gm
			ON t.teamRef=gm.usTeamRef OR t.teamRef=gm.themTeamRef
		LEFT JOIN payments pm
			ON t.teamRef=pm.teamRef
		GROUP BY tm.teamMasterRef, t.season
		ORDER BY s.abbrev, tm.conference, tm.town, t.season DESC';
$teams = $db->db_query($sql);
?>