	<!-- bof saves -->
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
			<tr><td colspan="9" class="chartTitleC">Saves</td></tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="182" class="chartHeaderL"></td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartHeaderC">Saved</td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartHeaderC">Allowed</td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartHeaderC">Pct</td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
	$tot_saved = 0;
	$tot_ga = 0;
	$row = 0;
	$saves_obj = get_box_score_saves($teamRef, $gameRef);
	while(!$saves_obj->eof){
		$playerMasterRef = $saves_obj->field['playerMasterRef'];
		$player_name = $saves_obj->field['player_name'];
		$saved = $saves_obj->field['saved'];
		$ga = $saves_obj->field['allowed'];
		//process data
		$savePct = ($saved + $ga > 0 ? number_format($saved / ($saved + $ga), 3) : '0.000');
		$param = 'pmr='.$playerMasterRef;
		$href_player = set_href(FILENAME_PLAYER_SUMMARY, $param);
		$background = set_background($row);
		//update totals
		$tot_saved += $saved;
		$tot_ga += $ga
?>
			<tr class="<?php echo $background; ?>">
				<td width="1" class="divider"></td>
				<td width="182" class="chartL"><a href="<?php echo $href_player; ?>"><?php echo $player_name; ?></a></td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartC1"><?php echo $saved; ?></td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartC1"><?php echo $ga; ?></td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartC1"><?php echo $savePct; ?></td>
				<td width="1" class="divider"></td>
			</tr>
<?php		
		$saves_obj->move_next();
	}
	$savePct = ($tot_saved + $tot_ga > 0 ? number_format($tot_saved / ($tot_saved + $tot_ga), 3) : '0.000');
?>
			<tr>
				<td width="1" class="divider"></td>
				<td width="182" class="chartL"><b>Team</b></td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartC1"><b><?php echo $tot_saved; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartC1"><b><?php echo $tot_ga; ?></b></td>
				<td width="1" class="divider"></td>
				<td width="43" class="chartC1"><b><?php echo $savePct; ?></b></td>
				<td width="1" class="divider"></td>
			</tr>
			</table>
		</div>
<?php
}
?>
	</div>
	<!-- eof saves -->
