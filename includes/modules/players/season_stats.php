	<!-- bof career stats -->
<?php
//retrieve career data by season
$plays = get_career_playing_stats($playerMasterRef);
$goals_obj = get_career_goal_stats($playerMasterRef);
$penalties_obj = get_career_penalty_stats($playerMasterRef);
$faceoffs = get_career_faceoff_stats($playerMasterRef);
$saves_obj = get_career_goalie_stats($playerMasterRef);

//set chart type
if(isset($faceoffs->result) && count($faceoffs->result) > 0){
	$chart_type = 'F';
}elseif(isset($saves_obj->result) && count($saves_obj->result) > 0){
	$chart_type = 'G';
}else{
	$chart_type = 'R';
}

//print chart header
switch($chart_type){
	case 'G':
		if($season_detail){
			?>
	<div class="body_container_goalie_detail">
		<table border="0" cellspacing="0" cellpadding="0" width="680">
		<tr><td colspan="37" class="chartTitleL">career statistics</td></tr>
		<tr>
			<td colspan="2" class="chartTitle2"></td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartTitle2">games</td>
			<td width="1" class="divider"></td>
			<td colspan="17" class="chartTitle2">offense</td>
			<td width="1" class="divider"></td>
			<td colspan="7" class="chartTitle2">saves</td>
			<td width="1" class="divider"></td>
			<td colspan="4" class="chartTitle2">penalties</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="52" class="chartHeaderC">season</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">pl</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">st</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">g</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">a</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">pt</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">sh</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">sh pct</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">un</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">up</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">dn</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">gb</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">s</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">ga</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">ga avg</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">pct</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Pen</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
			<?php
		}else{
			?>
	<div class="body_container_goalie_summary">
		<table border="0" cellspacing="0" cellpadding="0" width="620">
		<tr><td colspan="31" class="chartTitleL">overview</td></tr>
		<tr>
			<td colspan="2" class="chartTitle2"></td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartTitle2">games</td>
			<td width="1" class="divider"></td>
			<td colspan="11" class="chartTitle2">offense</td>
			<td width="1" class="divider"></td>
			<td colspan="7" class="chartTitle2">saves</td>
			<td width="1" class="divider"></td>
			<td colspan="4" class="chartTitle2">penalties</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="52" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">pl</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">st</td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartHeaderC">g</td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartHeaderC">a</td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartHeaderC">pt</td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartHeaderC">sh</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">sh pct</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">gb</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">s</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">ga</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">ga avg</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">pct</td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartHeaderC">Pen</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
			<?php
		}
		break;
	case 'F':
		if($season_detail){
			?>
	<div class="body_container_faceoff_detail">
		<table border="0" cellspacing="0" cellpadding="0" width="690">
		<tr><td colspan="33" class="chartTitleL">career statistics</td></tr>
		<tr>
			<td colspan="2" class="chartTitle2"></td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartTitle2">games</td>
			<td width="1" class="divider"></td>
			<td colspan="17" class="chartTitle2">offense</td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartTitle2">faceoffs</td>
			<td width="1" class="divider"></td>
			<td colspan="4" class="chartTitle2">penalties</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="52" class="chartHeaderC">season</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">pl</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">st</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">g</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">a</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">pt</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">sh</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">sh pct</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">un</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">up</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">dn</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">gb</td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">W-L</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">FO Pct</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Pen</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
			<?php
		}else{
			?>
	<div class="body_container_faceoff_summary">
		<table border="0" cellspacing="0" cellpadding="0" width="610">
		<tr><td colspan="27" class="chartTitleL">overview</td></tr>
		<tr>
			<td colspan="2" class="chartTitle2"></td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartTitle2">games</td>
			<td width="1" class="divider"></td>
			<td colspan="11" class="chartTitle2">offense</td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartTitle2">faceoffs</td>
			<td width="1" class="divider"></td>
			<td colspan="4" class="chartTitle2">penalties</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="92" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">pl</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">st</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">g</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">a</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">pt</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">sh</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">sh pct</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">gb</td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">W-L</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">FO Pct</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Pen</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
			<?php
		}
		break;
	default;
		if($season_detail){
			?>
	<div class="body_container_detail">
		<table border="0" cellspacing="0" cellpadding="0" width="580">
		<tr><td colspan="29" class="chartTitleL">career statistics</td></tr>
		<tr>
			<td colspan="2" class="chartTitle2"></td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartTitle2">games</td>
			<td width="1" class="divider"></td>
			<td colspan="17" class="chartTitle2">offense</td>
			<td width="1" class="divider"></td>
			<td colspan="4" class="chartTitle2">penalties</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="52" class="chartHeaderC">season</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">pl</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">st</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">g</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">a</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">pt</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">sh</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">sh pct</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">un</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">up</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">dn</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">gb</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Pen</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
			<?php
		}else{
			?>
	<div class="body_container_summary">
		<table border="0" cellspacing="0" cellpadding="0" width="510">
		<tr><td colspan="23" class="chartTitleL">overview</td></tr>
		<tr>
			<td colspan="2" class="chartTitle2"></td>
			<td width="1" class="divider"></td>
			<td colspan="3" class="chartTitle2">games</td>
			<td width="1" class="divider"></td>
			<td colspan="11" class="chartTitle2">offense</td>
			<td width="1" class="divider"></td>
			<td colspan="4" class="chartTitle2">penalties</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="112" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">pl</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartHeaderC">st</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">g</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">a</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">pt</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">sh</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">sh pct</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">gb</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Pen</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
			<?php
		}
}

//print season stats
$tot_played = 0;
$tot_started = 0;
$tot_goals = 0;
$tot_assists = 0;
$tot_points = 0;
$tot_shots = 0;
$tot_gb = 0;
$tot_unassisted = 0;
$tot_man_up = 0;
$tot_man_down = 0;
$tot_penalties = 0;
$tot_minutes = 0;
$tot_won = 0;
$tot_lost = 0;
$tot_saved = 0;
$tot_allowed = 0;
$row = 0;
while(!$plays->eof){
	//get play data
	$career_season = $plays->field['season'];
	$played = $plays->field['played'];
	$started = $plays->field['started'];
	$shots = $plays->field['shots'];
	$gb = $plays->field['gb'];
	//get goal data
	$goals = 0;
	$assists = 0;
	$unassisted = 0;
	$man_up = 0;
	$man_down = 0;
	$goals_obj->move();
	while(!$goals_obj->eof){
		if($goals_obj->field['season'] == $career_season){
			$goals = $goals_obj->field['goals'];
			$assists = $goals_obj->field['assists'];
			$unassisted = $goals_obj->field['unassisted'];
			$man_up = $goals_obj->field['man_up'];
			$man_down = $goals_obj->field['man_down'];
			break;
		}
		$goals_obj->move_next();
	}
	$points = $goals + $assists;
	$shotPct = ($shots > 0 ? number_format($goals / $shots, 3) : '0.000');
	//get penalty data
	$penalties = 0;
	$minutes = number_format(0, 1);
	$penalties_obj->move();
	while(!$penalties_obj->eof){
		if($penalties_obj->field['season'] == $career_season){
			$penalties = $penalties_obj->field['penalties'];
			$minutes = $penalties_obj->field['minutes'];
			break;
		}
		$penalties_obj->move_next();
	}
	//update totals
	$tot_played += $played;
	$tot_started += $started;
	$tot_goals += $goals;
	$tot_assists += $assists;
	$tot_points += $points;
	$tot_shots += $shots;
	$tot_gb += $gb;
	$tot_unassisted += $unassisted;
	$tot_man_up += $man_up;
	$tot_man_down += $man_down;
	$tot_penalties += $penalties;
	$tot_minutes += $minutes;
	//process data
	$params = 'pmr='.$playerMasterRef.'&s='.$career_season;
	$href = set_href(FILENAME_PLAYER_STATS, $params);
	$background = set_background($row);
	
	switch($chart_type){
		case 'G':
			//get goalie data
			$saved = 0;
			$allowed = 0;
			$saves_obj->move();
			while(!$saves_obj->eof){
				if($saves_obj->field['season'] == $career_season){
					$saved = $saves_obj->field['saved'];
					$allowed = $saves_obj->field['allowed'];
					break;
				}
				$saves_obj->move_next();
			}
			//process goalie data
			$gaAvg = ($played > 0 ? number_format($allowed / $played, 1) : '0.0');
			$savePct = ($saved + $allowed > 0 ? number_format($saved / ($saved + $allowed), 3) : '0.000');
			$tot_saved += $saved;
			$tot_allowed += $allowed;
			//print data
			if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="52" class="chartC"><a href="<?php echo $href; ?>"><?php echo $career_season; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $played; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $started; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $assists; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $points; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $shots; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $shotPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $unassisted; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $man_up; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $man_down; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $gb; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $saved; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $allowed; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $gaAvg; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $savePct; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $penalties; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
			}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="52" class="chartL"><?php echo $career_season; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $played; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $started ?></td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartC2"><?php echo $goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartC2"><?php echo $assists; ?></td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartC2"><?php echo $points; ?></td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartC2"><?php echo $shots; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $shotPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $gb; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $saved; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $allowed; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $gaAvg; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $savePct; ?></td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartC2"><?php echo $penalties; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
			}
			break;
		case 'F':
			//get faceoff data
			$won = 0;
			$lost = 0;
			$faceoffs->move();
			while(!$faceoffs->eof){
				if($faceoffs->field['season'] == $career_season){
					$won = $faceoffs->field['won'];
					$lost = $faceoffs->field['lost'];
					break;
				}
				$faceoffs->move_next();
			}
			//process faceoff data
			if($won + $lost > 0){
				$fo_record = $won.'-'.$lost;
				$foPct = ($won + $lost > 0 ? number_format($won / ($won + $lost), 3) : '0.000');
				$tot_won += $won;
				$tot_lost += $lost;
			}else{
				$fo_record = '-';
				$foPct = '0.000';
			}
			//print data
			
			if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="52" class="chartC"><a href="<?php echo $href; ?>"><?php echo $career_season; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $played; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $started; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $assists; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $points; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $shots; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $shotPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $unassisted; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $man_up; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $man_down; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $gb; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC2"><?php echo $fo_record; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $foPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $penalties; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
			}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="92" class="chartL"><?php echo $career_season; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $played; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $started; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $assists; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $points; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $shots; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $shotPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $gb; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC2"><?php echo $fo_record; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $foPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $penalties; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
			}
			break;
		default:
			if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="52" class="chartC"><a href="<?php echo $href; ?>"><?php echo $career_season; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $played; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $started; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $assists; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $points; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $shots; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $shotPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $unassisted; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $man_up; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $man_down; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $gb; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $penalties; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
			}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="112" class="chartL"><?php echo $career_season; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $played; ?></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC2"><?php echo $started; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $goals; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $assists; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $points; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $shots; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC2"><?php echo $shotPct; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $gb; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $penalties; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
			}
	}
	//increment
	$row++;
	$plays->move_next();
}

//print career totals
$tot_minutes = number_format($tot_minutes, 1);
$shotPct_total = ($tot_shots > 0 ? number_format($tot_goals / $tot_shots, 3) : '0.000');
switch($chart_type){
	case 'G':
		$gaAvg_total = ($tot_played > 0 ? number_format($tot_allowed / $tot_played, 1) : '0.0');
		$savePct_total = ($tot_saved + $tot_allowed > 0 ? number_format($tot_saved / ($tot_saved + $tot_allowed), 3) : '0.000');
		if($season_detail){
			?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="52" class="chartC">TOTALS</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_played ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_started; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_assists ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_shots ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $shotPct_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_unassisted; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_man_up; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_man_down; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_saved; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_allowed; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $gaAvg_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $savePct_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
			<?php
		}else{
			?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="52" class="chartL">TOTALS</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_played ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_started; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartC"><b><?php echo $tot_assists ?></b></td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartC"><b><?php echo $tot_shots ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $shotPct_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_saved; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_allowed; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $gaAvg_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $savePct_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="31" class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
			<?php
		}
		break;
	case 'F':
		$record_total = $tot_won.'-'.$tot_lost;
		$foPct_total = ($tot_won + $tot_lost > 0 ? number_format($tot_won / ($tot_won + $tot_lost), 3) : '0.000');
		if($season_detail){
			?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="52" class="chartC">TOTALS</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_played; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_started; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $shotPct_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_unassisted; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_man_up; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_man_down; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><b><?php echo $record_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $foPct_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
			<?php
		}else{
			?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="92" class="chartL">TOTALS</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_played; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_started; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $shotPct_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><b><?php echo $record_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $foPct_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
			<?php
		}
		break;
	default:
		if($season_detail){
			?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="52" class="chartC">TOTALS</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_played; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_started; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $shotPct_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_unassisted; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_man_up; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_man_down; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
			<?php
		}else{
			?>
		<tr>
			<td width="1" class="divider"></td>
			<td width="112" class="chartL"><b>TOTALS</td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_played; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="23" class="chartC"><b><?php echo $tot_started; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><b><?php echo $shotPct_total; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
			<?php
		}
}
?>
		</table>
	</div>
	<!-- eof career stats -->
