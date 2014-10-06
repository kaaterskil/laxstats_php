	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="new_season" method="post" onSubmit="return validate_season(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="300">
		<tr>
			<td colspan="4" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('newSeason');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>Season Info</span>
			</td>
		</tr>
		<tr>
			<td class="formLabel2">Town:</td>
			<td colspan="3" class="formLabel2"><?php echo $town; ?></td>
		</tr>
		<tr>
			<td class="formLabel2"></td>
			<td colspan="3" class="formLabel2"><?php echo $team_string; ?></td>
		</tr>
		<tr>
			<td class="formLabel2">Team Name:</td>
			<td colspan="3" class="formText2"><?php echo draw_text_input_element('name', '', 25, 20, $name, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td width="84" class="formLabel2">Season:</td>
			<td width="54" class="formText2"><?php echo draw_text_input_element('season', '', 5, 4, $season, 'validate_string(\'year\', this);'); ?></td>
			<td width="84" class="formLabel2">Division:</td>
			<td width="54" class="formText2"><?php echo draw_text_input_element('division', '', 5, 4, $division, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td><?php echo draw_hidden_input_element('teamMasterRef', $teamMasterRef), draw_hidden_input_element('teamRef', $teamRef), draw_hidden_input_element('town', $town), draw_hidden_input_element('short_name', $short_name), draw_hidden_input_element('type', $type); ?></td>
			<td colspan="3" class="buttonText"><?php echo draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="4" class="error"><?php echo $message; ?></td></tr>
		</table>
		</form>
	</div>
	<!-- EOF BODY -->
