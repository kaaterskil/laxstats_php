	<!-- bof lineup -->
	<div class="body_container">
<?php
for($i = 0; $i < 2; $i++){
	$offense = array();
	$defense = array();
	$substitutes = array();
	$did_not_play = array();
	$teamRef = ($i == 0 ? $home_teamRef : $visitor_teamRef);
	$team_town = ($home_teamRef == $teamRef ? $home_town : $visitor_town);
	$player_obj = get_box_score_lineup($teamRef, $gameRef);
	//get player data and assign to arrays
	while(!$player_obj->eof){
		$started = $player_obj->field['started'];
		$sequence = $player_obj->field['sequence'];
		if($started == 'T'){
			if($sequence == 1){
				$offense[] = $player_obj->field;
			}else{
				$defense[] = $player_obj->field;
			}
		}else{
			if($started == 'F'){
				$substitutes[] = $player_obj->field;
			}else{
				$did_not_play[] = $player_obj->field;
			}
		}
		$player_obj->move_next();
	}
	//balance array lengths
	$c1 = count($offense);
	$c2 = count($defense);
	$delta = $c1 - $c2;
	if($delta > 0){
		for($j = 0; $j < $delta; $j++){
			$defense[] = array('jerseyNo' => '',
							   'position' => '',
							   'player_name' => ''
							   );
		}
	}elseif($delta < 0){
		for($j = 0; $j < $delta; $j++){
			$offense[] = array('jerseyNo' => '',
							   'position' => '',
							   'player_name' => ''
							   );
		}
	}
	//set substitutes string
	$substitutes_str = '';
	for($j = 0; $j < count($substitutes); $j++){
		$substitutes_str .= $substitutes[$j]['position'].' '.$substitutes[$j]['jerseyNo'].' '.$substitutes[$j]['player_name'].', ';
	}
	$substitutes_str = substr($substitutes_str, 0, -2).'.';
	//set did not play string
	$no_play_str = '';
	for($j = 0; $j < count($did_not_play); $j++){
		$no_play_str .= $did_not_play[$j]['position'].' '.$did_not_play[$j]['jerseyNo'].' '.$did_not_play[$j]['player_name'].', ';
	}
	$no_play_str = substr($no_play_str, 0, -2).'.';
	//print detail
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
			<table border="0" cellspacing="0"  cellpadding="0" width="360">
			<tr><td colspan="6" class="chartTitleI"><?php echo $team_town; ?> Lineup</td></tr>
			<tr><td colspan="6" class="chartHeaderC">Starters</td></tr>
<?php
	//print starters
	for($j = 0; $j < count($offense); $j++){
?>
			<tr>
				<td width="24" class="chartL"><?php echo $offense[$j]['position']; ?></td>
				<td width="24" class="chartL"><?php echo $offense[$j]['jerseyNo']; ?></td>
				<td width="114" class="chartL"><?php echo $offense[$j]['player_name']; ?></td>
				<td width="24" class="chartL"><?php echo $defense[$j]['position']; ?></td>
				<td width="24" class="chartL"><?php echo $defense[$j]['jerseyNo']; ?></td>
				<td width="114" class="chartL"><?php echo $defense[$j]['player_name']; ?></td>
			</tr>
<?php
	}
?>
			<tr><td colspan="6" class="chartHeaderC">Substitutions</td></tr>
			<tr><td colspan="6" class="chartL"><?php echo $substitutes_str; ?></td></tr>
			<tr><td colspan="6" class="chartHeaderC">Did Not Play</td></tr>
			<tr><td colspan="6" class="chartL"><?php echo $no_play_str; ?></td></tr>
			</table>
		</div>
<?php
}
?>
	</div>
	<!-- eof lineup -->
