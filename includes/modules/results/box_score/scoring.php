			<!-- bof scoring summary -->
			<table border="0" cellspacing="0" cellpadding="0" width="360">
			<tr><td colspan="13" class="chartTitleS">Scoring Summary</td></tr>
<?php
$home_cume = 0;
$visitor_cume = 0;
$period = '';
$scoring = get_box_score_scoring($gameRef);
while(!$scoring->eof){
	//get data
	$teamRef = $scoring->field['teamRef'];
	$quarter = $scoring->field['quarter'];
	$timeClock = $scoring->field['timeClock'];
	$teamRef = $scoring->field['teamRef'];
	$goalCode = $scoring->field['goalCode'];
	$scorer = $scoring->field['scorer'];
	$assist = $scoring->field['assist'];
	//process data
	$time = date('i:s', strtotime($timeClock));
	$goalCode = ($goalCode == NULL ? 'EVEN' : $goalCode);
	if($teamRef == $home_teamRef){
		$team_abbrev = $home_abbrev;
		$home_cume++;
	}else{
		$team_abbrev = $visitor_abbrev;
		$visitor_cume++;
	}
	//print data
	if($quarter != $period){
		$period = $quarter;
?>
			<tr>
				<td colspan="8" class="chartHeaderS" style="text-align:left">Period <?php echo $period; ?></td>
				<td colspan="2"class="chartHeaderS"><?php echo $visitor_abbrev; ?></td>
				<td colspan="3" class="chartHeaderS"><?php echo $home_abbrev; ?></td>
			</tr>
<?php
	}
?>
			<tr valign="top">
				<td width="1" class="divider"></td>
				<td width="33" class="chartC"><b><?php echo $team_abbrev; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartC"><?php echo $goalCode; ?></td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartC"><?php echo $time; ?></td>
				<td width="1" class="divider"></td>
				<td width="172" class="chartL"><?php echo $scorer; ?><br><i><?php echo $assist; ?></i></td>
				<td width="1" class="divider"></td>
				<td width="23" class="chartC"><b><?php echo $visitor_cume; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="23" class="chartC"><b><?php echo $home_cume; ?></b></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
	$scoring->move_next();
}
?>
			<tr><td colspan="13" height="20" class="divider2"></td></tr>
			</table>
			<!-- eof scoring summary -->
