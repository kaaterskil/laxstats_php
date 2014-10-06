		<!-- bof scoring block -->
		<div class="block_container">
			<div class="chartTitleC">Scoring Information</div>
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
					<td width="43" class="chartHeaderC">Code</td>
					<td width="1" class="divider"></td>
					<td width="135" class="chartHeaderC">Scorer</td>
					<td width="1" class="divider"></td>
					<td width="135" class="chartHeaderC">Assist</td>
					<td width="1" class="divider4"></td>
				</tr>
<?php
	$scoring = get_game_scoring_data($gameRef, $teamRef);
	if(count($scoring->result['reference']) > 0){
		$row = 0;
		while(!$scoring->eof){
			$recordID		= $scoring->field['reference'];
			$scorer			= $scoring->field['scorer'];
			$assist			= $scoring->field['assist'];
			$goal_code		= $scoring->field['goalCode'];
			$quarter		= $scoring->field['quarter'];
			$clock			= $scoring->field['clock'];
			$scorer_name	= substr($scoring->field['scorer_name'], 0, 12);
			$assist_name	= substr($scoring->field['assist_name'], 0, 12);
			
			$time_clock = date('i:s', $clock);
			$background = set_background($row);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=dg';
			$href_delete = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=eg';
			$href_edit = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
?>
				<tr class="<?php echo $background; ?>">
					<td width="1" class="divider"></td>
					<td width="28" class="chartC">
						<a href="#" onClick="set_action('<?php echo $href_delete; ?>', true);"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
						<a href="#" onClick="set_action('<?php echo $href_edit; ?>', false);"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
					</td>
					<td width="1" class="divider4"></td>
					<td width="23" class="chartC"><?php echo $quarter; ?></td>
					<td width="1" class="divider"></td>
					<td width="43" class="chartC"><?php echo $time_clock; ?></td>
					<td width="1" class="divider"></td>
					<td width="43" class="chartC"><?php echo $goal_code; ?></td>
					<td width="1" class="divider"></td>
					<td width="135" class="chartL"><?php echo $scorer_name; ?></td>
					<td width="1" class="divider"></td>
					<td width="135" class="chartL"><?php echo $assist_name; ?></td>
					<td width="1" class="divider"></td>
				</tr>
<?php
			$row++;
			$scoring->move_next();
		}
	}else{
?>
				<tr>
					<td width="1" class="divider"></td>
					<td colspan="11" class="chartL3">No goals have been entered yet.</td>
					<td width="1" class="divider"></td>
				</tr>
<?php
	}
}
?>
				</table>
			</div>
			<!-- eof data display -->
			
			<!-- bof data entry -->
<?php
$class1 = ($edit_teamRef2 != $themTeamRef ? 'drop_down_show' : 'drop_down_hide');
$class2 = ($edit_teamRef2 != $themTeamRef ? 'drop_down_hide' : 'drop_down_show');
$param1 = ($edit_teamRef2 != $themTeamRef ? ' checked="checked"' : '');
$param2 = ($edit_teamRef2 != $themTeamRef ? '' : ' checked="checked"');
$team_select = ($edit_teamRef2 != $themTeamRef ? 'home' : 'visitor');
?>
			<div class="right_container">
				<form name="goals" method="post" onSubmit="set_offsetY(this); return validate_goal(this);" action="<?php echo $href_action_scoring; ?>">
				<table border="0" cellspacing="0" cellpadding="0" width="295">
				<tr>
					<td colspan="4" class="chartTitle2">
						<span class="information"><a href="#" onClick="openInfo('addScore');"><?php echo draw_image('images/b_info3.png'); ?></a></span>
						<span>Scoring Input</span>
					</td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Team:<span class="required">*</span></td>
					<td width="99" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Home', 'home', $team_select, 'onClick="toggle_roster(this, \'roster_home_scorer\', \'roster_visitor_scorer\');toggle_roster(this, \'roster_home_assist\', \'roster_visitor_assist\');"'.$param1); ?></td>
					<td width="99" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Visitor', 'visitor', $team_select, 'onClick="toggle_roster(this, \'roster_home_scorer\', \'roster_visitor_scorer\');toggle_roster(this, \'roster_home_assist\', \'roster_visitor_assist\')"'.$param2); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Scorer:<span class="required">*</span></td>
					<td colspan="2" class="formText2"><?php echo draw_game_player_select('roster_home_scorer', $home_roster, $edit_scorer, 'validate_select(this, 2);', 'id="roster_home_scorer" class="'.$class1.'"'), draw_game_player_select('roster_visitor_scorer', $visitor_roster, $edit_scorer, 'validate_select(this, 2);', 'id="roster_visitor_scorer" class="'.$class2.'"'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Assist:</td>
					<td colspan="2" class="formText2"><?php echo draw_game_player_select('roster_home_assist', $home_roster, $edit_assist, 'test_duplicate(this);', 'id="roster_home_assist" class="'.$class1.'"'), draw_game_player_select('roster_visitor_assist', $visitor_roster, $edit_assist, 'test_duplicate(this);', 'id="roster_visitor_assist" class="'.$class2.'"'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Period:<span class="required">*</span></td>
					<td colspan="2" class="formText2"><?php echo draw_text_input_element('quarter', '', 4, 2, $edit_quarter, 'validate_string(\'quarter\', this); uppercase(this);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Clock:<span class="required">*</span></td>
					<td colspan="2" class="formText2"><?php echo draw_text_input_element('clock', '', 8, 5, $edit_clock, 'validate_clock(this);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="required">*Required</td><?php echo draw_hidden_input_element('usTeamRef', $usTeamRef), draw_hidden_input_element('themTeamRef', $themTeamRef), draw_hidden_input_element('offsetY', $offsetY); ?>
					<td colspan="2" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
				</tr>
				<tr><td colspan="3" class="error"><?php echo $scoring_message; ?></td></tr>
				</table>
				</form>
			</div>
			<!-- eof data entry -->
		</div>
		<!-- eof scoring block -->
