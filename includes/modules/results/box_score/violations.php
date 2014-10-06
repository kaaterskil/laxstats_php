			<!-- bof penalty summary -->
			<table border="0" cellspacing="0" cellpadding="0" width="360">
			<tr><td colspan="9" class="chartTitleS">Penalty Summary</td></tr>
<?php
$period = '';
$violations = get_box_score_penalties($gameRef);
while(!$violations->eof){
	//get data
	$teamRef = $violations->field['teamRef'];
	$duration = $violations->field['duration'];
	$startQtr = $violations->field['startQtr'];
	$startTime = $violations->field['startTime'];
	$infraction = $violations->field['infraction'];
	$player = $violations->field['player'];
	//process data
	$time = date('i:s', strtotime($startTime));
	$duration = number_format($duration, 1);
	if($teamRef == $home_teamRef){
		$team_abbrev = $home_abbrev;
	}else{
		$team_abbrev = $visitor_abbrev;
	}
	//print data
	if($startQtr != $period){
		$period = $startQtr;
?>
			<tr>
				<td colspan="6" class="chartHeaderS" style="text-align:left">Period <?php echo $startQtr; ?></td>
				<td colspan="3" class="chartHeaderS">Min</td>
			</tr>
<?php
	}
?>
			<tr valign="top">
				<td width="1" class="divider"></td>
				<td width="33" class="chartC"><b><?php echo $team_abbrev; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartC"><?php echo $time; ?></td>
				<td width="1" class="divider"></td>
				<td width="242" class="chartL"><?php echo $player; ?><br><i><?php echo $infraction; ?></i></td>
				<td width="1" class="divider"></td>
				<td width="23" class="chartC"><?php echo $duration; ?></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
	$violations->move_next();
}
?>
			</table>
			<!-- eof penalty summary -->
