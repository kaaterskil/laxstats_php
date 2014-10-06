		<!-- bof clears block -->
		<div class="block_container">
			<div class="chartTitleC">Clears</div>
			<!-- bof data display -->
			<div class="left_container">
				<table border="0" cellpadding="0" cellspacing="0" width="450">
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
					<td width="107" class="chartHeaderC">Team</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">C</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">F</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">C</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">F</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">C</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">F</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">C</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">F</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">C</td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartHeaderC">F</td>
					<td width="1" class="divider4"></td>
				</tr>
<?php
for($i = 0; $i < 2; $i++){
	if($i == 0){
		$teamRef = $usTeamRef;
		$town = $us_town;
	}else{
		$teamRef = $themTeamRef;
		$town = $them_town;
	}
	$clears = get_game_clear_data($gameRef, $teamRef);
	if(count($clears->result['reference']) > 0){
		$row = 0;
		while(!$clears->eof){
			$recordID = $clears->field['reference'];
			$clearedQ1 = $clears->field['clearedQ1'];
			$clearedQ2 = $clears->field['clearedQ2'];
			$clearedQ3 = $clears->field['clearedQ3'];
			$clearedQ4 = $clears->field['clearedQ4'];
			$clearedOT = $clears->field['clearedOT'];
			$failedQ1 = $clears->field['failedQ1'];
			$failedQ2 = $clears->field['failedQ2'];
			$failedQ3 = $clears->field['failedQ3'];
			$failedQ4 = $clears->field['failedQ4'];
			$failedOT = $clears->field['failedOT'];
			
			$clearedQ1 = ($clearedQ1 > 0 ? $clearedQ1 : '-');
			$clearedQ2 = ($clearedQ2 > 0 ? $clearedQ2 : '-');
			$clearedQ3 = ($clearedQ3 > 0 ? $clearedQ3 : '-');
			$clearedQ4 = ($clearedQ4 > 0 ? $clearedQ4 : '-');
			$clearedOT = ($clearedOT > 0 ? $clearedOT : '-');
			$failedQ1 = ($failedQ1 > 0 ? $failedQ1 : '-');
			$failedQ2 = ($failedQ2 > 0 ? $failedQ2 : '-');
			$failedQ3 = ($failedQ3 > 0 ? $failedQ3 : '-');
			$failedQ4 = ($failedQ4 > 0 ? $failedQ4 : '-');
			$failedOT = ($failedOT > 0 ? $failedOT : '-');
			
			$background = set_background($row);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=dcl';
			$href_delete = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
			$params = 'gr='.$gameRef.'&tr='.$teamRef.'&r='.$recordID.'&a=ecl';
			$href_edit = set_href(FILENAME_ADMIN_GAME_EDIT, $params);
?>
				<tr class="<?php echo $background; ?>">
					<td width="1" class="divider"></td>
					<td width="28" class="chartC">
						<a href="#" onClick="set_action('<?php echo $href_delete; ?>',true);"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
						<a href="#" onClick="set_action('<?php echo $href_edit; ?>',false);"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
					</td>
					<td width="1" class="divider"></td>
					<td width="107" class="chartL"><?php echo $town; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $clearedQ1; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $failedQ1; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $clearedQ2; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $failedQ2; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $clearedQ3; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $failedQ3; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $clearedQ4; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $failedQ4; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $clearedOT; ?></td>
					<td width="1" class="divider"></td>
					<td width="23" class="chartC"><?php echo $failedOT; ?></td>
					<td width="1" class="divider"></td>
				</tr>
<?php			
			$row++;
			$clears->move_next();
		}
	}else{
?>
				<tr>
					<td width="1" class="divider"></td>
					<td colspan="23" class="chartL3">No <?php echo ucwords($town) ?> clears have been entered yet.</td>
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
$param1 = ($edit_teamRef6 != $themTeamRef ? ' checked="checked"' : '');
$param2 = ($edit_teamRef6 != $themTeamRef ? '' : ' checked="checked"');
$team_select = ($edit_teamRef6 != $themTeamRef ? 'home' : 'visitor');
?>
			<div class="right_container">
				<form name="clear" method="post" onSubmit="set_offsetY(this); validate_clear(this);" action="<?php echo $href_action_clear; ?>">
				<table border="0" cellspacing="0" cellpadding="0" width="295">
				<tr>
					<td colspan="7" class="chartTitle2">
						<span class="information"><a href="#" onClick="openInfo('addSave');"><?php echo draw_image('images/b_info3.png'); ?></a></span>
						<span>Team Clears Input</span>
					</td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Team:<span class="required">*</span></td>
					<td colspan="3" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Home', 'home', $team_select, $param1); ?></td>
					<td colspan="3" class="formLabel2"><?php echo draw_radio_input_element('team', '', 'Visitor', 'visitor', $team_select, $param2); ?></td>
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
					<td width="79" class="formLabel2">Cleared:</td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va1', '', 2, 2, $edit_clearedQ1, 'get_total(document.clear);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va2', '', 2, 2, $edit_clearedQ2, 'get_total(document.clear);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va3', '', 2, 2, $edit_clearedQ3, 'get_total(document.clear);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('va4', '', 2, 2, $edit_clearedQ4, 'get_total(document.clear);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vaOT', '', 2, 2, $edit_clearedOT, 'get_total(document.clear);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vaT', '', 2, 2, $edit_tot_cleared, 'get_total(document.clear);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="formLabel2">Failed:</td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb1', '', 2, 2, $edit_failedQ1, 'get_total(document.clear);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb2', '', 2, 2, $edit_failedQ2, 'get_total(document.clear);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb3', '', 2, 2, $edit_failedQ3, 'get_total(document.clear);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vb4', '', 2, 2, $edit_failedQ4, 'get_total(document.clear);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vbOT', '', 2, 2, $edit_failedOT, 'get_total(document.clear);'); ?></td>
					<td width="29" class="formText2"><?php echo draw_text_input_element('vbT', '', 2, 2, $edit_tot_failed, 'get_total(document.clear);'); ?></td>
				</tr>
				<tr>
					<td width="79" class="required">*Required</td><?php echo draw_hidden_input_element('usTeamRef', $usTeamRef), draw_hidden_input_element('themTeamRef', $themTeamRef), draw_hidden_input_element('offsetY', $offsetY); ?>
					<td colspan="6" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
				</tr>
				<tr><td colspan="7" class="error"><?php echo $clear_message; ?></td></tr>
				</table>
				</form>
			</div>
			<!-- eof data entry -->
		</div>
		<!-- eof clears block -->
