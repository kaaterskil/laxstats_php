		<!-- bof penalty block -->
		<div class="block_container">
			<div class="chartTitleC">Penalties</div>
			<!-- bof data display -->
			<div class="left_container">
				<table border="0" cellpadding="0" cellspacing="0" width="450">
<?php
for($i = 0; $i < 2; $i++){
	if($i == 0){
		$teamRef = $usTeamRef;
		$town = $us_town;
	}else{
		$teamRef = $themTeamRef;
		$town = $them_town;
?>
				<tr><td colspan="13" height="5" class="divider2"></td></tr>
<?php
	}
?>
				<tr><td colspan="13" class="chartTitle2"><?php echo $town; ?> Team</td></tr>
				<tr>
					<td width="1" class="divider4"></td>
					<td width="28" class="chartHeaderC"></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">Per</td>
					<td width="1" class="divider"></td>
					<td width="43" class="chartHeaderC">Clock</td>
					<td width="1" class="divider"></td>
					<td width="123" class="chartHeaderC">Player</td>
					<td width="1" class="divider"></td>
					<td width="33" class="chartHeaderC">Min</td>
					<td width="1" class="divider"></td>
					<td width="157" class="chartHeaderC">Infraction</td>
					<td width="1" class="divider4"></td>
				</tr>
<?php
	$penalties = get_game_penalty_data($gameRef, $teamRef);
	if(count($penalties->result['reference']) > 0){
		$row = 0;
		while(!$penalties->eof){
			//get data
			$recordID		= $penalties->field['reference'];
			$playerRef		= $penalties->field['playerRef'];
			$name			= $penalties->field['LName'];
			$period			= $penalties->field['startQtr'];
			$clock			= $penalties->field['clock'];
			$duration		= $penalties->field['duration'];
			$infraction		= $penalties->field['infraction'];
			//process data
			$time_clock = date('i:s', $clock);
			$background = set_background($row);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=dpn';
			$href_delete = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=epn';
			$href_edit = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
?>
				<tr class="<?php echo $background; ?>">
					<td width="1" class="divider"></td>
					<td width="28" class="chartC">
						<a href="#" onClick="set_action('<?php echo $href_delete; ?>',true);"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
						<a href="#" onClick="set_action('<?php echo $href_edit; ?>',false);"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
					</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $period; ?></td>
					<td width="1" class="divider"></td>
					<td width="43" class="chartC"><?php echo $time_clock; ?></td>
					<td width="1" class="divider"></td>
					<td width="123" class="chartL"><?php echo $name; ?></td>
					<td width="1" class="divider"></td>
					<td width="33" class="chartC"><?php echo $duration; ?></td>
					<td width="1" class="divider"></td>
					<td width="157" class="chartL"><?php echo $infraction; ?></td>
					<td width="1" class="divider"></td>
				</tr>
<?php
			$row++;
			$penalties->move_next();
		}
	}else{
?>
				<tr>
					<td width="1" class="divider"></td>
					<td colspan="11" class="chartL3">No penalties have been entered yet.</td>
					<td width="1" class="divider"></td>
<?php
	}
}
?>
				</table>
			</div>
			<!-- eof data display -->
			
			<!-- bof data entry -->
<?php
$class1 = ($edit_teamRef3 != $themTeamRef ? 'drop_down_show' : 'drop_down_hide');
$class2 = ($edit_teamRef3 != $themTeamRef ? 'drop_down_hide' : 'drop_down_show');
$param1 = ($edit_teamRef3 != $themTeamRef ? ' checked="checked"' : '');
$param2 = ($edit_teamRef3 != $themTeamRef ? '' : ' checked="checked"');
$team_select = ($edit_teamRef3 != $themTeamRef ? 'home' : 'visitor');
?>
			<div class="right_container">
				<form name="penalty" method="post" onSubmit="set_offsetY(this); return validate_penalty(this);" action="<?php echo $href_action_penalty; ?>">
				<table border="0" cellspacing="0" cellpadding="0" width="295">
				<tr>
					<td colspan="3" class="chartTitle2">
						<span class="information"><a href="#" onClick="openInfo('addPenalty');"><?php echo draw_image('images/b_info3.png'); ?></a></span>
						<span>Penalty Input</span>
					</td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Team:<span class="required">*</span></td>
					<td width="99" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Home', 'home', $team_select, 'onClick="toggle_roster(this, \'penalty_roster_home\', \'penalty_roster_visitor\');"'.$param1); ?></td>
					<td width="99" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Visitor', 'visitor', $team_select, 'onClick="toggle_roster(this, \'penalty_roster_home\', \'penalty_roster_visitor\')"'.$param2); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Player:<span class="required">*</span></td>
					<td colspan="2" class="formText2"><?php echo draw_game_player_select('roster_home', $home_roster, $edit_playerRef, 'validate_select(this, 2);', 'id="penalty_roster_home" class="'.$class1.'"'), draw_game_player_select('roster_visitor', $visitor_roster, $edit_playerRef, 'validate_select(this, 2);', 'id="penalty_roster_visitor" class="'.$class2.'"'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Period:<span class="required">*</span></td>
					<td colspan="2" class="formText2"><?php echo draw_text_input_element('period', '', 4, 2, $edit_quarter, 'validate_string(\'quarter\', this);uppercase(this);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Clock:<span class="required">*</span></td>
					<td colspan="2" class="formText2"><?php echo draw_text_input_element('clock', '', 8, 5, $edit_clock, 'validate_clock(this);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Infraction:<span class="required">*</span></td>
					<td colspan="2" class="formText2"><?php draw_violation_select('infraction', $edit_infraction); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Duration:<span class="required">*</span></td>
					<td colspan="2" class="formText2"><?php echo draw_text_input_element('duration', '', 8, 5, $edit_duration, 'validate_duration(this);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="required">*Required</td><?php echo draw_hidden_input_element('usTeamRef', $usTeamRef), draw_hidden_input_element('themTeamRef', $themTeamRef), draw_hidden_input_element('offsetY', $offsetY); ?>
					<td colspan="2" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
				</tr>
				<tr><td colspan="3" class="error"><?php echo $penalty_message; ?></td></tr>
				</table>
				</form>
			</div>
			<!-- eof data entry -->
		</div>
		<!-- eof penalty block -->
