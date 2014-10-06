<?php
require('includes/modules/teams/header.php');
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="720">
<?php
for($i = 0; $i < 2; $i++){
	$tot_score_us = 0;
	$tot_score_them = 0;
	$tot_goals = 0;
	$tot_assists = 0;
	$tot_points = 0;
	$tot_shots = 0;
	$tot_unassisted = 0;
	$tot_man_up = 0;
	$tot_man_down = 0;
	$tot_gb = 0;
	$tot_fo_won = 0;
	$tot_fo_lost = 0;
	$tot_penalties = 0;
	$tot_minutes = 0;
	
	if($i == 0){
?>
		<tr><td colspan="35" class="chartTitleL">Regular Season Schedule</td>
<?php
	}else{
?>
		<tr><td height="10" colspan="35" class="divider2"></td></tr>
		<tr><td colspan="35" class="chartTitleL">Post Season Schedule</td>
<?php
	}
?>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="43" class="chartHeaderL">date</td>
			<td width="1" class="divider"></td>
			<td width="128" class="chartHeaderL">opponent</td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartHeaderC">results</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">g</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">a</td>
			<td width="1" class="divider"></td>
			<td width="26" class="chartHeaderC">pt</td>
			<td width="1" class="divider"></td>
			<td width="26" class="chartHeaderC">sh</td>
			<td width="1" class="divider"></td>
			<td width="38" class="chartHeaderC">sh pct</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">un</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">up</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">dn</td>
			<td width="1" class="divider"></td>
			<td width="26" class="chartHeaderC">gb</td>
			<td width="1" class="divider"></td>
			<td width="48" class="chartHeaderC">fo W-L</td>
			<td width="1" class="divider"></td>
			<td width="38" class="chartHeaderC">FO Pct</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">Pen</td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php	
	$row = 0;
	$param = ($i == 0 ? "g.seasonType='F'" : "g.seasonType!='F'" );
	$games = get_games($teamRef, $param);
	while(!$games->eof){
		//get game data
		$gameRef		= $games->field['gameRef'];
		$date			= $games->field['date'];
		$startTime		= $games->field['startTime'];
		$fieldRef		= $games->field['fieldRef'];
		$usTeamRef		= $games->field['usTeamRef'];
		$themTeamRef	= $games->field['themTeamRef'];
		$away			= $games->field['away'];
		$seasonType		= $games->field['seasonType'];
		$final			= $games->field['final'];
		$created		= $games->field['created'];
		$modified		= $games->field['modified'];
		$opponent		= $games->field['town'];
		$opponent_tmr	= $games->field['teamMasterRef'];
		$opponent_tr	= $games->field['teamRef'];
		$field			= $games->field['field'];
		
		$date_str = date('M j', strtotime($date));
		$background = set_background($row);
		$param			= '&tmr='.$opponent_tmr.'&tr='.$opponent_tr.'&s='.$season.'&ty='.$seasonType;
		$href_opponent	= set_href(FILENAME_TEAM_STATS, $param);
		if($final != 'F'){
			//get score
			$score_us = 0;
			$score_them = 0;
			$scores->move();
			while(!$scores->eof){
				if($scores->field['gameRef'] == $gameRef){
					$score_us = $scores->field['score_us'];
					$score_them = $scores->field['score_them'];
					break;
				}
				$scores->move_next();
			}
			//get goal stats
			$goals = 0;
			$assists = 0;
			$unassisted = 0;
			$man_up = 0;
			$man_down = 0;
			$goals_obj->move();
			while(!$goals_obj->eof){
				if($goals_obj->field['gameRef'] == $gameRef){
					$goals		= $goals_obj->field['goals'];
					$assists	= $goals_obj->field['assists'];
					$unassisted	= $goals_obj->field['unassisted'];
					$man_up		= $goals_obj->field['man_up'];
					$man_down	= $goals_obj->field['man_down'];
					break;
				}
				$goals_obj->move_next();
			}
			$points = $goals + $assists;
			//get shot stats
			$shots = 0;
			$gb = 0;
			$plays->move();
			while(!$plays->eof){
				if($plays->field['gameRef'] == $gameRef){
					$shots	= $plays->field['shots'];
					$gb		= $plays->field['gb'];
					break;
				}
				$plays->move_next();
			}
			//get faceoff stats
			$fo_won = 0;
			$fo_lost = 0;
			$faceoffs->move();
			while(!$faceoffs->eof){
				if($faceoffs->field['gameRef'] == $gameRef){
					$fo_won = $faceoffs->field['fo_won'];
					$fo_lost = $faceoffs->field['fo_lost'];
					break;
				}
				$faceoffs->move_next();
			}
			//get penalty stats
			$penalties = 0;
			$minutes = 0;
			$penalty_obj->move();
			while(!$penalty_obj->eof){
				if($penalty_obj->field['gameRef'] == $gameRef){
					$penalties = $penalty_obj->field['penalties'];
					$minutes = $penalty_obj->field['minutes'];
					break;
				}
				$penalty_obj->move_next();
			}
			//update_totals
			$tot_score_us		+= $score_us;
			$tot_score_them		+= $score_them;
			$tot_goals			+= $goals;
			$tot_assists		+= $assists;
			$tot_shots			+= $shots;
			$tot_points			+= $points;
			$tot_unassisted		+= $unassisted;
			$tot_man_up			+= $man_up;
			$tot_man_down		+= $man_down;
			$tot_gb				+= $gb;
			$tot_fo_won			+= $fo_won;
			$tot_fo_lost		+= $fo_lost;
			$tot_penalties		+= $penalties;
			$tot_minutes		+= $minutes;
			//process data
			$score			= $score_us.'-'.$score_them;
			$win_tag		= ($score_us > $score_them ? 'W' : '');
			$loss_tag		= ($score_them > $score_us ? 'L' : '');
			$shotPct		= ($shots > 0 ? number_format($goals / $shots, 3) : '0.000');
			$fo				= $fo_won + $fo_lost;
			$fo_str			= $fo_won.'-'.$fo_lost;
			$foPct			= ($fo > 0 ? number_format($fo_won / $fo, 3) : '0.000');
			$minutes		= number_format($minutes, 1);
			$param			= '&gr='.$gameRef.'&utr='.$teamRef;
			$href_box_score	= set_href(FILENAME_BOX_SCORE, $param);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="43" class="chartL"><?php echo $date_str; ?></td>
			<td width="1" class="divider"></td>
<?php
			if($opponent == $field){
?>
			<td width="128" class="chartL">at <a href="<?php echo $href_opponent; ?>"><?php echo $opponent; ?></a></td>
<?php
			}elseif($town == $field){
?>
			<td width="128" class="chartL"><a href="<?php echo $href_opponent; ?>"><?php echo $opponent; ?></a></td>
<?php
			}else{
?>
			<td width="128" class="chartL">vs <a href="<?php echo $href_opponent; ?>"><?php echo $opponent; ?></a></td>
<?php
			}
?>
			<td width="1" class="divider"></td>
			<td width="13" class="chartC"><?php echo $win_tag; ?></td>
			<td width="30" class="chartC"><a href="<?php echo $href_box_score; ?>"><?php echo $score; ?></a></td>
			<td width="13" class="chartC"><?php echo $loss_tag; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC3"><?php echo $goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC3"><?php echo $assists; ?></td>
			<td width="1" class="divider"></td>
			<td width="26" class="chartC3"><?php echo $points; ?></td>
			<td width="1" class="divider"></td>
			<td width="26" class="chartC3"><?php echo $shots; ?></td>
			<td width="1" class="divider"></td>
			<td width="38" class="chartC3"><?php echo $shotPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC3"><?php echo $unassisted; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC3"><?php echo $man_up; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC3"><?php echo $man_down; ?></td>
			<td width="1" class="divider"></td>
			<td width="26" class="chartC3"><?php echo $gb; ?></td>
			<td width="1" class="divider"></td>
			<td width="48" class="chartC3"><?php echo $fo_str; ?></td>
			<td width="1" class="divider"></td>
			<td width="38" class="chartC3"><?php echo $foPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC3"><?php echo $penalties; ?></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC3"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		}else{
			$timeStr = date('g:i a', mktime(substr($startTime, 0, 2), substr($startTime, 3, 2), substr($startTime, 6, 2), 1, 1, 2000));
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="43" class="chartL"><?php echo $date_str; ?></td>
			<td width="1" class="divider"></td>
<?php
			if($themTeamRef == $teamRef){
?>
			<td width="128" class="chartL">at <a href="<?php echo $href_opponent; ?>"><?php echo $opponent; ?></a></td>
<?php
			}else{
?>
			<td width="128" class="chartL"><a href="<?php echo $href_opponent; ?>"><?php echo $opponent; ?></a></td>
<?php
			}
?>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartC"><?php echo $timeStr; ?></td>
			<td width="1" class="divider"></td>
<?php
					//notify public of recent change
			$now = date('YmdHis');
			$fiveDaysAgo = $now - (60 * 60 * 24 * 5);
			if(($modified > $created) && ($modified > $fiveDaysAgo) && ($modified < $now)){
?>
			<td colspan="25" class="chartL3">New information!</td>
<?php
			}else{
?>
			<td colspan="25" class="chartC3"></td>
<?php
			}
?>
			<td width="1" class="divider"></td>
		</tr>
<?php
		}
		$row++;
		$games->move_next();
	}
	$shotPct		= ($tot_shots > 0 ? number_format($tot_goals / $tot_shots, 3) : '0.000');
	$fo_str			= $tot_fo_won.'-'.$tot_fo_lost;
	$fo				= $tot_fo_won + $tot_fo_lost;
	$foPct			= ($fo > 0 ? number_format($tot_fo_won / $fo, 3) : '0.000');
	$tot_minutes	= number_format($tot_minutes, 1);
?>
		<tr>
			<td class="divider"></td>
			<td colspan="7" class="chartL"><b>Totals</b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $shotPct; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $tot_unassisted; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $tot_man_up; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $tot_man_down; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $fo_str; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $foPct; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td class="divider"></td>
			<td class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td class="divider"></td>
		</tr>
<?php
}
?>
		</table>
		<p class="chartL"><b>LEGEND:</b><br><b>PL:</b> Played; <b>ST:</b> Started; <b>G:</b> Goals; <b>A:</b> Assists; <b>PT:</b> Points; <b>SH:</b> Shots; <b>SH PCT:</b> Shot Percentage; <b>UN:</b> Unassisted Goals; <b>UP:</b> Man-up Goals; <b>DN:</b> Man-down Goals; <b>GB:</b> Ground Balls; <b>W-L:</b> Faceoffs Won-Lost; <b>FO PCT:</b> Faceoff Percentage; <b>PEN:</b> Penalties; <b>MIN:</b> Penalty Minutes.</p>
	</div>
	<!-- EOF BODY -->
