		<!-- bof faceoff block -->
		<div class="block_container">
			<div class="chartTitleC">Faceoffs</div>
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
				<tr><td colspan="25" height="1" class"divider"></td></tr>
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
					<td width="23" class="chartHeaderC">W</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">L</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">W</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">L</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">W</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">L</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">W</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">L</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">W</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">L</td>
					<td width="1" class="divider4"></td>
				</tr>
<?php
	$faceoffs = get_game_faceoff_data($gameRef, $teamRef);
	if(count($faceoffs->result['reference']) > 0){
		$tot_wonQ1 = 0;
		$tot_wonQ2 = 0;
		$tot_wonQ3 = 0;
		$tot_wonQ4 = 0;
		$tot_wonOT = 0;
		$tot_lostQ1 = 0;
		$tot_lostQ2 = 0;
		$tot_lostQ3 = 0;
		$tot_lostQ4 = 0;
		$tot_lostOT = 0;
		$row = 0;
		while(!$faceoffs->eof){
			$recordID = $faceoffs->field['reference'];
			$name = substr($faceoffs->field['LName'], 0, 12);
			$jerseyNo = $faceoffs->field['jerseyNo'];
			$wonQ1 = $faceoffs->field['wonQ1'];
			$wonQ2 = $faceoffs->field['wonQ2'];
			$wonQ3 = $faceoffs->field['wonQ3'];
			$wonQ4 = $faceoffs->field['wonQ4'];
			$wonOT = $faceoffs->field['wonOT'];
			$lostQ1 = $faceoffs->field['lostQ1'];
			$lostQ2 = $faceoffs->field['lostQ2'];
			$lostQ3 = $faceoffs->field['lostQ3'];
			$lostQ4 = $faceoffs->field['lostQ4'];
			$lostOT = $faceoffs->field['lostOT'];

			$tot_wonQ1 += $wonQ1;
			$tot_wonQ2 += $wonQ2;
			$tot_wonQ3 += $wonQ3;
			$tot_wonQ4 += $wonQ4;
			$tot_wonOT += $wonOT;
			$tot_lostQ1 += $lostQ1;
			$tot_lostQ2 += $lostQ2;
			$tot_lostQ3 += $lostQ3;
			$tot_lostQ4 += $lostQ4;
			$tot_lostOT += $lostOT;
			
			$wonQ1 = ($wonQ1 > 0 ? $wonQ1 : '-');
			$wonQ2 = ($wonQ2 > 0 ? $wonQ2 : '-');
			$wonQ3 = ($wonQ3 > 0 ? $wonQ3 : '-');
			$wonQ4 = ($wonQ4 > 0 ? $wonQ4 : '-');
			$wonOT = ($wonOT > 0 ? $wonOT : '-');
			$lostQ1 = ($lostQ1 > 0 ? $lostQ1 : '-');
			$lostQ2 = ($lostQ2 > 0 ? $lostQ2 : '-');
			$lostQ3 = ($lostQ3 > 0 ? $lostQ3 : '-');
			$lostQ4 = ($lostQ4 > 0 ? $lostQ4 : '-');
			$lostOT = ($lostOT > 0 ? $lostOT : '-');
			
			$background = set_background($row);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=dfo';
			$href_delete = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=efo';
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
					<td width="23" class="chartC"><?php echo $wonQ1; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $lostQ1; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $wonQ2; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $lostQ2; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $wonQ3; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $lostQ3; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $wonQ4; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $lostQ4; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $wonOT; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $lostOT; ?></td>
					<td width="1" class="divider"></td>
				</tr>
<?php
			$row++;
			$faceoffs->move_next();
		}
?>
				<tr>
					<td width="1" class="divider"></td>
					<td colspan="3" class="chartL"><b>Team</b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_wonQ1; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_lostQ1; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_wonQ2; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_lostQ2; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_wonQ3; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_lostQ3; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_wonQ4; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_lostQ4; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_wonOT; ?></b></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><b><?php echo $tot_lostOT; ?></b></td>
					<td width="1" class="divider"></td>
				</tr>
<?php
	}else{
?>
				<tr>
					<td width="1" class="divider"></td>
					<td colspan="23" class="chartL3">No faceoff information has been entered yet.</td>
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
$class1 = ($edit_teamRef5 != $themTeamRef ? 'drop_down_show' : 'drop_down_hide');
$class2 = ($edit_teamRef5 != $themTeamRef ? 'drop_down_hide' : 'drop_down_show');
$param1 = ($edit_teamRef5 != $themTeamRef ? ' checked="checked"' : '');
$param2 = ($edit_teamRef5 != $themTeamRef ? '' : ' checked="checked"');
$team_select = ($edit_teamRef5 != $themTeamRef ? 'home' : 'visitor');
?>
			<div class="right_container">
				<form name="faceoff" method="post" onSubmit="set_offsetY(this); validate_faceoff(this);" action="<?php echo $href_action_faceoff; ?>">
				<table border="0" cellspacing="0" cellpadding="0" width="295">
				<tr>
					<td colspan="7" class="chartTitle2">
						<span class="information"><a href="#" onClick="openInfo('addSave');"><?php echo draw_image('images/b_info3.png'); ?></a></span>
						<span>Faceoff Input</span>
					</td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Team:<span class="required">*</span></td>
					<td colspan="3" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Home', 'home', $team_select, 'onClick="toggle_roster(this, \'faceoff_roster_home\', \'faceoff_roster_visitor\');" '.$param1); ?></td>
					<td colspan="3" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Visitor', 'visitor', $team_select, 'onClick="toggle_roster(this, \'faceoff_roster_home\', \'faceoff_roster_visitor\')" '.$param2); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Player:<span class="required">*</span></td>
					<td colspan="5" class="formText2"><?php echo draw_game_player_select('roster_home', $home_roster, $edit_playerRef, 'validate_select(this, 2);', 'id="faceoff_roster_home" class="'.$class1.'"'), draw_game_player_select('roster_visitor', $visitor_roster, $edit_playerRef, 'validate_select(this, 2);', 'id="faceoff_roster_visitor" class="'.$class2.'"'); ?></td>
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
					<td width="79" class="formLabel2">Won:</td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va1', '', 2, 2, $edit_wonQ1, 'get_total(document.faceoff);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va2', '', 2, 2, $edit_wonQ2, 'get_total(document.faceoff);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va3', '', 2, 2, $edit_wonQ3, 'get_total(document.faceoff);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va4', '', 2, 2, $edit_wonQ4, 'get_total(document.faceoff);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vaOT', '', 2, 2, $edit_wonOT, 'get_total(document.faceoff);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vaT', '', 2, 2, $edit_tot_won, 'get_total(document.faceoff);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Lost:</td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb1', '', 2, 2, $edit_lostQ1, 'get_total(document.faceoff);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb2', '', 2, 2, $edit_lostQ2, 'get_total(document.faceoff);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb3', '', 2, 2, $edit_lostQ3, 'get_total(document.faceoff);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb4', '', 2, 2, $edit_lostQ4, 'get_total(document.faceoff);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vbOT', '', 2, 2, $edit_lostOT, 'get_total(document.faceoff);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vbT', '', 2, 2, $edit_tot_lost, 'get_total(document.faceoff);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="required">*Required</td><?php echo draw_hidden_input_element('usTeamRef', $usTeamRef), draw_hidden_input_element('themTeamRef', $themTeamRef), draw_hidden_input_element('offsetY', $offsetY); ?>
					<td colspan="6" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
				</tr>
				<tr><td colspan="7" class="error"><?php echo $faceoff_message; ?></td></tr>
				</table>
				</form>
			</div>
			<!-- eof data entry -->
		</div>
		<!-- eof faceoff block -->
