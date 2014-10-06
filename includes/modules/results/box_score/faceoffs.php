	<!-- bof faceoffs -->
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
			<tr><td colspan="7" class="chartTitleC">Faceoffs</td></tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="242" class="chartHeaderL"></td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartHeaderC">Win-Loss</td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartHeaderC">Pct</td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
	$tot_won = 0;
	$tot_lost = 0;
	$row= 0;
	$faceoffs = get_box_score_faceoffs($teamRef, $gameRef);
	while(!$faceoffs->eof){
		//get data
		$playerMasterRef = $faceoffs->field['playerMasterRef'];
		$player_name = $faceoffs->field['player_name'];
		$won = $faceoffs->field['won'];
		$lost = $faceoffs->field['lost'];
		//process data
		$fo_str = $won.'-'.$lost;
		$foPct = ($won + $lost > 0 ? number_format($won / ($won + $lost), 3) : '0.000');
		$param = 'pmr='.$playerMasterRef;
		$href_player = set_href(FILENAME_PLAYER_SUMMARY, $param);
		$background = set_background($row);
		//update totals
		$tot_won += $won;
		$tot_lost += $lost;
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="242" class="chartL"><a href="<?php echo $href_player; ?>"><?php echo $player_name; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC1"><?php echo $fo_str; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC1"><?php echo $foPct; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php		
		$faceoffs->move_next();
	}
	//print totals
	$fo_str = $tot_won.'-'.$tot_lost;
	$foPct = ($tot_won + $tot_lost > 0 ? number_format($tot_won / ($tot_won + $tot_lost), 3) : '0.000');
?>
			<tr>
				<td width="1" class="divider"></td>
				<td width="242" class="chartL"><b>Team</b></td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartC1"><b><?php echo $fo_str; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartC1"><b><?php echo $foPct; ?></b></td>
				<td width="1" class="divider"></td>
			</tr>
			</table>
		</div>
<?php
}
?>
	</div>
	<!-- eof faceoffs -->
