		<!-- bof plays block -->
		<div class="block_container">
			<div class="chartTitleC">Playing Information</div>
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
				<tr><td colspan="29" height="5" class="divider2"></td></tr>
<?php
	}
?>
				<tr><td colspan="29" class="chartTitle2"><?php echo $town; ?> Team</td></tr>
				<tr>
					<td colspan="4" class="chartHeaderC"></td>
					<td width="1" class="divider"></td>
					<td colspan="3" class="chartHeaderC">Play</td>
					<td width="1" class="divider"></td>
					<td colspan="9" class="chartHeaderC">Shots</td>
					<td width="1" class="divider"></td>
					<td colspan="10" class="chartHeaderC">Ground Balls</td>
				</tr>
				<tr>
					<td colspan="4" class="divider4"></td>
					<td colspan="25" height="1" class="divider"></td>
				</tr>
				<tr>
					<td width="1" class="divider4"></td>
					<td width="28" class="divider4"></td>
					<td width="1" class="divider4"></td>
					<td width="87" class="chartHeaderL">Player</td>
					<td width="1" class="divider"></td>
					<td width="13" class="chartHeaderC">pl</td>
					<td width="1" class="divider"></td>
					<td width="13" class="chartHeaderC">st</td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartHeaderC">Q1</td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartHeaderC">Q2</td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartHeaderC">Q3</td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartHeaderC">Q4</td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartHeaderC">OT</td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartHeaderC">Q1</td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartHeaderC">Q2</td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartHeaderC">Q3</td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartHeaderC">Q4</td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartHeaderC">OT</td>
					<td width="1" class="divider4"></td>
				</tr>
<?php
	$plays = get_game_play_data($gameRef, $teamRef);
	if(count($plays->result['jerseyNo']) > 0){
		$tot_shotsQ1 = 0;
		$tot_shotsQ2 = 0;
		$tot_shotsQ3 = 0;
		$tot_shotsQ4 = 0;
		$tot_shotsOT = 0;
		$tot_gbQ1 = 0;
		$tot_gbQ2 = 0;
		$tot_gbQ3 = 0;
		$tot_gbQ4 = 0;
		$tot_gbOT = 0;
		$row = 0;
		while(!$plays->eof){
			$recordID = $plays->field['reference'];
			$last_name = substr($plays->field['LName'], 0, 12);
			$jerseyNo = $plays->field['jerseyNo'];
			$started = ($plays->field['started'] == 'T' ? '&radic;' : '');
			$played = ($plays->field['played'] == 'T' ? '&radic;' : '');
			$shotsQ1 = $plays->field['shotsQ1'];
			$shotsQ2 = $plays->field['shotsQ2'];
			$shotsQ3 = $plays->field['shotsQ3'];
			$shotsQ4 = $plays->field['shotsQ4'];
			$shotsOT = $plays->field['shotsOT'];
			$gbQ1 = $plays->field['gbQ1'];
			$gbQ2 = $plays->field['gbQ2'];
			$gbQ3 = $plays->field['gbQ3'];
			$gbQ4 = $plays->field['gbQ4'];
			$gbOT = $plays->field['gbOT'];

			$tot_shotsQ1 += $shotsQ1;
			$tot_shotsQ2 += $shotsQ2;
			$tot_shotsQ3 += $shotsQ3;
			$tot_shotsQ4 += $shotsQ4;
			$tot_shotsOT += $shotsOT;
			$tot_gbQ1 += $gbQ1;
			$tot_gbQ2 += $gbQ2;
			$tot_gbQ3 += $gbQ3;
			$tot_gbQ4 += $gbQ4;
			$tot_gbOT += $gbOT;

			$shotsQ1 = ($shotsQ1 > 0 ? $shotsQ1 : '-');
			$shotsQ2 = ($shotsQ2 > 0 ? $shotsQ2 : '-');
			$shotsQ3 = ($shotsQ3 > 0 ? $shotsQ3 : '-');
			$shotsQ4 = ($shotsQ4 > 0 ? $shotsQ4 : '-');
			$shotsOT = ($shotsOT > 0 ? $shotsOT : '-');
			$gbQ1 = ($gbQ1 > 0 ? $gbQ1 : '-');
			$gbQ2 = ($gbQ2 > 0 ? $gbQ2 : '-');
			$gbQ3 = ($gbQ3 > 0 ? $gbQ3 : '-');
			$gbQ4 = ($gbQ4 > 0 ? $gbQ4 : '-');
			$gbOT = ($gbOT > 0 ? $gbOT : '-');
			
			$background = set_background($row);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=dpl';
			$href_delete = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=epl';
			$href_edit = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
?>
				<tr class="<?php echo $background; ?>">
					<td width="1" class="divider"></td>
					<td width="28" class="chartC">
						<a href="#" onClick="set_action('<?php echo $href_delete; ?>', true);"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
						<a href="#" onClick="set_action('<?php echo $href_edit; ?>', false);"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
					</td>
					<td width="1" class="divider"></td>
					<td width="87" class="chartL"><?php echo $last_name; ?></td>
					<td width="1" class="divider"></td>
					<td width="13" class="chartC"><?php echo $played; ?></td>
					<td width="1" class="divider"></td>
					<td width="13" class="chartC"><?php echo $started; ?></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><?php echo $shotsQ1; ?></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><?php echo $shotsQ2; ?></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><?php echo $shotsQ3; ?></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><?php echo $shotsQ4; ?></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><?php echo $shotsOT; ?></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><?php echo $gbQ1; ?></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><?php echo $gbQ2; ?></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><?php echo $gbQ3; ?></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><?php echo $gbQ4; ?></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><?php echo $gbOT; ?></td>
					<td width="1" class="divider"></td>
				</tr>
<?php
			$row++;
			$plays->move_next();
		}
?>
				<tr>
					<td width="1" class="divider"></td>
					<td colspan="7" class="chartL"><b>Totals</b></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><b><?php echo $tot_shotsQ1; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><b><?php echo $tot_shotsQ2; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><b><?php echo $tot_shotsQ3; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><b><?php echo $tot_shotsQ4; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><b><?php echo $tot_shotsOT; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><b><?php echo $tot_gbQ1; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><b><?php echo $tot_gbQ2; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><b><?php echo $tot_gbQ3; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><b><?php echo $tot_gbQ4; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="21" class="chartC"><b><?php echo $tot_gbOT; ?></b></td>
					<td width="1" class="divider"></td>
				</tr>
<?php
	}else{
?>
				<tr>
					<td width="1" class="divider"></td>
					<td colspan="27" class="chartL3">No players have been set up yet.</td>
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
$class1 = ($edit_teamRef1 != $themTeamRef ? 'drop_down_show' : 'drop_down_hide');
$class2 = ($edit_teamRef1 != $themTeamRef ? 'drop_down_hide' : 'drop_down_show');
$param1 = ($edit_teamRef1 != $themTeamRef ? ' checked="checked"' : '');
$param2 = ($edit_teamRef1 != $themTeamRef ? '' : ' checked="checked"');
$team_select = ($edit_teamRef1 != $themTeamRef ? 'home' : 'visitor');
?>
			<div class="right_container">
				<form name="plays" method="post" onSubmit="set_offsetY(this); return validate_play(this);" action="<?php echo $href_action_play; ?>">
				<table border="0" cellspacing="0" cellpadding="0" width="295">
				<tr>
					<td colspan="7" class="chartTitle2">
						<span class="information"><a href="#" onClick="openInfo('addPlay');"><?php echo draw_image('images/b_info3.png'); ?></a></span>
						<span>Play Input</span>
					</td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Team:<span class="required">*</span></td>
					<td colspan="3" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Home', 'home', $team_select, 'onClick="toggle_roster(this, \'play_roster_home\', \'play_roster_visitor\');"'.$param1); ?></td>
					<td colspan="3" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Visitor', 'visitor', $team_select, 'onClick="toggle_roster(this, \'play_roster_home\', \'play_roster_visitor\');"'.$param2); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Player:<span class="required">*</span></td>
					<td colspan="6" class="formText2"><?php echo draw_game_player_select('roster_home', $home_roster, $edit_playerRef, 'get_position(this, document.plays); set_played(this);', 'id="play_roster_home" class="'.$class1.'"'), draw_game_player_select('roster_visitor', $visitor_roster, $edit_playerRef, 'get_position(this, document.plays); set_played(this);', 'id="play_roster_visitor" class="'.$class2.'"'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Position:</td>
					<td colspan="6" class="formText2"><?php echo draw_text_input_element('position', '', 4, 3, $edit_position, 'validate_string(\'position\', this); uppercase(this);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Status:<span class="required">*</span></td>
					<td colspan="3" class="formText2"><?php echo draw_checkbox_input_element('played', '', 'Played', 'T', $edit_played, ''); ?></td>
					<td colspan="3" class="formText2"><?php echo draw_checkbox_input_element('started', '', 'Started', 'T', $edit_started, 'validate_start(this);'); ?></td>
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
					<td width="79" class="formLabel2">Shots:</td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va1', '', 2, 2, $edit_shotsQ1, 'get_total(document.plays);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va2', '', 2, 2, $edit_shotsQ2, 'get_total(document.plays);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va3', '', 2, 2, $edit_shotsQ3, 'get_total(document.plays);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va4', '', 2, 2, $edit_shotsQ4, 'get_total(document.plays);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vaOT', '', 2, 2, $edit_shotsOT, 'get_total(document.plays);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vaT', '', 2, 2, $edit_tot_shots, 'get_total(document.plays);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Ground Balls:</td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb1', '', 2, 2, $edit_gbQ1, 'get_total(document.plays);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb2', '', 2, 2, $edit_gbQ2, 'get_total(document.plays);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb3', '', 2, 2, $edit_gbQ3, 'get_total(document.plays);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb4', '', 2, 2, $edit_gbQ4, 'get_total(document.plays);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vbOT', '', 2, 2, $edit_gbOT, 'get_total(document.plays);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vbT', '', 2, 2, $edit_tot_gb, 'get_total(document.plays);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="required">*Required</td><?php echo draw_hidden_input_element('usTeamRef', $usTeamRef), draw_hidden_input_element('themTeamRef', $themTeamRef), draw_hidden_input_element('offsetY', $offsetY); ?>
					<td colspan="6" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
				</tr>
				<tr><td colspan="7" class="error"><?php echo $play_message; ?></td></tr>
				</table>
				</form>
			</div>
			<!-- eof data entry -->
		</div>
		<!-- eof plays block -->
