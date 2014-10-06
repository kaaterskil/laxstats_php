<?php
/*------------------------------------------------------------
TEST FOR 10 STARTERS
------------------------------------------------------------*/
function verify_starters($gameRef){
	global $db;
	$sql = 'SELECT t1.town AS town1, t2.town AS town2,
				SUM(IF(pl.teamRef=gm.usTeamRef AND pl.started=\'T\', 1, 0)) AS starters1,
				SUM(IF(pl.teamRef=gm.themTeamRef AND pl.started=\'T\', 1, 0)) AS starters2
			FROM games gm
			INNER JOIN teams t1, teams t2
				ON t1.teamRef=gm.usTeamRef AND t2.teamRef=gm.themTeamRef
			INNER JOIN plays pl
				ON gm.gameRef=pl.gameRef
			WHERE gm.gameRef='.$gameRef.'
			GROUP BY gm.gameRef';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
TEST FOR SCORERS ON PLAYLIST
------------------------------------------------------------*/
function verify_scorers($gameRef){
	global $db;
	$sql = 'SELECT p1a.LName AS scorer, p2a.LName AS player1, p1b.LName AS assist, p2b.LName AS player2
			FROM goals g
			LEFT JOIN players p1a
				ON p1a.teamRef=g.teamRef AND p1a.jerseyNo=g.scorer
			LEFT JOIN players p1b
				ON p1b.teamRef=g.teamRef AND p1b.jerseyNo=g.assist
			LEFT JOIN plays pya
				ON pya.gameRef=g.gameRef AND pya.teamRef=g.teamRef AND pya.playerRef=g.scorer
			LEFT JOIN players p2a
				ON p2a.teamRef=pya.teamRef AND p2a.jerseyNo=pya.playerRef
			LEFT JOIN plays pyb
				ON pyb.gameRef=g.gameRef AND pyb.teamRef=g.teamRef AND pyb.playerRef=g.assist
			LEFT JOIN players p2b
				ON p2b.teamRef=pyb.teamRef AND p2b.jerseyNo=pyb.playerRef
			WHERE g.gameRef='.$gameRef;
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
TEST FOR PLAYER SHOTS >= GOALS
------------------------------------------------------------*/
function verify_shots($gameRef){
	global $db;
	$sql = 'SELECT IF(p.FName!=\'\', CONCAT_WS(\' \', p.FName, p.LName), p.LName) AS player, pl.shotsQ1 + pl.shotsQ2 + pl.shotsQ3 + pl.shotsQ4 + pl.shotsOT AS shots, COUNT(g.scorer) AS goals
			FROM goals g
			INNER JOIN plays pl
				ON pl.gameRef=g.gameRef AND pl.teamRef=g.teamRef AND pl.playerRef=g.scorer
			INNER JOIN players p
				ON p.teamRef=g.teamRef AND p.jerseyNo=g.scorer
			WHERE g.gameRef='.$gameRef.'
			GROUP BY p.teamRef, g.scorer';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
TEST FOR VIOLATORS ON PLAYLIST
------------------------------------------------------------*/
function verify_violators($gameRef){
	global $db;
	$sql = 'SELECT IF(p1.FName!=\'\', CONCAT_WS(\' \', p1.FName, p1.LName), p1.LName) AS violator, IF(p2.FName!=\'\', CONCAT_WS(\' \', p2.FName, p2.LName), p2.LName) AS player
			FROM penalties pn
			INNER JOIN players p1
				ON p1.teamRef=pn.teamRef AND p1.jerseyNo=pn.playerRef
			LEFT JOIN plays py
				ON py.gameRef=pn.gameRef AND py.teamRef=pn.teamRef AND py.playerRef=pn.playerRef
			LEFT JOIN players p2
				ON p2.teamRef=py.teamRef AND p2.jerseyNo=py.playerRef
			WHERE pn.gameRef='.$gameRef.'
			GROUP BY pn.reference';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
TEST FOR GOALIES ON PLAYLIST
------------------------------------------------------------*/
function verify_goalies($gameRef){
	global $db;
	$sql = 'SELECT IF(p1.FName!=\'\', CONCAT_WS(\' \', p1.FName, p1.LName), p1.LName) AS goalie, IF(p2.FName!=\'\', CONCAT_WS(\' \', p2.FName, p2.LName), p2.LName) AS player
			FROM saves sv
			INNER JOIN players p1
				ON p1.teamRef=sv.teamRef AND p1.jerseyNo=sv.playerRef
			LEFT JOIN plays py
				ON py.gameRef=sv.gameRef AND py.teamRef=sv.teamRef AND py.playerRef=sv.playerRef
			LEFT JOIN players p2
				ON p2.teamRef=py.teamRef AND p2.jerseyNo=py.playerRef
			WHERE sv.gameRef='.$gameRef.'
			GROUP BY sv.reference';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
TEST FOR FACEOFF SPECIALISTS ON PLAYLIST
------------------------------------------------------------*/
function verify_faceoff_players($gameRef){
	global $db;
	$sql = 'SELECT IF(p1.FName!=\'\', CONCAT_WS(\' \', p1.FName, p1.LName), p1.LName) AS faceoff, IF(p2.FName!=\'\', CONCAT_WS(\' \', p2.FName, p2.LName), p2.LName) AS player
			FROM faceoffs fo
			INNER JOIN players p1
				ON p1.teamRef=fo.teamRef AND p1.jerseyNo=fo.playerRef
			LEFT JOIN plays py
				ON py.gameRef=fo.gameRef AND py.teamRef=fo.teamRef AND py.playerRef=fo.playerRef
			LEFT JOIN players p2
				ON p2.teamRef=py.teamRef AND p2.jerseyNo=py.playerRef
			WHERE fo.gameRef='.$gameRef.'
			GROUP BY fo.reference';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
TEST QUARTERLY TOTALS FOR SANITY
------------------------------------------------------------*/
function get_validation_shots($gameRef){
	global $db;
	$sql = 'SELECT t1.town AS us_town, t2.town AS them_town,
				SUM(IF(pl.teamRef=gm.usTeamRef, pl.shotsQ1, 0)) AS shots_us_q1,
				SUM(IF(pl.teamRef=gm.usTeamRef, pl.shotsQ2, 0)) AS shots_us_q2,
				SUM(IF(pl.teamRef=gm.usTeamRef, pl.shotsQ3, 0)) AS shots_us_q3,
				SUM(IF(pl.teamRef=gm.usTeamRef, pl.shotsQ4, 0)) AS shots_us_q4,
				SUM(IF(pl.teamRef=gm.usTeamRef, pl.shotsOT, 0)) AS shots_us_OT,
				SUM(IF(pl.teamRef!=gm.usTeamRef, pl.shotsQ1, 0)) AS shots_them_q1,
				SUM(IF(pl.teamRef!=gm.usTeamRef, pl.shotsQ2, 0)) AS shots_them_q2,
				SUM(IF(pl.teamRef!=gm.usTeamRef, pl.shotsQ3, 0)) AS shots_them_q3,
				SUM(IF(pl.teamRef!=gm.usTeamRef, pl.shotsQ4, 0)) AS shots_them_q4,
				SUM(IF(pl.teamRef!=gm.usTeamRef, pl.shotsOT, 0)) AS shots_them_OT
			FROM games gm
			INNER JOIN plays pl
				ON gm.gameRef=pl.gameRef
			INNER JOIN teams t1, teams t2
				ON t1.teamRef=gm.usTeamRef AND t2.teamRef=gm.themTeamRef
			WHERE gm.gameRef='.$gameRef.'
			GROUP BY gm.gameRef';
	$r = $db->db_query($sql);
	return $r;
}
function get_validation_goals($gameRef){
	global $db;
	$sql = 'SELECT 
				SUM(IF(g.teamRef=gm.usTeamRef AND g.quarter=1, 1, 0)) AS goals_us_q1, 
				SUM(IF(g.teamRef=gm.usTeamRef AND g.quarter=2, 1, 0)) AS goals_us_q2, 
				SUM(IF(g.teamRef=gm.usTeamRef AND g.quarter=3, 1, 0)) AS goals_us_q3, 
				SUM(IF(g.teamRef=gm.usTeamRef AND g.quarter=4, 1, 0)) AS goals_us_q4, 
				SUM(IF(g.teamRef=gm.usTeamRef AND g.quarter LIKE \'O%\', 1, 0)) AS goals_us_OT, 
				SUM(IF(g.teamRef!=gm.usTeamRef AND g.quarter=1, 1, 0)) AS goals_them_q1, 
				SUM(IF(g.teamRef!=gm.usTeamRef AND g.quarter=2, 1, 0)) AS goals_them_q2, 
				SUM(IF(g.teamRef!=gm.usTeamRef AND g.quarter=3, 1, 0)) AS goals_them_q3, 
				SUM(IF(g.teamRef!=gm.usTeamRef AND g.quarter=4, 1, 0)) AS goals_them_q4, 
				SUM(IF(g.teamRef!=gm.usTeamRef AND g.quarter LIKE \'O%\', 1, 0)) AS goals_them_OT 
			FROM games gm 
			INNER JOIN goals g 
				ON gm.gameRef=g.gameRef
			WHERE gm.gameRef='.$gameRef.' 
			GROUP BY gm.gameRef';
	$r = $db->db_query($sql);
	return $r;
}
function get_validation_saves($gameRef){
	global $db;
	$sql = 'SELECT
				SUM(IF(sv.teamRef=gm.usTeamRef, sv.savedQ1, 0)) AS saved_us_q1,
				SUM(IF(sv.teamRef=gm.usTeamRef, sv.savedQ2, 0)) AS saved_us_q2,
				SUM(IF(sv.teamRef=gm.usTeamRef, sv.savedQ3, 0)) AS saved_us_q3,
				SUM(IF(sv.teamRef=gm.usTeamRef, sv.savedQ4, 0)) AS saved_us_q4,
				SUM(IF(sv.teamRef=gm.usTeamRef, sv.savedOT, 0)) AS saved_us_OT,
				SUM(IF(sv.teamRef!=gm.usTeamRef, sv.savedQ1, 0)) AS saved_them_q1,
				SUM(IF(sv.teamRef!=gm.usTeamRef, sv.savedQ2, 0)) AS saved_them_q2,
				SUM(IF(sv.teamRef!=gm.usTeamRef, sv.savedQ3, 0)) AS saved_them_q3,
				SUM(IF(sv.teamRef!=gm.usTeamRef, sv.savedQ4, 0)) AS saved_them_q4,
				SUM(IF(sv.teamRef!=gm.usTeamRef, sv.savedOT, 0)) AS saved_them_OT,
				SUM(IF(sv.teamRef=gm.usTeamRef, sv.allowedQ1, 0)) AS allowed_us_q1,
				SUM(IF(sv.teamRef=gm.usTeamRef, sv.allowedQ2, 0)) AS allowed_us_q2,
				SUM(IF(sv.teamRef=gm.usTeamRef, sv.allowedQ3, 0)) AS allowed_us_q3,
				SUM(IF(sv.teamRef=gm.usTeamRef, sv.allowedQ4, 0)) AS allowed_us_q4,
				SUM(IF(sv.teamRef=gm.usTeamRef, sv.allowedOT, 0)) AS allowed_us_OT,
				SUM(IF(sv.teamRef!=gm.usTeamRef, sv.allowedQ1, 0)) AS allowed_them_q1,
				SUM(IF(sv.teamRef!=gm.usTeamRef, sv.allowedQ2, 0)) AS allowed_them_q2,
				SUM(IF(sv.teamRef!=gm.usTeamRef, sv.allowedQ3, 0)) AS allowed_them_q3,
				SUM(IF(sv.teamRef!=gm.usTeamRef, sv.allowedQ4, 0)) AS allowed_them_q4,
				SUM(IF(sv.teamRef!=gm.usTeamRef, sv.allowedOT, 0)) AS allowed_them_OT
			FROM games gm
			INNER JOIN saves sv
				ON gm.gameRef=sv.gameRef
			WHERE gm.gameRef='.$gameRef.'
			GROUP BY gm.gameRef';
	$r = $db->db_query($sql);
	return $r;
}
function get_validation_faceoffs($gameRef){
	global $db;
	$sql = 'SELECT
				SUM(IF(fo.teamRef=gm.usTeamRef, fo.wonQ1, 0)) AS won_us_q1,
				SUM(IF(fo.teamRef=gm.usTeamRef, fo.wonQ2, 0)) AS won_us_q2,
				SUM(IF(fo.teamRef=gm.usTeamRef, fo.wonQ3, 0)) AS won_us_q3,
				SUM(IF(fo.teamRef=gm.usTeamRef, fo.wonQ4, 0)) AS won_us_q4,
				SUM(IF(fo.teamRef=gm.usTeamRef, fo.wonOT, 0)) AS won_us_OT,
				SUM(IF(fo.teamRef=gm.usTeamRef, fo.lostQ1, 0)) AS lost_us_q1,
				SUM(IF(fo.teamRef=gm.usTeamRef, fo.lostQ2, 0)) AS lost_us_q2,
				SUM(IF(fo.teamRef=gm.usTeamRef, fo.lostQ3, 0)) AS lost_us_q3,
				SUM(IF(fo.teamRef=gm.usTeamRef, fo.lostQ4, 0)) AS lost_us_q4,
				SUM(IF(fo.teamRef=gm.usTeamRef, fo.lostOT, 0)) AS lost_us_OT,
				SUM(IF(fo.teamRef=gm.usTeamRef, 0, fo.wonQ1)) AS won_them_q1,
				SUM(IF(fo.teamRef=gm.usTeamRef, 0, fo.wonQ2)) AS won_them_q2,
				SUM(IF(fo.teamRef=gm.usTeamRef, 0, fo.wonQ3)) AS won_them_q3,
				SUM(IF(fo.teamRef=gm.usTeamRef, 0, fo.wonQ4)) AS won_them_q4,
				SUM(IF(fo.teamRef=gm.usTeamRef, 0, fo.wonOT)) AS won_them_OT,
				SUM(IF(fo.teamRef=gm.usTeamRef, 0, fo.lostQ1)) AS lost_them_q1,
				SUM(IF(fo.teamRef=gm.usTeamRef, 0, fo.lostQ2)) AS lost_them_q2,
				SUM(IF(fo.teamRef=gm.usTeamRef, 0, fo.lostQ3)) AS lost_them_q3,
				SUM(IF(fo.teamRef=gm.usTeamRef, 0, fo.lostQ4)) AS lost_them_q4,
				SUM(IF(fo.teamRef=gm.usTeamRef, 0, fo.lostOT)) AS lost_them_OT
			FROM games gm
			INNER JOIN faceoffs fo
				ON gm.gameRef=fo.gameRef
			WHERE gm.gameRef='.$gameRef.'
			GROUP BY fo.gameRef';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
VALIDATE FINAL GAME
------------------------------------------------------------*/
function validate_final_game($gameRef){
	global $db;
	$message = '';
	//1. test for 10 starters
	$test = verify_starters($gameRef);
	if($test->field['starters1'] != 10){
		$message .= $test->field['town1'].' has an incorrect number of starters. ';
	}
	if($test->field['starters2'] != 10){
		$message .= $test->field['town2'].' has an incorrect number of starters. ';
	}
	//2. test that players with stats are on the playlist
	//2a. scxorers and assists
	$test = verify_scorers($gameRef);
	while(!$test->eof){
		if($test->field['scorer'] != NULL AND $test->field['player1'] == NULL){
			$message .= $test->field['scorer'].' scored a goal but is not listed as having played. ';
		}
		if($test->field['assist'] != NULL AND $test->field['player2'] == NULL){
			$message .= $test->field['assist'].' assisted a goal but is not listed as having played. ';
		}
		$test->move_next();
	}
	//2b.penalties
	$test = verify_violators($gameRef);
	while(!$test->eof){
		if($test->field['player'] != $test->field['violator']){
			$message .= $test->field['violator'].' had a penalty violation but is not listed as having played. ';
		}
		$test->move_next();
	}
	//2c. goalies
	$test = verify_goalies($gameRef);
	while(!$test->eof){
		if($test->field['player'] != $test->field['goalie']){
			$message .= $test->field['goalie'].' had a save but is not listed as having played. ';
		}
		$test->move_next();
	}
	//2d. faceoffs
	$test = verify_faceoff_players($gameRef);
	while(!$test->eof){
		if($test->field['player'] != $test->field['faceoff']){
			$message .= $test->field['faceoff'].' faced off but is not listed as having played. ';
		}
		$test->move_next();
	}
	//3. test that player shots >= player goals
	$test = verify_shots($gameRef);
	while(!$test->eof){
		if($test->field['goals'] > $test->field['shots']){
			$message .= $test->field['player'].' has more goals than shots. ';
		}
		$test->move_next();
	}
	//4. test quarterly totals
	$shots_obj		= get_validation_shots($gameRef);
	$goals_obj		= get_validation_goals($gameRef);
	$saves_obj		= get_validation_saves($gameRef);
	$faceoffs_obj	= get_validation_faceoffs($gameRef);
	$us_town		= $shots_obj->field['us_town'];
	$them_town		= $shots_obj->field['them_town'];
	for($i = 1; $i < 6; $i++){
		$quarter		= ($i < 5 ? 'q'.$i : 'OT');
		$period			= ($i < 5 ? $i : 'OT');
		//get data
		$us_goals		= $goals_obj->field['goals_us_'.$quarter];
		$them_goals		= $goals_obj->field['goals_them_'.$quarter];
		$us_shots		= $shots_obj->field['shots_us_'.$quarter];
		$them_shots		= $shots_obj->field['shots_them_'.$quarter];
		$us_saves		= $saves_obj->field['saved_us_'.$quarter];
		$them_saves		= $saves_obj->field['saved_them_'.$quarter];
		$us_allowed		= $saves_obj->field['allowed_us_'.$quarter];
		$them_allowed	= $saves_obj->field['allowed_them_'.$quarter];
		$us_won			= $faceoffs_obj->field['won_us_'.$quarter];
		$us_lost		= $faceoffs_obj->field['lost_us_'.$quarter];
		$them_won		= $faceoffs_obj->field['won_them_'.$quarter];
		$them_lost		= $faceoffs_obj->field['lost_them_'.$quarter];
		//test if shots >= (goals + opponent saves)
		if($us_goals > ($us_shots - $them_saves)){
			$message .= $us_town.' has an incorrect number of shots and/or '.$them_town.' has an incorrect number of saves in period '.$period.' (ug:'.$us_goals.' us:'.$us_shots.' ts:'.$them_saves.'). ';
		}
		if($them_goals > ($them_shots - $us_saves)){
			$message .= $us_town.' has an incorrect number of shots and/or '.$them_town.' has an incorrect number of saves in period '.$period.' (tg:'.$them_goals.' ts:'.$them_shots.' us:'.$us_saves.'). ';
		}
		//test that goals = opponent ga
		if($us_goals != $them_allowed){
			$message .= $them_town.' has an incorrect number of goals allowed (ga) in period '.$period.'. ';
		}
		if($them_goals != $us_allowed){
			$message .= $us_town.' has an incorrect number of goals allowed (ga) in period '.$period.'. ';
		}
		//test that faceoffs balance
		if($us_won != $them_lost || $us_lost != $them_won){
			$message .= 'The number of faceofss in period '.$period.' must balance bewteen teams. ';
		}
	}
	//set game as final
	if($message == ''){
		$sql_data_array = array('final' => 'T',
								'modifiedBy' => $_SESSION['user_id'],
								'modified' => 'NOW()'
								);
		$param = 'gameRef='.$gameRef;
		$message = $db->db_write_array('games', $sql_data_array, 'update', $param);
	}
	return $message;
}
?>