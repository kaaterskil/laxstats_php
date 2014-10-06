<?php
require('includes/modules/teams/header.php');
if($record_array['wins'] + $record_array['losses'] > 0){
?>
	<div class="body_container">
	<!-- BOF RIGHT COLUMN -->
	<div id="rightContainer">
		<!-- bof individual statistics -->
		<!-- bof offensive stats -->
<?php
	$href = set_href(FILENAME_TEAM_STATS).'&tmr='.$teamMasterRef.'&tr='.$teamRef.'&s='.$season.'&ty='.$type;
?>
		<table border="0" cellspacing="0" cellpadding="0" width="365">
		<tr><td colspan="17" class="chartTitleTC">SORTABLE INDIVIDUAL STATISTICS</td></tr>
		<tr><td colspan="17" class="chartTitle2">OFFENSE</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="23" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="122" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1"><a href="<?php echo $href; ?>&st=g">g</a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1"><a href="<?php echo $href; ?>&st=a">a</a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1"><a href="<?php echo $href; ?>&st=pt">pt</a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC1"><a href="<?php echo $href; ?>&st=sh">sh</a></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC1"><a href="<?php echo $href; ?>&st=sp">sh pct</a></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC1"><a href="<?php echo $href; ?>&st=gb">gb</a></td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
	//get stats
	switch($type){
		case 'A':
			$param = "";
			break;
		case 'T':
			$param = " AND g.seasonType!='F'";
			break;
		default:
			$param = " AND g.seasonType='F'";
			break;
	}
	$plays_obj = get_teamPlayer_plays($teamRef, $param);
	$goals_obj = get_teamPlayer_goals($teamRef, $param);
	$assists_obj = get_teamPlayer_assists($teamRef, $param);
	
	//get players and build player_array
	$player_array = array();
	$sql = 'SELECT playerMasterRef, jerseyNo, FName, LName, position
			FROM players
			WHERE teamRef='.$teamRef;
	$players = $db->db_query($sql);
	while(!$players->eof){
		//get player data
		$playerMasterRef = $players->field['playerMasterRef'];
		$jerseyNo = $players->field['jerseyNo'];
		$first_name = $players->field['FName'];
		$last_name = $players->field['LName'];
		$position = $players->field['position'];
		//get goals
		$goals = 0;
		$goals_obj->move();
		while(!$goals_obj->eof){
			if($goals_obj->field['scorer'] == $jerseyNo){
				$goals = $goals_obj->field['goals'];
				break;
			}
			$goals_obj->move_next();
		}
		//get assists
		$assists = 0;
		$assists_obj->move();
		while(!$assists_obj->eof){
			if($assists_obj->field['assist'] == $jerseyNo){
				$assists = $assists_obj->field['assists'];
				break;
			}
			$assists_obj->move_next();
		}
		//get shots and gb
		$shots = 0;
		$gb = 0;
		$plays_obj->move();
		while(!$plays_obj->eof){
			if($plays_obj->field['jerseyNo'] == $jerseyNo){
				$shots = $plays_obj->field['sh'];
				$gb = $plays_obj->field['gb'];
				break;
			}
			$plays_obj->move_next();
		}
		//process data
		$player_name = set_player_name($first_name, $last_name);
		$points = $goals + $assists;
		$shotPct = ($shots > 0 ? number_format($goals / $shots, 3) : '0.000');
		//add to player array
		$player_array['playerMasterRef'][] = $playerMasterRef;
		$player_array['jerseyNo'][] = $jerseyNo;
		$player_array['playerName'][] = $player_name;
		$player_array['position'][] = $position;
		$player_array['goals'][] = $goals;
		$player_array['assists'][] = $assists;
		$player_array['points'][] = $points;
		$player_array['shots'][] = $shots;
		$player_array['shotPct'][] = $shotPct;
		$player_array['gb'][] = $gb;
		
		$players->move_next();
	}
	
	//sort array
	switch($sortCode){
		case "g":
			array_multisort($player_array['goals'],SORT_DESC,$player_array['assists'],SORT_DESC,$player_array['points'],SORT_DESC,$player_array['shotPct'],SORT_DESC,$player_array['shots'],SORT_DESC,$player_array['gb'],SORT_DESC,$player_array['position'],$player_array['playerMasterRef'],$player_array['jerseyNo'],$player_array['playerName']);
			break;
		case 'a':
			array_multisort($player_array['assists'],SORT_DESC,$player_array['goals'],SORT_DESC,$player_array['points'],SORT_DESC,$player_array['shotPct'],SORT_DESC,$player_array['shots'],SORT_DESC,$player_array['gb'],SORT_DESC,$player_array['position'],$player_array['playerMasterRef'],$player_array['jerseyNo'],$player_array['playerName']);
			break;
		case 'pt':
			array_multisort($player_array['points'],SORT_DESC,$player_array['goals'],SORT_DESC,$player_array['assists'],SORT_DESC,$player_array['shotPct'],SORT_DESC,$player_array['shots'],SORT_DESC,$player_array['gb'],SORT_DESC,$player_array['position'],$player_array['playerMasterRef'],$player_array['jerseyNo'],$player_array['playerName']);
			break;
		case 'sh':
			array_multisort($player_array['shots'],SORT_DESC,$player_array['goals'],SORT_DESC,$player_array['assists'],SORT_DESC,$player_array['points'],SORT_DESC,$player_array['shotPct'],SORT_DESC,$player_array['gb'],SORT_DESC,$player_array['position'],$player_array['playerMasterRef'],$player_array['jerseyNo'],$player_array['playerName']);
			break;
		case 'sp':
			array_multisort($player_array['shotPct'],SORT_DESC,$player_array['goals'],SORT_DESC,$player_array['assists'],SORT_DESC,$player_array['points'],SORT_DESC,$player_array['shots'],SORT_DESC,$player_array['gb'],SORT_DESC,$player_array['position'],$player_array['playerMasterRef'],$player_array['jerseyNo'],$player_array['playerName']);
			break;
		case 'gb':
			array_multisort($player_array['gb'],SORT_DESC,$player_array['goals'],SORT_DESC,$player_array['assists'],SORT_DESC,$player_array['points'],SORT_DESC,$player_array['shotPct'],SORT_DESC,$player_array['shots'],SORT_DESC,$player_array['position'],$player_array['playerMasterRef'],$player_array['jerseyNo'],$player_array['playerName']);
			break;
		default:
			array_multisort($player_array['points'],SORT_DESC,$player_array['goals'],SORT_DESC,$player_array['assists'],SORT_DESC,$player_array['shotPct'],SORT_DESC,$player_array['shots'],SORT_DESC,$player_array['gb'],SORT_DESC,$player_array['position'],$player_array['playerMasterRef'],$player_array['jerseyNo'],$player_array['playerName']);
	}
	
	//loop through player_array
	$totGoals = 0;
	$totAssists = 0;
	$totPoints = 0;
	$totShots = 0;
	$totGB = 0;
	for($i = 0; $i < count($player_array['playerMasterRef']); $i++){
		$playerMasterRef = $player_array['playerMasterRef'][$i];
		$jerseyNo = $player_array['jerseyNo'][$i];
		$position = $player_array['position'][$i];
		$playerName = $player_array['playerName'][$i];
		$goals = $player_array['goals'][$i];
		$assists = $player_array['assists'][$i];
		$points = $player_array['points'][$i];
		$shots = $player_array['shots'][$i];
		$shotPct = $player_array['shotPct'][$i];
		$gb = $player_array['gb'][$i];
		
		$href = set_href(FILENAME_PLAYER_SUMMARY).'&pmr='.$playerMasterRef;
		$background = set_background($i);
		
		$totGoals += $goals;
		$totAssists += $assists;
		$totPoints += $points;
		$totShots += $shots;
		$totGB += $gb;
		
		$goals = ($goals > 0 ? $goals : '-');
		$assists = ($assists > 0 ? $assists : '-');
		$points = ($points > 0 ? $points : '-');
		$shots = ($shots > 0 ? $shots : '-');
		$gb = ($gb > 0 ? $gb : '-');
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><?php echo $position; ?></td>
			<td width="1" class="divider"></td>
			<td width="122" class="chartL"><a href="<?php echo $href; ?>"><?php echo $playerName; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC3"><?php echo $goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC3"><?php echo $assists; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC3"><?php echo $points; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC3"><?php echo $shots; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC3"><?php echo $shotPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC3"><?php echo $gb; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
	}
	$totShotPct = ($totShots > 0 ? number_format($totGoals / $totShots, 3) : '0.000');
?>
		<tr class="background1">
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartL"><b>Team</b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $totGoals; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $totAssists; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $totPoints; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $totShots; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $totShotPct; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC"><b><?php echo $totGB; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
		<tr><td colspan="17" height="10" class="divider2"></td></tr>
		</table>
		<!-- eof offensive stats -->
		
		<!-- bof faceoff stats -->
		<table border="0" cellspacing="0" cellpadding="0" width="365">
		<tr><td colspan="7" class="chartTitle2">FACEOFFS</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="247" class="chartHeaderL"></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">win-loss</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">pct</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
	$totWon = 0;
	$totLost = 0;
	$row = 0;
	$faceoffs_obj = get_teamPlayer_faceoffs($teamRef, $param);
	while(!$faceoffs_obj->eof){
		//get faceoff data
		$jerseyNo = $faceoffs_obj->field['jerseyNo'];
		$won = $faceoffs_obj->field['won'];
		$lost = $faceoffs_obj->field['lost'];
		//get player data
		for($i = 0; $i < count($player_array['playerMasterRef']); $i++){
			$jt = $player_array['jerseyNo'][$i];
			if($jerseyNo == $jt){
				$playerMasterRef = $player_array['playerMasterRef'][$i];
				$playerName = $player_array['playerName'][$i];
				break;
			}
		}
		//process data
		$foPct = ($won + $lost > 0 ? number_format($won / ($won + $lost), 3) : '0.000');
		$totWon += $won;
		$totLost += $lost;
		$href = set_href(FILENAME_PLAYER_SUMMARY).'&pmr='.$playerMasterRef;
		$background = set_background($row);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="243" class="chartL"><a href="<?php echo $href; ?>"><?php echo $playerName; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC3"><?php echo $won.'-'.$lost; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC3"><?php echo $foPct; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		$row++;
		$faceoffs_obj->move_next();
	}
	$totFoPct = ($totWon + $totLost > 0 ? number_format($totWon / ($totWon + $totLost), 3) : '0.000');
?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="243" class="chartL"><b>Team</b></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><b><?php echo $totWon.'-'.$totLost; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $totFoPct; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
		<tr><td colspan="7" height="10" class="divider2"></td></tr>
		</table>
		<!-- eof faceoff stats -->
		
		<!-- bof save stats -->
		<table border="0" cellspacing="0" cellpadding="0" width="365">
		<tr><td colspan="11" class="chartTitle2">SAVES</td></tr>
		<tr><td colspan="11" height="1" class="divider"></td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="177" class="chartHeaderL"></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">saves</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">ga</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">ga avg</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">pct</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
	$totSaved = 0;
	$totAllowed = 0;
	$row = 0;
	$param2 = ($type == 'F' ? 'AND seasonType=\'F\'' : 'AND seasonType!=\'F\'');
	$games_played = get_games_played($teamRef, $param2);
	$totGames = $games_played->field['games'];
	$saves_obj = get_teamPlayer_saves($teamRef, $param);
	while(!$saves_obj->eof){
		//get save data
		$jerseyNo = $saves_obj->field['jerseyNo'];
		$saved = $saves_obj->field['saved'];
		$allowed = $saves_obj->field['allowed'];
		$games_played = $saves_obj->field['games'];
		//get player data
		for($i = 0; $i < count($player_array['playerMasterRef']); $i++){
			$jt = $player_array['jerseyNo'][$i];
			if($jerseyNo == $jt){
				$playerMasterRef = $player_array['playerMasterRef'][$i];
				$playerName = $player_array['playerName'][$i];
				break;
			}
		}
		//process data
		$savePct = ($saved + $allowed > 0 ? number_format($saved / ($saved + $allowed), 3) : '0.000');
		$gaAvg = ($games_played > 0 ? number_format($allowed / $games_played, 1) : '0.0');
		$totSaved += $saved;
		$totAllowed += $allowed;
		$href = set_href(FILENAME_PLAYER_SUMMARY).'&pmr='.$playerMasterRef;
		$background = set_background($row);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="177" class="chartL"><a href="<?php echo $href; ?>"><?php echo $playerName; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC3"><?php echo $saved; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC3"><?php echo $allowed; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC3"><?php echo $gaAvg; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC3"><?php echo $savePct; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		$row++;
		$saves_obj->move_next();
	}
	$totSavePct = ($totSaved + $totAllowed > 0 ? number_format($totSaved / ($totSaved + $totAllowed), 3) : '0.000');
	$totGaAvg = ($totGames > 0 ? number_format($totAllowed / $totGames, 1) : '0.0');
?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="177" class="chartL"><b>Team</b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $totSaved; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $totAllowed; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $totGaAvg; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $totSavePct; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
		<tr><td colspan="11" height="10" class="divider2"></td></tr>
		</table>
		<!-- eof save stats -->
		<!-- eof individual statistics -->
	</div>
	<!-- EOF RIGHT COLUMN -->
	
	<!-- BOF LEFT COLUMN -->
	<div id="leftContainer">
		<!-- bof team statistics -->
		<!-- bof team info -->
<?php
	$sql = 'SELECT tm.shortName, tm.conference, tm.league, t.division, t.type
			FROM teamsMaster tm
			INNER JOIN teams t
			USING (teamMasterRef)
			WHERE t.teamRef='.$teamRef;
	$conference_obj = $db->db_query($sql);
	$teamShort	= $conference_obj->field['shortName'];
	$conference = $conference_obj->field['conference'];
	$league		= $conference_obj->field['league'];
	$division	= $conference_obj->field['division'];
	$letter		= $conference_obj->field['type'];
	$letter		= set_team_letter($letter);
?>
		<table border="0" cellspacing="0" cellpadding="0" width="365">
		<tr><td colspan="3" class="chartTitleTC">TEAM INFO</td></tr>
		<tr><td colspan="3" class="chartHeaderL">GENERAL:</td></tr>
		<tr>
			<td width="152" class="chartL7">Conference:</td>
			<td colspan="2" class="chartR3B"><?php echo $conference; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">League:</td>
			<td colspan="2" class="chartR3B"><?php echo $league; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Division:</td>
			<td colspan="2" class="chartR3B"><?php echo $division; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Letter:</td>
			<td colspan="2" class="chartR3B"><?php echo $letter; ?></td>
		</tr>
		<tr>
			<td width="159" class="chartHeaderL">RECORD:</td>
			<td width="94" class="chartHeaderR">WIN-LOSS</td>
			<td width="94" class="chartHeaderR">PCT</td>
		</tr>
<?php
	//TEAM RECORD
	for($i = 0; $i < 4; $i++){
		switch($i){
			case 0:
				$category = 'Overall:';
				$param = '';
				break;
			case 1:
				$category = 'Conference:';
				$param = "AND conference='T'";
				break;
			case 2:
				$category = 'Regular season:';
				$param = "AND seasonType='F'";
				break;
			case 3:
				$category = 'Post-season:';
				$param = "AND seasonType='T'";
				break;
		}
		$record_array	= get_team_record($teamRef, $param);
		$wins			= $record_array['wins'];
		$losses			= $record_array['losses'];
		$record			= $wins.'-'.$losses;
		if(($type == 'F' && $i == 2) || ($type != 'F' && $i == 3)){
			$games = $record_array['games'];
		}
		$pct = ($wins + $losses > 0 ? number_format($wins / ($wins + $losses), 3) : '0.000');
?>
		<tr>
			<td width="152" class="chartL7"><?php echo $category; ?></td>
			<td width="94" class="chartR3B"><?php echo $record; ?></td>
			<td width="94" class="chartR3B"><?php echo $pct; ?></td>
		</tr>
<?php
	}
?>
		<tr><td colspan="3" class="chartHeaderL">STAFF:</td></tr>
<?php
	$sql = 'SELECT name, type AS staff_type
			FROM officials
			WHERE teamRef='.$teamRef.'
			ORDER BY type';
	$staff_obj = $db->db_query($sql);
	while(!$staff_obj->eof){
		$name = $staff_obj->field['name'];
		$staff_type = $staff_obj->field['staff_type'];
		
		$title = set_staff_title($staff_type);
		if($staff_type < 3){
			$name = '<b>'.$name.'</b>';
		}
?>
		<tr>
			<td width="152" class="chartL7"><?php echo $title; ?></td>
			<td colspan="2" class="chartR"><?php echo $name; ?></td>
		</tr>
<?php
		$staff_obj->move_next();
	}
?>
		<tr><td colspan="3" height="10" class="divider2"></td></tr>
		</table>
		<!-- eof team info -->
		
		<!-- bof team stats -->
<?php
	$team_stats = array();
	for($i = 0; $i < 2; $i++){
		$condition = ($i == 0 ? '=' : '!=');
		if($type == 'A'){
			$param = 'p.teamRef'.$condition.$teamRef.' 
					  AND final!=\'F\' 
					  AND (g.usTeamRef='.$teamRef.' OR g.themTeamRef='.$teamRef.')';
		}else{
			$param = 'p.teamRef'.$condition.$teamRef.' 
					  AND g.seasonType=\''.$type.'\' 
					  AND final!=\'F\' 
					  AND (g.usTeamRef='.$teamRef.' OR g.themTeamRef='.$teamRef.')';
		}
		//get goals, assists and man-up/down
		$goals_obj = get_team_goals_summary($param);
		$tot_goals		= $goals_obj->field['tot_goals'];
		$goals_q1		= $goals_obj->field['goals_q1'];
		$goals_q2		= $goals_obj->field['goals_q2'];
		$goals_q3		= $goals_obj->field['goals_q3'];
		$goals_q4		= $goals_obj->field['goals_q4'];
		$goals_ot		= $goals_obj->field['goals_ot'];
		$assists_q1		= $goals_obj->field['assists_q1'];
		$assists_q2		= $goals_obj->field['assists_q2'];
		$assists_q3		= $goals_obj->field['assists_q3'];
		$assists_q4		= $goals_obj->field['assists_q4'];
		$assists_ot		= $goals_obj->field['assists_ot'];
		$unassisted		= $goals_obj->field['unassisted'];
		$assisted		= $goals_obj->field['assisted'];
		$man_up			= $goals_obj->field['man_up'];
		$man_down		= $goals_obj->field['man_down'];
		$goal_avg 		= ($games > 0 ? number_format($tot_goals / $games, 1) : '0.0');
		
		//get man-up opportunities
		$opportunities = get_manUp_opps_summary($param);
				
		//get shots and gb
		$plays_obj = get_team_plays_summary($param);
		$shots_q1 = $plays_obj->field['shots_q1'];
		$shots_q2 = $plays_obj->field['shots_q2'];
		$shots_q3 = $plays_obj->field['shots_q3'];
		$shots_q4 = $plays_obj->field['shots_q4'];
		$shots_ot = $plays_obj->field['shots_ot'];
		$tot_shots = $plays_obj->field['tot_shots'];
		$shot_avg = ($games > 0 ? number_format($tot_shots / $games, 1) : '0.0');
		$gb = $plays_obj->field['gb'];
		
		//get shot percentage
		$shotPct_q1 = ($shots_q1 > 0 ? number_format($goals_q1 / $shots_q1, 3) : '0.000');
		$shotPct_q2 = ($shots_q2 > 0 ? number_format($goals_q2 / $shots_q2, 3) : '0.000');
		$shotPct_q3 = ($shots_q3 > 0 ? number_format($goals_q3 / $shots_q3, 3) : '0.000');
		$shotPct_q4 = ($shots_q4 > 0 ? number_format($goals_q4 / $shots_q4, 3) : '0.000');
		$shotPct_ot = ($shots_ot > 0 ? number_format($goals_ot / $shots_ot, 3) : '0.000');
		$shotPct = ($tot_shots > 0 ? number_format($tot_goals / $tot_shots, 3) : '0.000');
		
		//get assist percentage
		$assistPct_q1 = ($goals_q1 > 0 ? number_format($assists_q1 / $goals_q1, 3) : '0.000');
		$assistPct_q2 = ($goals_q2 > 0 ? number_format($assists_q2 / $goals_q2, 3) : '0.000');
		$assistPct_q3 = ($goals_q3 > 0 ? number_format($assists_q3 / $goals_q3, 3) : '0.000');
		$assistPct_q4 = ($goals_q4 > 0 ? number_format($assists_q4 / $goals_q4, 3) : '0.000');
		$assistPct_ot = ($goals_ot > 0 ? number_format($assists_ot / $goals_ot, 3) : '0.000');
		$assistPct = ($tot_goals > 0 ? number_format($assisted / $tot_goals, 3) : '0.000');
		
		//get faceoffs
		$faceoffs_obj = get_team_faceoffs_summary($param);
		$fo_won = $faceoffs_obj->field['won'];
		$fo_lost = $faceoffs_obj->field['lost'];
		$total_fo = $fo_won + $fo_lost;
		$foPct = ($total_fo > 0 ? number_format($fo_won / $total_fo, 3) : '0.000');
		
		//get clears
		$clears_obj = get_team_clears_summary($param);
		$cleared = $clears_obj->field['cleared'];
		$failed = $clears_obj->field['failed'];
		$total_clears = $cleared + $failed;
		$clearPct = ($total_clears > 0 ? number_format($cleared / $total_clears, 3) : '0.000');
		
		//get penaltys
		$penalties_obj = get_team_penalties_summary($param);
		$penalties = $penalties_obj->field['penalties'];
		$minutes = $penalties_obj->field['minutes'];
		
		//get saves and goals allowed
		$saves_obj = get_team_saves_summary($param);
		$saves_q1 = $saves_obj->field['saves_q1'];
		$saves_q2 = $saves_obj->field['saves_q2'];
		$saves_q3 = $saves_obj->field['saves_q3'];
		$saves_q4 = $saves_obj->field['saves_q4'];
		$saves_ot = $saves_obj->field['saves_ot'];
		$tot_saves = $saves_obj->field['tot_saves'];
		$ga_q1 = $saves_obj->field['ga_q1'];
		$ga_q2 = $saves_obj->field['ga_q2'];
		$ga_q3 = $saves_obj->field['ga_q3'];
		$ga_q4 = $saves_obj->field['ga_q4'];
		$ga_ot = $saves_obj->field['ga_ot'];
		$tot_ga = $saves_obj->field['tot_ga'];
		
		$team_stats[$i] = array('tot_goals' => $tot_goals,
							  'goals_q1' => $goals_q1,
							  'goals_q2' => $goals_q2,
							  'goals_q3' => $goals_q3,
							  'goals_q4' => $goals_q4,
							  'goals_ot' => $goals_ot,
							  'assists_q1' => $assists_q1,
							  'assists_q2' => $assists_q2,
							  'assists_q3' => $assists_q3,
							  'assists_q4' => $assists_q4,
							  'assists_ot' => $assists_ot,
							  'goal_avg' => $goal_avg,
							  'assisted' => $assisted,
							  'unassisted' => $unassisted,
							  'man_up' => $man_up,
							  'man_down' => $man_down,
							  'opportunities' => $opportunities,
							  'shots_q1' => $shots_q1,
							  'shots_q2' => $shots_q2,
							  'shots_q3' => $shots_q3,
							  'shots_q4' => $shots_q4,
							  'shots_ot' => $shots_ot,
							  'tot_shots' => $tot_shots,
							  'shot_avg' => $shot_avg,
							  'shotPct_q1' => $shotPct_q1,
							  'shotPct_q2' => $shotPct_q2,
							  'shotPct_q3' => $shotPct_q3,
							  'shotPct_q4' => $shotPct_q4,
							  'shotPct_ot' => $shotPct_ot,
							  'shotPct' => $shotPct,
							  'assistPct_q1' => $assistPct_q1,
							  'assistPct_q2' => $assistPct_q2,
							  'assistPct_q3' => $assistPct_q3,
							  'assistPct_q4' => $assistPct_q4,
							  'assistPct_ot' => $assistPct_ot,
							  'assistPct' => $assistPct,
							  'gb' => $gb,
							  'fo_won' => $fo_won,
							  'fo_lost' => $fo_lost,
							  'foPct' => $foPct,
							  'cleared' => $cleared,
							  'failed' => $failed,
							  'clearPct' => $clearPct,
							  'saves_q1' => $saves_q1,
							  'saves_q2' => $saves_q2,
							  'saves_q3' => $saves_q3,
							  'saves_q4' => $saves_q4,
							  'saves_ot' => $saves_ot,
							  'tot_saves' => $tot_saves,
							  'ga_q1' => $ga_q1,
							  'ga_q2' => $ga_q2,
							  'ga_q3' => $ga_q3,
							  'ga_q4' => $ga_q4,
							  'ga_ot' => $ga_ot,
							  'tot_ga' => $tot_ga,
							  'penalties' => $penalties,
							  'minutes' => $minutes
							  );
	}
	//compute shots on goal
	$team_stats[0]['sog_q1'] = $team_stats[1]['saves_q1'] + $team_stats[1]['ga_q1'];
	$team_stats[0]['sog_q2'] = $team_stats[1]['saves_q2'] + $team_stats[1]['ga_q2'];
	$team_stats[0]['sog_q3'] = $team_stats[1]['saves_q3'] + $team_stats[1]['ga_q3'];
	$team_stats[0]['sog_q4'] = $team_stats[1]['saves_q4'] + $team_stats[1]['ga_q4'];
	$team_stats[0]['sog_ot'] = $team_stats[1]['saves_ot'] + $team_stats[1]['ga_ot'];
	$team_stats[0]['tot_sog'] = $team_stats[1]['tot_saves'] + $team_stats[1]['tot_ga'];
	$team_stats[1]['sog_q1'] = $team_stats[0]['saves_q1'] + $team_stats[0]['ga_q1'];
	$team_stats[1]['sog_q2'] = $team_stats[0]['saves_q2'] + $team_stats[0]['ga_q2'];
	$team_stats[1]['sog_q3'] = $team_stats[0]['saves_q3'] + $team_stats[0]['ga_q3'];
	$team_stats[1]['sog_q4'] = $team_stats[0]['saves_q4'] + $team_stats[0]['ga_q4'];
	$team_stats[1]['sog_ot'] = $team_stats[0]['saves_ot'] + $team_stats[0]['ga_ot'];
	$team_stats[1]['tot_sog'] = $team_stats[0]['tot_saves'] + $team_stats[0]['tot_ga'];

	//compute sog percentage
	$team_stats[0]['sogPct_q1'] = ($team_stats[0]['shots_q1'] > 0 ? number_format($team_stats[0]['sog_q1'] / $team_stats[0]['shots_q1'], 3) : '0.000');
	$team_stats[0]['sogPct_q2'] = ($team_stats[0]['shots_q2'] > 0 ? number_format($team_stats[0]['sog_q2'] / $team_stats[0]['shots_q2'], 3) : '0.000');
	$team_stats[0]['sogPct_q3'] = ($team_stats[0]['shots_q3'] > 0 ? number_format($team_stats[0]['sog_q3'] / $team_stats[0]['shots_q3'], 3) : '0.000');
	$team_stats[0]['sogPct_q4'] = ($team_stats[0]['shots_q4'] > 0 ? number_format($team_stats[0]['sog_q4'] / $team_stats[0]['shots_q4'], 3) : '0.000');
	$team_stats[0]['sogPct_ot'] = ($team_stats[0]['shots_ot'] > 0 ? number_format($team_stats[0]['sog_ot'] / $team_stats[0]['shots_ot'], 3) : '0.000');
	$team_stats[0]['sogPct'] = ($team_stats[0]['tot_shots'] > 0 ? number_format($team_stats[0]['tot_sog'] / $team_stats[0]['tot_shots'], 3) : '0.000');
	$team_stats[1]['sogPct_q1'] = ($team_stats[1]['shots_q1'] > 0 ? number_format($team_stats[1]['sog_q1'] / $team_stats[1]['shots_q1'], 3) : '0.000');
	$team_stats[1]['sogPct_q2'] = ($team_stats[1]['shots_q2'] > 0 ? number_format($team_stats[1]['sog_q2'] / $team_stats[1]['shots_q2'], 3) : '0.000');
	$team_stats[1]['sogPct_q3'] = ($team_stats[1]['shots_q3'] > 0 ? number_format($team_stats[1]['sog_q3'] / $team_stats[1]['shots_q3'], 3) : '0.000');
	$team_stats[1]['sogPct_q4'] = ($team_stats[1]['shots_q4'] > 0 ? number_format($team_stats[1]['sog_q4'] / $team_stats[1]['shots_q4'], 3) : '0.000');
	$team_stats[1]['sogPct_ot'] = ($team_stats[1]['shots_ot'] > 0 ? number_format($team_stats[1]['sog_ot'] / $team_stats[1]['shots_ot'], 3) : '0.000');
	$team_stats[1]['sogPct'] = ($team_stats[1]['tot_shots'] > 0 ? number_format($team_stats[1]['tot_sog'] / $team_stats[1]['tot_shots'], 3) : '0.000');
	
	//compute man-up conversion percentage
	$team_stats[0]['man_up_pct'] = ($team_stats[1]['opportunities'] > 0 ? number_format($team_stats[0]['man_up'] / $team_stats[1]['opportunities'], 3) : '0.000');
	$team_stats[1]['man_up_pct'] = ($team_stats[0]['opportunities'] > 0 ? number_format($team_stats[1]['man_up'] / $team_stats[0]['opportunities'], 3) : '0.000');
?>
		<!-- bof team summary -->
		<table border="0" cellspacing="0" cellpadding="0" width="365">
		<tr><td colspan="3" class="chartTitleTC">TEAM STATISTICS</td></tr>
		<tr>
			<td width="159" class="chartHeaderL">SHOT STATISTICS:</td>
			<td width="94" class="chartHeaderR"><?php echo $teamShort; ?></td>
			<td width="94" class="chartHeaderR">OPP</td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Goals-Shot Attempts:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['tot_goals'].'-'.$team_stats[0]['tot_shots']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['tot_goals'].'-'.$team_stats[1]['tot_shots']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Goals Scored Average:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['goal_avg']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['goal_avg']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Shot percent:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['shotPct']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['shotPct']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Shots per Game:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['shot_avg']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['shot_avg']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Assists:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['assisted']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['assisted']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Assist percent:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['assistPct']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['assistPct']; ?></td>
		</tr>
		<tr>
			<td width="159" class="chartHeaderL">MAN-UP OPPORTUNITIES:</td>
			<td width="94" class="chartHeaderR"></td>
			<td width="94" class="chartHeaderR"></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Goals-Opportunities:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['man_up'].'-'.$team_stats[1]['opportunities']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['man_up'].'-'.$team_stats[0]['opportunities']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Conversion percent:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['man_up_pct']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['man_up_pct']; ?></td>
		</tr>
		<tr>
			<td width="159" class="chartHeaderL">GOAL BREAKDOWN:</td>
			<td width="94" class="chartHeaderR"></td>
			<td width="94" class="chartHeaderR"></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Total goals:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['tot_goals']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['tot_goals']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Assisted:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['assisted']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['assisted']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Unassisted:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['unassisted']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['unassisted']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Man-up:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['man_up']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['man_up']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Man-down:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['man_down']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['man_down']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Overtime:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['goals_ot']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['goals_ot']; ?></td>
		</tr>
		<tr>
			<td width="159" class="chartHeaderL">GROUND BALLS:</td>
			<td width="94" class="chartHeaderR"></td>
			<td width="94" class="chartHeaderR"></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Ground balls:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['gb']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['gb']; ?></td>
		</tr>
		<tr>
			<td width="159" class="chartHeaderL">FACE-OFFS:</td>
			<td width="94" class="chartHeaderR"></td>
			<td width="94" class="chartHeaderR"></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Won-Lost:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['fo_won'].'-'.$team_stats[0]['fo_lost']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['fo_won'].'-'.$team_stats[1]['fo_lost']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Percent:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['foPct']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['foPct']; ?></td>
		</tr>
		<tr>
			<td width="159" class="chartHeaderL">CLEARS:</td>
			<td width="94" class="chartHeaderR"></td>
			<td width="94" class="chartHeaderR"></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Cleared-Failed:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['cleared'].'-'.$team_stats[0]['failed']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['cleared'].'-'.$team_stats[1]['failed']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Percent:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['clearPct']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['clearPct']; ?></td>
		</tr>
		<tr>
			<td width="159" class="chartHeaderL">PENALTIES:</td>
			<td width="94" class="chartHeaderR"></td>
			<td width="94" class="chartHeaderR"></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Penalties:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['penalties']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['penalties']; ?></td>
		</tr>
		<tr>
			<td width="152" class="chartL7">Minutes:</td>
			<td width="94" class="chartR2"><?php echo $team_stats[0]['minutes']; ?></td>
			<td width="94" class="chartR2"><?php echo $team_stats[1]['minutes']; ?></td>
		</tr>
		</table>
		<!-- eof team summary -->
		
		<!-- bof plays by period -->
	<table border="0" cellspacing="0" cellpadding="0" width="365">
	<tr><td colspan="15" height="10" class="divider2"></td></tr>
	<tr><td colspan="15" class="chartTitleTC">PLAYS BY PERIOD</td></tr>
	<tr><td colspan="15" class="chartTitle2">GOALS</td></tr>
	<tr>
		<td width="1" class="divider4"></td>
		<td width="117" class="chartHeaderL"></td>
		<td width="1" class="divider"></td>
		<td width="33" class="chartHeaderC">1</td>
		<td width="1" class="divider"></td>
		<td width="33" class="chartHeaderC">2</td>
		<td width="1" class="divider"></td>
		<td width="33" class="chartHeaderC">3</td>
		<td width="1" class="divider"></td>
		<td width="33" class="chartHeaderC">4</td>
		<td width="1" class="divider"></td>
		<td width="33" class="chartHeaderC">OT</td>
		<td width="1" class="divider"></td>
		<td width="33" class="chartHeaderC"><b>T</b></td>
		<td width="1" class="divider4"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL"><?php echo $town; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['goals_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['goals_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['goals_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['goals_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['goals_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[0]['tot_goals']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL">Opponents</td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['goals_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['goals_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['goals_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['goals_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['goals_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[1]['tot_goals']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr><td colspan="15" height="10" class="divider2"></td></tr>
	<tr><td colspan="15" class="chartTitle2">SHOTS</td></tr>
	<tr>
		<td class="divider4"></td>
		<td class="chartHeaderL"></td>
		<td class="divider"></td>
		<td class="chartHeaderC">1</td>
		<td class="divider"></td>
		<td class="chartHeaderC">2</td>
		<td class="divider"></td>
		<td class="chartHeaderC">3</td>
		<td class="divider"></td>
		<td class="chartHeaderC">4</td>
		<td class="divider"></td>
		<td class="chartHeaderC">OT</td>
		<td class="divider"></td>
		<td class="chartHeaderC"><b>T</b></td>
		<td class="divider4"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL"><?php echo $town; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['shots_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['shots_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['shots_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['shots_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['shots_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[0]['tot_shots']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL">Opponents</td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['shots_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['shots_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['shots_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['shots_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['shots_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[1]['tot_shots']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr><td colspan="15" height="10" class="divider2"></td></tr>
	<tr><td colspan="15" class="chartTitle2">SHOT PCT</td></tr>
	<tr>
		<td class="divider4"></td>
		<td class="chartHeaderL"></td>
		<td class="divider"></td>
		<td class="chartHeaderC">1</td>
		<td class="divider"></td>
		<td class="chartHeaderC">2</td>
		<td class="divider"></td>
		<td class="chartHeaderC">3</td>
		<td class="divider"></td>
		<td class="chartHeaderC">4</td>
		<td class="divider"></td>
		<td class="chartHeaderC">OT</td>
		<td class="divider"></td>
		<td class="chartHeaderC"><b>T</b></td>
		<td class="divider4"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL"><?php echo $town; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['shotPct_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['shotPct_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['shotPct_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['shotPct_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['shotPct_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[0]['shotPct']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL">Opponents</td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['shotPct_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['shotPct_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['shotPct_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['shotPct_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['shotPct_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[1]['shotPct']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr><td colspan="15" height="10" class="divider2"></td></tr>
	<tr><td colspan="15" class="chartTitle2">SHOTS ON GOAL</td></tr>
	<tr>
		<td class="divider4"></td>
		<td class="chartHeaderL"></td>
		<td class="divider"></td>
		<td class="chartHeaderC">1</td>
		<td class="divider"></td>
		<td class="chartHeaderC">2</td>
		<td class="divider"></td>
		<td class="chartHeaderC">3</td>
		<td class="divider"></td>
		<td class="chartHeaderC">4</td>
		<td class="divider"></td>
		<td class="chartHeaderC">OT</td>
		<td class="divider"></td>
		<td class="chartHeaderC"><b>T</b></td>
		<td class="divider4"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL"><?php echo $town; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['sog_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['sog_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['sog_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['sog_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['sog_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[0]['tot_sog']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL">Opponents</td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['sog_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['sog_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['sog_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['sog_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['sog_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[1]['tot_sog']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr><td colspan="15" height="10" class="divider2"></td></tr>
	<tr><td colspan="15" class="chartTitle2">SOG PCT</td></tr>
	<tr>
		<td class="divider4"></td>
		<td class="chartHeaderL"></td>
		<td class="divider"></td>
		<td class="chartHeaderC">1</td>
		<td class="divider"></td>
		<td class="chartHeaderC">2</td>
		<td class="divider"></td>
		<td class="chartHeaderC">3</td>
		<td class="divider"></td>
		<td class="chartHeaderC">4</td>
		<td class="divider"></td>
		<td class="chartHeaderC">OT</td>
		<td class="divider"></td>
		<td class="chartHeaderC"><b>T</b></td>
		<td class="divider4"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL"><?php echo $town; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['sogPct_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['sogPct_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['sogPct_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['sogPct_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['sogPct_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[0]['sogPct']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL">Opponents</td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['sogPct_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['sogPct_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['sogPct_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['sogPct_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['sogPct_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[1]['sogPct']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr><td colspan="15" height="10" class="divider2"></td></tr>
	<tr><td colspan="15" class="chartTitle2">ASSIST PCT</td></tr>
	<tr>
		<td class="divider4"></td>
		<td class="chartHeaderL"></td>
		<td class="divider"></td>
		<td class="chartHeaderC">1</td>
		<td class="divider"></td>
		<td class="chartHeaderC">2</td>
		<td class="divider"></td>
		<td class="chartHeaderC">3</td>
		<td class="divider"></td>
		<td class="chartHeaderC">4</td>
		<td class="divider"></td>
		<td class="chartHeaderC">OT</td>
		<td class="divider"></td>
		<td class="chartHeaderC"><b>T</b></td>
		<td class="divider4"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL"><?php echo $town; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['assistPct_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['assistPct_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['assistPct_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['assistPct_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['assistPct_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[0]['assistPct']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL">Opponents</td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['assistPct_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['assistPct_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['assistPct_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['assistPct_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['assistPct_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[1]['assistPct']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr><td colspan="15" height="10" class="divider2"></td></tr>
	<tr><td colspan="15" class="chartTitle2">SAVES</td></tr>
	<tr>
		<td class="divider4"></td>
		<td class="chartHeaderL"></td>
		<td class="divider"></td>
		<td class="chartHeaderC">1</td>
		<td class="divider"></td>
		<td class="chartHeaderC">2</td>
		<td class="divider"></td>
		<td class="chartHeaderC">3</td>
		<td class="divider"></td>
		<td class="chartHeaderC">4</td>
		<td class="divider"></td>
		<td class="chartHeaderC">OT</td>
		<td class="divider"></td>
		<td class="chartHeaderC"><b>T</b></td>
		<td class="divider4"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL"><?php echo $town; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['saves_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['saves_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['saves_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['saves_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[0]['saves_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[0]['tot_saves']; ?></b></td>
		<td class="divider"></td>
	</tr>
	<tr>
		<td class="divider"></td>
		<td class="chartL">Opponents</td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['saves_q1']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['saves_q2']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['saves_q3']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['saves_q4']; ?></td>
		<td class="divider"></td>
		<td class="chartC3"><?php echo $team_stats[1]['saves_ot']; ?></td>
		<td class="divider"></td>
		<td class="chartC"><b><?php echo $team_stats[1]['tot_saves']; ?></b></td>
		<td class="divider"></td>
	</tr>
	</table>
		<!-- eof plays by period -->
		<!-- eof team statistics -->
	</div>
	<!-- EOF LEFT COLUMN -->
	</div>
<?php
}else{
	if($type == 'T'){
?>
	<div id="pageTitle">No post season games found for <?php echo $season; ?>.</div>
<?php
	}else{
?>
	<div id="pageTitle">No regular season games found for <?php echo $season; ?>.</div>
<?php
	}
}
?>
