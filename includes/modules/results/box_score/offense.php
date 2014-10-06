	<!-- bof player stats -->
	<div class="body_container">
<?php
for($i = 0; $i < 2; $i++){
	$teamRef = ($i == 0 ? $home_teamRef : $visitor_teamRef);
	$team_town = ($home_teamRef == $teamRef ? $home_town : $visitor_town);
	if($i == 0){
?>
		<div class="right_container">
<?php
	}else{
?>
		<div class="left_container">
<?php
	}
?>
			<table border="0" cellspacing="0" cellpadding="0" width="360">
			<tr><td colspan="17" class="chartTitleI"><?php echo $team_town; ?> Individual Statistics</td></tr>
			<tr><td colspan="17" class="chartTitleC">Offense</td></tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td colspan="3" class="chartHeaderL"></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartHeaderC">g</td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartHeaderC">a</td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartHeaderC">pt</td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartHeaderC">sh</td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartHeaderC">sh pct</td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartHeaderC">gb</td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
	$tot_goals = 0;
	$tot_assists = 0;
	$tot_points = 0;
	$tot_shots = 0;
	$tot_gb = 0;
	$row = 0;
	$stats = get_box_score_offense($teamRef, $gameRef);
	while(!$stats->eof){
		//get data
		$position = $stats->field['position'];
		$jerseyNo = $stats->field['jerseyNo'];
		$playerMasterRef = $stats->field['playerMasterRef'];
		$player_name = $stats->field['player_name'];
		$goals = ($stats->field['goals'] > 0 ? $stats->field['goals'] : '-');
		$assists = ($stats->field['assists'] > 0 ? $stats->field['assists'] : '-');
		$points = ($stats->field['points'] > 0 ? $stats->field['points'] : '-');
		$shots = ($stats->field['shots'] > 0 ? $stats->field['shots'] : '-');
		$shot_pct = $stats->field['shot_pct'];
		$gb = ($stats->field['gb'] > 0 ? $stats->field['gb'] : '-');
		//process data
		$param = 'pmr='.$playerMasterRef;
		$href_player = set_href(FILENAME_PLAYER_SUMMARY, $param);
		$background = set_background($row);
		//update totals
		$tot_goals += $goals;
		$tot_assists += $assists;
		$tot_points += $points;
		$tot_shots += $shots;
		$tot_gb += $gb;
?>
			<tr class="<?php echo $background; ?>">
				<td width="1" class="divider"></td>
				<td width="23" class="chartC"><?php echo $position; ?></td>
				<td width="1" class="divider"></td>
				<td width="147" class="chartL"><a href="<?php echo $href_player; ?>"><?php echo $player_name; ?></a></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartC1"><?php echo $goals; ?></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartC1"><?php echo $assists; ?></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartC1"><?php echo $points; ?></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartC1"><?php echo $shots; ?></td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartC1"><?php echo $shot_pct; ?></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartC1"><?php echo $gb; ?></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
		$row++;
		$stats->move_next();
	}
	$tot_shotPct = ($tot_shots > 0 ? number_format($tot_goals / $tot_shots, 3) : '0.000');
?>
			<tr>
				<td width="1" class="divider"></td>
				<td colspan="3" class="chartL"><b>Team</b></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartC1"><b><?php echo $tot_goals; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartC1"><b><?php echo $tot_assists; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartC1"><b><?php echo $tot_points; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartC1"><b><?php echo $tot_shots; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartC1"><b><?php echo $tot_shotPct; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="18" class="chartC1"><b><?php echo $tot_gb; ?></b></td>
				<td width="1" class="divider"></td>
			</tr>
			</table>
		</div>
<?php
}
?>
	</div>
	<!-- eof player stats -->
