	<!-- bof game log -->
<?php
$current_year = date('Y');
$game_test = ($season == $current_year || $page_ref != FILENAME_PLAYER_SUMMARY ? true : false);

if($game_test){
	//query data
	$plays = get_gamelog_plays($playerRef);
	$goals_obj = get_gamelog_goals($playerRef);
	$penalties_obj = get_gamelog_penalties($playerRef);
	$saves_obj = get_gamelog_saves($playerRef);
	$faceoffs = get_gamelog_faceoffs($playerRef);

	//set chart type if not the summary page
	if($season_detail){
		$chart_type = 'R';
		for($i = 0; $i < count($faceoffs->result['date']); $i++){
			if($faceoffs->result['won'][$i] != NULL || $faceoffs->result['lost'][$i] != NULL){
				$chart_type = 'F';
				break;
			}
		}
		for($i = 0; $i < count($saves_obj->result['date']); $i++){
			if($saves_obj->result['saved'][$i] != NULL || $saves_obj->result['allowed'][$i] != NULL){
				$chart_type = 'G';
				break;
			}
		}
		switch($chart_type){
			case 'G':
			case 'F':
?>
	<div class="game_log_detail_wide">
		<table border="0" cellspacing="0" cellpadding="0" width="750">
<?php
				break;
			default:
?>
	<div class="game_log_detail">
		<table border="0" cellspacing="0" cellpadding="0" width="650">
<?php
		}
	}
	
	//print game log
	$tot_played = 0;
	$tot_started = 0;
	$tot_goals = 0;
	$tot_assists = 0;
	$tot_points = 0;
	$tot_shots = 0;
	$tot_unassisted = 0;
	$tot_man_up = 0;
	$tot_man_down = 0;
	$tot_gb = 0;
	$tot_penalties = 0;
	$tot_minutes = 0;
	$tot_won = 0;
	$tot_lost = 0;
	$tot_saved = 0;
	$tot_allowed = 0;
	$st_test = '';
	for($i = 0; $i < count($plays->result['gameRef']); $i++){
		//retrieve data
		$gameRef = $plays->result['gameRef'][$i];
		$st = $plays->result['seasonType'][$i];
		$date = $plays->result['date'][$i];
		$time = $plays->result['startTime'][$i];
		$opponent = $plays->result['opponent'][$i];
		$place = ($plays->result['place'][$i] != '' ? $plays->result['place'][$i].' ' : '');
		$final = ($plays->result['final'][$i] != 'F' ? TRUE : FALSE);
		$played = ($plays->result['played'][$i] == 'T' ? TRUE : FALSE);
		$started = ($plays->result['started'][$i] == 'T' ? TRUE : FALSE);
		$shots = $plays->result['shots'][$i];
		$gb = $plays->result['gb'][$i];
		$goals_us = $goals_obj->result['goals_us'][$i];
		$goals_them = $goals_obj->result['goals_them'][$i];
		$goals = $goals_obj->result['goals'][$i];
		$assists = $goals_obj->result['assists'][$i];
		$unassisted = $goals_obj->result['unassisted'][$i];
		$man_up = $goals_obj->result['man_up'][$i];
		$man_down = $goals_obj->result['man_down'][$i];
		$penalties = $penalties_obj->result['penalties'][$i];
		$minutes = ($penalties_obj->result['minutes'][$i] > 0 ? $penalties_obj->result['minutes'][$i] : '0.0');
		
		//print chart header
		if($season_detail){
			if($st != $st_test){
				if($season_detail && $st_test != ''){
					$tot_shotPct = ($tot_shots > 0 ? number_format($tot_goals / $tot_shots, 3) : '0.000');
					$tot_minutes = number_format($tot_minutes, 1);
					switch($chart_type){
						case 'G':
							$tot_savePct = ($tot_saved + $tot_allowed > 0 ? number_format($tot_saved / ($tot_saved + $tot_allowed), 3) : '0.000');
?>
		<tr>
			<td width="1" class="divider"></td>
			<td class="chartL"><b>Totals</b></td>
			<td class="chartL"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"><?php echo $tot_played; ?></td>
			<td class="chartC"><?php echo $tot_started; ?></td>
			<td class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shotPct; ?></b></td>
			<td class="chartC"><b><?php echo $tot_unassisted; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_up; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_down; ?></b></td>
			<td class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td class="chartC"><b><?php echo $tot_saved; ?></b></td>
			<td class="chartC"><b><?php echo $tot_allowed; ?></b></td>
			<td class="chartC"><b><?php echo $tot_savePct; ?></b></td>
			<td class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
							break;
						case 'F':
							$tot_fo_record = $tot_won.'-'.$tot_lost;
							$tot_foPct = ($tot_won + $tot_lost > 0 ? number_format($tot_won / ($tot_won + $tot_lost), 3) : '0.000');
?>
		<tr>
			<td width="1" class="divider"></td>
			<td class="chartL"><b>Totals</b></td>
			<td class="chartL"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"><?php echo $tot_played; ?></td>
			<td class="chartC"><?php echo $tot_started; ?></td>
			<td class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shotPct; ?></b></td>
			<td class="chartC"><b><?php echo $tot_unassisted; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_up; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_down; ?></b></td>
			<td class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td class="chartC"><b><?php echo $tot_fo_record; ?></b></td>
			<td class="chartC"><b><?php echo $tot_foPct; ?></b></td>
			<td class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
							break;
						default:
?>
		<tr>
			<td width="1" class="divider"></td>
			<td class="chartL"><b>Totals</b></td>
			<td class="chartL"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"><?php echo $tot_played; ?></td>
			<td class="chartC"><?php echo $tot_started; ?></td>
			<td class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shotPct; ?></b></td>
			<td class="chartC"><b><?php echo $tot_unassisted; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_up; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_down; ?></b></td>
			<td class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td class="chartC"><b><?php echo $tot_penalties; ?></td>
			<td class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}
					
					//reset totals
					$tot_played = 0;
					$tot_started = 0;
					$tot_goals = 0;
					$tot_assists = 0;
					$tot_points = 0;
					$tot_shots = 0;
					$tot_unassisted = 0;
					$tot_man_up = 0;
					$tot_man_down = 0;
					$tot_gb = 0;
					$tot_penalties = 0;
					$tot_minutes = 0;
					$tot_won = 0;
					$tot_lost = 0;
					$tot_saved = 0;
					$tot_allowed = 0;
				}
				
				//print spacer
				if($st_test != ''){
					switch($chart_type){
						case 'G':
?>
		<tr><td colspan="23" height="5" class="divider3"></td></tr>
<?php
						case 'F':
?>
		<tr><td colspan="22" height="5" class="divider3"></td></tr>
<?php
						default:
?>
		<tr><td colspan="20" height="5" class="divider3"></td></tr>
<?php
					}
				}
				
				//print chart header
				$st_test = $st;
				$season_type = ($st == 'F' ? 'Regular Season' : 'Post Season');
				switch($chart_type){
					case 'G':
?>
		<tr>
			<td colspan="6" height="1" class="chartTitleL"><?php echo $season.' '.$season_type; ?></td>
			<td colspan="2" height="1" class="chartTitleTC">play</td>
			<td colspan="9" height="1" class="chartTitleTC">offense</td>
			<td colspan="3" height="1" class="chartTitleTC">saves</td>
			<td colspan="3" height="1" class="chartTitleTC">penalties</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="48" class="chartHeaderL">date</td>
			<td width="118" class="chartHeaderL">opponent</td>
			<td width="11" class="chartHeaderC"></td>
			<td width="34" class="chartHeaderC">score</td>
			<td width="7" class="chartHeaderC"></td>
			<td width="14" class="chartHeaderC">pl</td>
			<td width="14" class="chartHeaderC">st</td>
			<td width="24" class="chartHeaderC">g</td>
			<td width="24" class="chartHeaderC">a</td>
			<td width="24" class="chartHeaderC">pt</td>
			<td width="24" class="chartHeaderC">sh</td>
			<td width="44" class="chartHeaderC">sh pct</td>
			<td width="24" class="chartHeaderC">un</td>
			<td width="24" class="chartHeaderC">up</td>
			<td width="24" class="chartHeaderC">dn</td>
			<td width="24" class="chartHeaderC">gb</td>
			<td width="24" class="chartHeaderC">s</td>
			<td width="24" class="chartHeaderC">ga</td>
			<td width="44" class="chartHeaderC">s pct</td>
			<td width="24" class="chartHeaderC">Pen</td>
			<td width="24" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
						break;
					case 'F':
?>
		<tr>
			<td colspan="6" height="1" class="chartTitleL"><?php echo $season.' '.$season_type; ?></td>
			<td colspan="2" height="1" class="chartTitleTC">play</td>
			<td colspan="9" height="1" class="chartTitleTC">offense</td>
			<td colspan="2" height="1" class="chartTitleTC">faceoffs</td>
			<td colspan="3" height="1" class="chartTitleTC">penalties</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="48" class="chartHeaderL">date</td>
			<td width="120" class="chartHeaderL">opponent</td>
			<td width="11" class="chartHeaderC"></td>
			<td width="34" class="chartHeaderC">score</td>
			<td width="7" class="chartHeaderC"></td>
			<td width="14" class="chartHeaderC">pl</td>
			<td width="14" class="chartHeaderC">st</td>
			<td width="24" class="chartHeaderC">g</td>
			<td width="24" class="chartHeaderC">a</td>
			<td width="24" class="chartHeaderC">pt</td>
			<td width="24" class="chartHeaderC">sh</td>
			<td width="44" class="chartHeaderC">sh pct</td>
			<td width="24" class="chartHeaderC">un</td>
			<td width="24" class="chartHeaderC">up</td>
			<td width="24" class="chartHeaderC">dn</td>
			<td width="24" class="chartHeaderC">gb</td>
			<td width="44" class="chartHeaderC">fo w-l</td>
			<td width="44" class="chartHeaderC">fo pct</td>
			<td width="24" class="chartHeaderC">Pen</td>
			<td width="28" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
						break;
					default:
?>
		<tr>
			<td colspan="6" height="1" class="chartTitleL"><?php echo $season.' '.$season_type; ?></td>
			<td colspan="2" height="1" class="chartTitleTC">play</td>
			<td colspan="9" height="1" class="chartTitleTC">offense</td>
			<td colspan="3" height="1" class="chartTitleTC">penalties</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="48" class="chartHeaderL">date</td>
			<td width="120" class="chartHeaderL">opponent</td>
			<td width="11" class="chartHeaderC"></td>
			<td width="34" class="chartHeaderC">score</td>
			<td width="7" class="chartHeaderC"></td>
			<td width="14" class="chartHeaderC">pl</td>
			<td width="14" class="chartHeaderC">st</td>
			<td width="24" class="chartHeaderC">g</td>
			<td width="24" class="chartHeaderC">a</td>
			<td width="24" class="chartHeaderC">pt</td>
			<td width="24" class="chartHeaderC">sh</td>
			<td width="44" class="chartHeaderC">sh pct</td>
			<td width="24" class="chartHeaderC">un</td>
			<td width="24" class="chartHeaderC">up</td>
			<td width="24" class="chartHeaderC">dn</td>
			<td width="24" class="chartHeaderC">gb</td>
			<td width="24" class="chartHeaderC">Pen</td>
			<td width="28" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
				}
			}
		}elseif($i == 0){
			switch($chart_type){
				case 'G':
?>
	<div class="game_log_summary_wide">
		<table border="0" cellspacing="0" cellpadding="0" width="620">
		<tr><td colspan="18" class="chartTitleL"><?php echo $season; ?> game log</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="53" class="chartHeaderC">date</td>
			<td width="114" class="chartHeaderC">opponent</td>
			<td width="11" class="chartHeaderC"></td>
			<td width="34" class="chartHeaderC">score</td>
			<td width="7" class="chartHeaderC"></td>
			<td width="24" class="chartHeaderC">g</td>
			<td width="24" class="chartHeaderC">a</td>
			<td width="24" class="chartHeaderC">pt</td>
			<td width="24" class="chartHeaderC">sh</td>
			<td width="44" class="chartHeaderC">sh pct</td>
			<td width="24" class="chartHeaderC">gb</td>
			<td width="24" class="chartHeaderC">s</td>
			<td width="24" class="chartHeaderC">ga</td>
			<td width="44" class="chartHeaderC">s pct</td>
			<td width="24" class="chartHeaderC">Pen</td>
			<td width="23" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
					break;
				case 'F':
?>
	<div class="game_log_summary_wide">
		<table border="0" cellspacing="0" cellpadding="0" width="610">
		<tr><td colspan="17" class="chartTitleL"><?php echo $season; ?> game log</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="53" class="chartHeaderC">date</td>
			<td width="114" class="chartHeaderC">opponent</td>
			<td width="11" class="chartHeaderC"></td>
			<td width="34" class="chartHeaderC">score</td>
			<td width="7" class="chartHeaderC"></td>
			<td width="24" class="chartHeaderC">g</td>
			<td width="24" class="chartHeaderC">a</td>
			<td width="24" class="chartHeaderC">pt</td>
			<td width="24" class="chartHeaderC">sh</td>
			<td width="44" class="chartHeaderC">sh pct</td>
			<td width="24" class="chartHeaderC">gb</td>
			<td width="44" class="chartHeaderC">fo w-l</td>
			<td width="44" class="chartHeaderC">fo pct</td>
			<td width="24" class="chartHeaderC">Pen</td>
			<td width="23" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
					break;
				default:
?>
	<div class="game_log_summary">
		<table border="0" cellspacing="0" cellpadding="0" width="510">
		<tr><td colspan="15" class="chartTitleL"><?php echo $season; ?> game log</td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="53" class="chartHeaderC">date</td>
			<td width="114" class="chartHeaderC">opponent</td>
			<td width="11" class="chartHeaderC"></td>
			<td width="34" class="chartHeaderC">score</td>
			<td width="7" class="chartHeaderC"></td>
			<td width="24" class="chartHeaderC">g</td>
			<td width="24" class="chartHeaderC">a</td>
			<td width="24" class="chartHeaderC">pt</td>
			<td width="24" class="chartHeaderC">sh</td>
			<td width="44" class="chartHeaderC">sh pct</td>
			<td width="24" class="chartHeaderC">gb</td>
			<td width="24" class="chartHeaderC">Pen</td>
			<td width="23" class="chartHeaderC">Min</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
			}
		}
		
		//process data
		$game_date = date('M j', strtotime($date));
		$game_time = date('g:i a', strtotime($time));
		$played_mark = ($played == TRUE ? '&radic;' : '');
		$started_mark = ($started == TRUE ? '&radic;' : '');
		$params = 'gr='.$gameRef.'&tr='.$teamRef;
		$href = set_href(FILENAME_BOX_SCORE, $params);
		$score = '<a href="'.$href.'">'.$goals_us.'-'.$goals_them.'</a>';
		$win_tag = ($goals_us > $goals_them ? 'W' : '');
		$loss_tag = ($goals_us > $goals_them ? '' : 'L');
		$points = $goals + $assists;
		$shotPct = ($shots > 0 ? number_format($goals / $shots, 3) : '0.000');
		$background = set_background($i);
		
		//update totals
		$tot_played = ($played == true ? $tot_played + 1 : $tot_played);
		$tot_started = ($started == true ? $tot_started + 1 : $tot_started);
		$tot_goals += $goals;
		$tot_assists += $assists;
		$tot_points += $points;
		$tot_shots += $shots;
		$tot_unassisted += $unassisted;
		$tot_man_up += $man_up;
		$tot_man_down += $man_down;
		$tot_gb += $gb;
		$tot_penalties += $penalties;
		$tot_minutes += $minutes;
		
		//print game
		switch($chart_type){
			case 'G':
				$saved = $saves_obj->result['saved'][$i];
				$allowed = $saves_obj->result['allowed'][$i];
				$savePct = ($saved + $allowed > 0 ? number_format($saved / ($saved + $allowed), 3) : '0.000');
				$tot_saved += $saved;
				$tot_allowed += $allowed;
				if($final){
					if($played){
						if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td class="chartL"><?php echo $game_date; ?></td>
			<td class="chartL"><?php echo $place.$opponent; ?></td>
			<td class="chartC"><?php echo $win_tag; ?></td>
			<td class="chartC"><?php echo $score; ?></td>
			<td class="chartC"><?php echo $loss_tag; ?></td>
			<td class="chartC"><?php echo $played_mark; ?></td>
			<td class="chartC"><?php echo $started_mark; ?></td>
			<td class="chartC2"><?php echo $goals; ?></td>
			<td class="chartC2"><?php echo $assists; ?></td>
			<td class="chartC2"><?php echo $points; ?></td>
			<td class="chartC2"><?php echo $shots; ?></td>
			<td class="chartC2"><?php echo $shotPct; ?></td>
			<td class="chartC2"><?php echo $unassisted; ?></td>
			<td class="chartC2"><?php echo $man_up; ?></td>
			<td class="chartC2"><?php echo $man_down; ?></td>
			<td class="chartC2"><?php echo $gb; ?></td>
			<td class="chartC2"><?php echo $saved; ?></td>
			<td class="chartC2"><?php echo $allowed; ?></td>
			<td class="chartC2"><?php echo $savePct; ?></td>
			<td class="chartC2"><?php echo $penalties; ?></td>
			<td class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="53" class="chartL"><?php echo $game_date; ?></td>
			<td width="114" class="chartL"><?php echo $place.$opponent; ?></td>
			<td width="11" class="chartC"><?php echo $win_tag; ?></td>
			<td width="34" class="chartC"><?php echo $score; ?></td>
			<td width="7" class="chartC"><?php echo $loss_tag; ?></td>
			<td width="24" class="chartC2"><?php echo $goals; ?></td>
			<td width="24" class="chartC2"><?php echo $assists; ?></td>
			<td width="24" class="chartC2"><?php echo $points; ?></td>
			<td width="24" class="chartC2"><?php echo $shots; ?></td>
			<td width="44" class="chartC2"><?php echo $shotPct; ?></td>
			<td width="24" class="chartC2"><?php echo $gb; ?></td>
			<td width="24" class="chartC2"><?php echo $saved; ?></td>
			<td width="24" class="chartC2"><?php echo $allowed; ?></td>
			<td width="44" class="chartC2"><?php echo $savePct; ?></td>
			<td width="24" class="chartC2"><?php echo $penalties; ?></td>
			<td width="23" class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}
					}else{
						if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td class="chartL"><?php echo $game_date; ?></td>
			<td class="chartL"><?php echo $place.$opponent; ?></td>
			<td class="chartC"><?php echo $win_tag; ?></td>
			<td class="chartC"><?php echo $score; ?></td>
			<td class="chartC"><?php echo $loss_tag; ?></td>
			<td colspan="16" class="chartC">Did Not Play.</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="53" class="chartL"><?php echo $game_date; ?></td>
			<td width="114" class="chartL"><?php echo $place.$opponent; ?></td>
			<td width="11" class="chartC"><?php echo $win_tag; ?></td>
			<td width="34" class="chartC"><?php echo $score; ?></td>
			<td width="7" class="chartC"><?php echo $loss_tag; ?></td>
			<td colspan="11" class="chartC">Did Not Play</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}
					}
				}else{
					if($season_detail){
						?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td class="chartL"><?php echo $game_date; ?></td>
			<td class="chartL"><?php echo $place.$opponent; ?></td>
			<td colspan="3" class="chartC"><?php echo $game_time; ?></td>
			<td colspan="16" class="chartC"></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="53" class="chartL"><?php echo $game_date; ?></td>
			<td width="114" class="chartL"><?php echo $place.$opponent; ?></td>
			<td colspan="3" class="chartC"><?php echo $game_time; ?></td>
			<td colspan="11" class="chartC"></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}
				}
				break;
				
			case 'F':
				$won = $faceoffs->result['won'][$i];
				$lost = $faceoffs->result['lost'][$i];
				$fo_record = $won.'-'.$lost;
				$foPct = ($won + $lost > 0 ? number_format($won / ($won + $lost), 3) : '0.000');
				$tot_won += $won;
				$tot_lost += $lost;
				if($final){
					if($played){
						if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td class="chartL"><?php echo $game_date; ?></td>
			<td class="chartL"><?php echo $place.$opponent; ?></td>
			<td class="chartC"><?php echo $win_tag; ?></td>
			<td class="chartC"><?php echo $score; ?></td>
			<td class="chartC"><?php echo $loss_tag; ?></td>
			<td class="chartC"><?php echo $played_mark; ?></td>
			<td class="chartC"><?php echo $started_mark; ?></td>
			<td class="chartC2"><?php echo $goals; ?></td>
			<td class="chartC2"><?php echo $assists; ?></td>
			<td class="chartC2"><?php echo $points; ?></td>
			<td class="chartC2"><?php echo $shots; ?></td>
			<td class="chartC2"><?php echo $shotPct; ?></td>
			<td class="chartC2"><?php echo $unassisted; ?></td>
			<td class="chartC2"><?php echo $man_up; ?></td>
			<td class="chartC2"><?php echo $man_down; ?></td>
			<td class="chartC2"><?php echo $gb; ?></td>
			<td class="chartC2"><?php echo $fo_record; ?></td>
			<td class="chartC2"><?php echo $foPct; ?></td>
			<td class="chartC2"><?php echo $penalties; ?></td>
			<td class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="53" class="chartL"><?php echo $game_date; ?></td>
			<td width="114" class="chartL"><?php echo $place.$opponent; ?></td>
			<td width="11" class="chartC"><?php echo $win_tag; ?></td>
			<td width="34" class="chartC"><?php echo $score; ?></td>
			<td width="7" class="chartC"><?php echo $loss_tag; ?></td>
			<td width="24" class="chartC2"><?php echo $goals; ?></td>
			<td width="24" class="chartC2"><?php echo $assists; ?></td>
			<td width="24" class="chartC2"><?php echo $points; ?></td>
			<td width="24" class="chartC2"><?php echo $shots; ?></td>
			<td width="44" class="chartC2"><?php echo $shotPct; ?></td>
			<td width="24" class="chartC2"><?php echo $gb; ?></td>
			<td width="44" class="chartC2"><?php echo $fo_record; ?></td>
			<td width="44" class="chartC2"><?php echo $foPct; ?></td>
			<td width="24" class="chartC2"><?php echo $penalties; ?></td>
			<td width="23" class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}
					}else{
						if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td class="chartL"><?php echo $game_date; ?></td>
			<td class="chartL"><?php echo $place.$opponent; ?></td>
			<td class="chartC"><?php echo $win_tag; ?></td>
			<td class="chartC"><?php echo $score; ?></td>
			<td class="chartC"><?php echo $loss_tag; ?></td>
			<td colspan="15" class="chartC">Did Not Play.</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="53" class="chartL"><?php echo $game_date; ?></td>
			<td width="114" class="chartL"><?php echo $place.$opponent; ?></td>
			<td width="11" class="chartC"><?php echo $win_tag; ?></td>
			<td width="34" class="chartC"><?php echo $score; ?></td>
			<td width="7" class="chartC"><?php echo $loss_tag; ?></td>
			<td colspan="10" class="chartC">Did Not Play</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}
					}
				}else{
					if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td class="chartL"><?php echo $game_date; ?></td>
			<td class="chartL"><?php echo $place.$opponent; ?></td>
			<td colspan="3" class="chartC"><?php echo $game_time; ?></td>
			<td colspan="15" class="chartC"></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="53" class="chartL"><?php echo $game_date; ?></td>
			<td width="114" class="chartL"><?php echo $place.$opponent; ?></td>
			<td colspan="3" class="chartC"><?php echo $game_time; ?></td>
			<td colspan="10" class="chartC"></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}
				}
				break;
				
			default:
				if($final){
					if($played){
						if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td class="chartL"><?php echo $game_date; ?></td>
			<td class="chartL"><?php echo $place.$opponent; ?></td>
			<td class="chartC"><?php echo $win_tag; ?></td>
			<td class="chartC"><?php echo $score; ?></td>
			<td class="chartC"><?php echo $loss_tag; ?></td>
			<td class="chartC"><?php echo $played_mark; ?></td>
			<td class="chartC"><?php echo $started_mark; ?></td>
			<td class="chartC2"><?php echo $goals; ?></td>
			<td class="chartC2"><?php echo $assists; ?></td>
			<td class="chartC2"><?php echo $points; ?></td>
			<td class="chartC2"><?php echo $shots; ?></td>
			<td class="chartC2"><?php echo $shotPct; ?></td>
			<td class="chartC2"><?php echo $unassisted; ?></td>
			<td class="chartC2"><?php echo $man_up; ?></td>
			<td class="chartC2"><?php echo $man_down; ?></td>
			<td class="chartC2"><?php echo $gb; ?></td>
			<td class="chartC2"><?php echo $penalties; ?></td>
			<td class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="53" class="chartL"><?php echo $game_date; ?></td>
			<td width="114" class="chartL"><?php echo $place.$opponent; ?></td>
			<td width="11" class="chartC"><?php echo $win_tag; ?></td>
			<td width="34" class="chartC"><?php echo $score; ?></td>
			<td width="7" class="chartC"><?php echo $loss_tag; ?></td>
			<td width="24" class="chartC2"><?php echo $goals; ?></td>
			<td width="24" class="chartC2"><?php echo $assists; ?></td>
			<td width="24" class="chartC2"><?php echo $points; ?></td>
			<td width="24" class="chartC2"><?php echo $shots; ?></td>
			<td width="44" class="chartC2"><?php echo $shotPct; ?></td>
			<td width="24" class="chartC2"><?php echo $gb; ?></td>
			<td width="24" class="chartC2"><?php echo $penalties; ?></td>
			<td width="23" class="chartC2"><?php echo $minutes; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}
					}else{
						if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td class="chartL"><?php echo $game_date; ?></td>
			<td class="chartL"><?php echo $place.$opponent; ?></td>
			<td class="chartC"><?php echo $win_tag; ?></td>
			<td class="chartC"><?php echo $score; ?></td>
			<td class="chartC"><?php echo $loss_tag; ?></td>
			<td colspan="13" class="chartC">Did Not Play.</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}else{
							?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="53" class="chartL"><?php echo $game_date; ?></td>
			<td width="114" class="chartL"><?php echo $place.$opponent; ?></td>
			<td width="11" class="chartC"><?php echo $win_tag; ?></td>
			<td width="34" class="chartC"><?php echo $score; ?></td>
			<td width="7" class="chartC"><?php echo $loss_tag; ?></td>
			<td colspan="8" class="chartC">Did Not Play</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
						}
					}
				}else{
					if($season_detail){
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td class="chartL"><?php echo $game_date; ?></td>
			<td class="chartL"><?php echo $place.$opponent; ?></td>
			<td colspan="3" class="chartC"><?php echo $game_time; ?></td>
			<td colspan="13" class="chartC"></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}else{
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="53" class="chartL"><?php echo $game_date; ?></td>
			<td width="114" class="chartL"><?php echo $place.$opponent; ?></td>
			<td colspan="3" class="chartC"><?php echo $game_time; ?></td>
			<td colspan="8" class="chartC"></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
					}
				}
		}
	}
	
	//print final totals
	if($page_ref != FILENAME_PLAYER_SUMMARY){
		$tot_shotPct = ($tot_shots > 0 ? number_format($tot_goals / $tot_shots, 3) : '0.000');
		$tot_minutes = number_format($tot_minutes, 1);
		switch($chart_type){
			case 'G':
				$tot_savePct = ($tot_saved + $tot_allowed > 0 ? number_format($tot_saved / ($tot_saved + $tot_allowed), 3) : '0.000');
?>
		<tr>
			<td width="1" class="divider"></td>
			<td class="chartL"><b>Totals</b></td>
			<td class="chartL"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"><?php echo $tot_played; ?></td>
			<td class="chartC"><?php echo $tot_started; ?></td>
			<td class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shotPct; ?></b></td>
			<td class="chartC"><b><?php echo $tot_unassisted; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_up; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_down; ?></b></td>
			<td class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td class="chartC"><b><?php echo $tot_saved; ?></b></td>
			<td class="chartC"><b><?php echo $tot_allowed; ?></b></td>
			<td class="chartC"><b><?php echo $tot_savePct; ?></b></td>
			<td class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
				break;
			case 'F':
				$tot_fo_record = $tot_won.'-'.$tot_lost;
				$tot_foPct = ($tot_won + $tot_lost > 0 ? number_format($tot_won / ($tot_won + $tot_lost), 3) : '0.000');
?>
		<tr>
			<td width="1" class="divider"></td>
			<td class="chartL"><b>Totals</b></td>
			<td class="chartL"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"><?php echo $tot_played; ?></td>
			<td class="chartC"><?php echo $tot_started; ?></td>
			<td class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shotPct; ?></b></td>
			<td class="chartC"><b><?php echo $tot_unassisted; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_up; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_down; ?></b></td>
			<td class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td class="chartC"><b><?php echo $tot_fo_record; ?></b></td>
			<td class="chartC"><b><?php echo $tot_foPct; ?></b></td>
			<td class="chartC"><b><?php echo $tot_penalties; ?></b></td>
			<td class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
				break;
			default:
?>
		<tr>
			<td width="1" class="divider"></td>
			<td class="chartL"><b>Totals</b></td>
			<td class="chartL"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"></td>
			<td class="chartC"><?php echo $tot_played; ?></td>
			<td class="chartC"><?php echo $tot_started; ?></td>
			<td class="chartC"><b><?php echo $tot_goals; ?></b></td>
			<td class="chartC"><b><?php echo $tot_assists; ?></b></td>
			<td class="chartC"><b><?php echo $tot_points; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shots; ?></b></td>
			<td class="chartC"><b><?php echo $tot_shotPct; ?></b></td>
			<td class="chartC"><b><?php echo $tot_unassisted; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_up; ?></b></td>
			<td class="chartC"><b><?php echo $tot_man_down; ?></b></td>
			<td class="chartC"><b><?php echo $tot_gb; ?></b></td>
			<td class="chartC"><b><?php echo $tot_penalties; ?></td>
			<td class="chartC"><b><?php echo $tot_minutes; ?></b></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		}
		?>
		<tr><td colspan="23" height="10" class="divider2"></tr>
<?php
	}
	?>
</table>
	</div>
<?php
}

//print legend
switch($chart_type){
	case 'G':
	case 'F':
		if($season_detail){
?>
	<div class="game_log_detail_wide">
<?php
		}else{
?>
	<div class="game_log_summary_wide">
<?php
		}
		break;
	default:
		if($season_detail){
?>
	<div class="game_log_detail">
<?php
		}else{
?>
	<div class="game_log_summary">
<?php
		}
}
?>
		<p><b>LEGEND:</b><br><b>PL:</b> Played; <b>ST:</b> Started; <b>G:</b> Goals; <b>A:</b> Assists; <b>PT:</b> Points; <b>SH:</b> Shots; <b>SH PCT:</b> Shot Percentage; <b>UN:</b> Unassisted Goals; <b>UP:</b> Man-up Goals; <b>DN:</b> Man-down Goals; <b>GB:</b> Ground Balls; <b>W-L:</b> Faceoffs Won-Lost; <b>FO PCT:</b> Faceoff Percentage; <b>S:</b> Saves; <b>GA:</b> Goals Allowed; <b>GA AVG:</b> Goals Allowed Average Per Game; <b>PEN:</b> Penalties; <b>MIN:</b> Penalty Minutes.</p>
	</div>
	<!-- eof game log -->
