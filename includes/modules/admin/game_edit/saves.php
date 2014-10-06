		<!-- bof saves block -->
		<div class="block_container">
			<div class="chartTitleC">Goalkeeper Saves</div>
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
				<tr><td colspan="25" height="5" class="divider2"></td></tr>
<?php
	}
?>
				<tr><td colspan="25" class="chartTitle2"><?php echo $town; ?> Team</td></tr>
				<tr>
					<td colspan="2" class="chartHeaderC"></td>
					<td width="1" class="divider"></td>
					<td width="107" class="chartHeaderC"></td>
					<td width="1" class="divider"></td>
					<td colspan="3" class="chartHeaderC">Q1</td>
					<td width="1" class="divider"></td>
					<td colspan="3" class="chartHeaderC">Q2</td>
					<td width="1" class="divider"></td>
					<td colspan="3" class="chartHeaderC">Q3</td>
					<td width="1" class="divider"></td>
					<td colspan="3" class="chartHeaderC">Q4</td>
					<td width="1" class="divider"></td>
					<td colspan="4" class="chartHeaderC">OT</td>
				</tr>
				<tr>
					<td colspan="4" class="divider4"></td>
					<td colspan="21" height="1" class="divider"></td>
				</tr>
				<tr>
					<td width="1" class="divider4"></td>
					<td width="28" class="divider4"></td>
					<td width="1" class="divider"></td>
					<td width="107" class="chartHeaderC">Player</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">s</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">ga</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">s</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">ga</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">s</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">ga</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">s</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">ga</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">s</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">ga</td>
					<td width="1" class="divider4"></td>
				</tr>
<?php
	$goalie = get_game_goalie_data($gameRef, $teamRef);
	if(count($goalie->result['reference']) > 0){
		$tot_savedQ1 = 0;
		$tot_savedQ2 = 0;
		$tot_savedQ3 = 0;
		$tot_savedQ4 = 0;
		$tot_savedOT = 0;
		$tot_allowedQ1 = 0;
		$tot_allowedQ2 = 0;
		$tot_allowedQ3 = 0;
		$tot_allowedQ4 = 0;
		$tot_allowedOT = 0;
		$row = 0;
		while(!$goalie->eof){
			$recordID = $goalie->field['reference'];
			$name = substr($goalie->field['LName'], 0, 12);
			$jerseyNo = $goalie->field['jerseyNo'];
			$savedQ1 = $goalie->field['savedQ1'];
			$savedQ2 = $goalie->field['savedQ2'];
			$savedQ3 = $goalie->field['savedQ3'];
			$savedQ4 = $goalie->field['savedQ4'];
			$savedOT = $goalie->field['savedOT'];
			$allowedQ1 = $goalie->field['allowedQ1'];
			$allowedQ2 = $goalie->field['allowedQ2'];
			$allowedQ3 = $goalie->field['allowedQ3'];
			$allowedQ4 = $goalie->field['allowedQ4'];
			$allowedOT = $goalie->field['allowedOT'];

			$tot_savedQ1 += $savedQ1;
			$tot_savedQ2 += $savedQ2;
			$tot_savedQ3 += $savedQ3;
			$tot_savedQ4 += $savedQ4;
			$tot_savedOT += $savedOT;
			$tot_allowedQ1 += $allowedQ1;
			$tot_allowedQ2 += $allowedQ2;
			$tot_allowedQ3 += $allowedQ3;
			$tot_allowedQ4 += $allowedQ4;
			$tot_allowedOT += $allowedOT;
			
			$savedQ1 = ($savedQ1 > 0 ? $savedQ1 : '-');
			$savedQ2 = ($savedQ2 > 0 ? $savedQ2 : '-');
			$savedQ3 = ($savedQ3 > 0 ? $savedQ3 : '-');
			$savedQ4 = ($savedQ4 > 0 ? $savedQ4 : '-');
			$savedOT = ($savedOT > 0 ? $savedOT : '-');
			$allowedQ1 = ($allowedQ1 > 0 ? $allowedQ1 : '-');
			$allowedQ2 = ($allowedQ2 > 0 ? $allowedQ2 : '-');
			$allowedQ3 = ($allowedQ3 > 0 ? $allowedQ3 : '-');
			$allowedQ4 = ($allowedQ4 > 0 ? $allowedQ4 : '-');
			$allowedOT = ($allowedOT > 0 ? $allowedOT : '-');
			
			$background = set_background($row);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=dgk';
			$href_delete = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=egk';
			$href_edit = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
?>
				<tr class="<?php echo $background; ?>">
					<td width="1" class="divider"></td>
					<td width="28" class="chartC">
						<a href="#" onClick="set_action('<?php echo $href_delete; ?>', true);"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
						<a href="#" onClick="set_action('<?php echo $href_edit; ?>', false);"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
					</td>
					<td width="1" class="divider"></td>
					<td width="107" class="chartL"><?php echo $name; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $savedQ1; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $allowedQ1; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $savedQ2; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $allowedQ2; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $savedQ3; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $allowedQ3; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $savedQ4; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $allowedQ4; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $savedOT; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $allowedOT; ?></td>
					<td width="1" class="divider"></td>
				</tr>
<?php
			$row++;
			$goalie->move_next();
		}
?>
				<tr>
					<td width="1" class="divider"></td>
					<td colspan="3" class="chartL"><b>Team</b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_savedQ1; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_allowedQ1; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_savedQ2; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_allowedQ2; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_savedQ3; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_allowedQ3; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_savedQ4; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_allowedQ4; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_savedOT; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_allowedOT; ?></b></td>
					<td width="1" class="divider"></td>
				</tr>
<?php
	}else{
?>
				<tr>
					<td width="1" class="divider"></td>
					<td colspan="23" class="chartL3">No goalkeeper information has been entered yet.</td>
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
$class1 = ($edit_teamRef4 != $themTeamRef ? 'drop_down_show' : 'drop_down_hide');
$class2 = ($edit_teamRef4 != $themTeamRef ? 'drop_down_hide' : 'drop_down_show');
$param1 = ($edit_teamRef4 != $themTeamRef ? ' checked="checked"' : '');
$param2 = ($edit_teamRef4 != $themTeamRef ? '' : ' checked="checked"');
$team_select = ($edit_teamRef4 != $themTeamRef ? 'home' : 'visitor');
?>
			<div class="right_container">
				<form name="goalie" method="post" onSubmit="set_offsetY(this); validate_save(this);" action="<?php echo $href_action_goalie; ?>">
				<table border="0" cellspacing="0" cellpadding="0" width="295">
				<tr>
					<td colspan="7" class="chartTitle2">
						<span class="information"><a href="#" onClick="openInfo('addSave');"><?php echo draw_image('images/b_info3.png'); ?></a></span>
						<span>Saves / Goals Allowed Input</span>
					</td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Team:<span class="required">*</span></td>
					<td colspan="3" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Home', 'home', $team_select, 'onClick="toggle_roster(this, \'save_roster_home\', \'save_roster_visitor\');" '.$param1); ?></td>
					<td colspan="3" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Visitor', 'visitor', $team_select, 'onClick="toggle_roster(this, \'save_roster_home\', \'save_roster_visitor\')" '.$param2); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Player:<span class="required">*</span></td>
					<td colspan="5" class="formText2"><?php echo draw_game_player_select('roster_home', $home_roster, $edit_playerRef, 'validate_select(this, 2);', 'id="save_roster_home" class="'.$class1.'"'), draw_game_player_select('roster_visitor', $visitor_roster, $edit_playerRef, 'validate_select(this, 2);', 'id="save_roster_visitor" class="'.$class2.'"'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">&nbsp;</td>
					<td width="29" class="formLabel2">Q1</td>
					<td width="29" class="formLabel2">Q2</td>
					<td width="29" class="formLabel2">Q3</td>
					<td width="29" class="formLabel2">Q4</td>
					<td width="29" class="formLabel2">OT</td>
					<td width="29" class="formLabel2">Tot</td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Saved:</td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va1', '', 2, 2, $edit_savedQ1, 'get_total(document.goalie);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va2', '', 2, 2, $edit_savedQ2, 'get_total(document.goalie);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va3', '', 2, 2, $edit_savedQ3, 'get_total(document.goalie);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va4', '', 2, 2, $edit_savedQ4, 'get_total(document.goalie);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vaOT', '', 2, 2, $edit_savedOT, 'get_total(document.goalie);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vaT', '', 2, 2, $edit_tot_saved, 'get_total(document.goalie);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Allowed:</td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb1', '', 2, 2, $edit_allowedQ1, 'get_total(document.goalie);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb2', '', 2, 2, $edit_allowedQ2, 'get_total(document.goalie);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb3', '', 2, 2, $edit_allowedQ3, 'get_total(document.goalie);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb4', '', 2, 2, $edit_allowedQ4, 'get_total(document.goalie);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vbOT', '', 2, 2, $edit_allowedOT, 'get_total(document.goalie);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vbT', '', 2, 2, $edit_tot_allowed, 'get_total(document.goalie);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="required">*Required</td><?php echo draw_hidden_input_element('usTeamRef', $usTeamRef), draw_hidden_input_element('themTeamRef', $themTeamRef), draw_hidden_input_element('offsetY', $offsetY); ?>
					<td colspan="6" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
				</tr>
				<tr><td colspan="7" class="error"><?php echo $goalie_message; ?></td></tr>
				</table>
				</form>
			</div>
			<!-- eof data entry -->
		</div>
		<!-- eof saves block -->
