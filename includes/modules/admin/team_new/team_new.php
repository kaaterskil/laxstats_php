	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="team" method="post" onSubmit="return validate_team(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="400">
		<tr>
			<td colspan="2" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('');"><?php draw_image('images/b_info1.png'); ?></a></span>
				<span>team info</span>
			</td>
		</tr>
		<tr>
			<td width="94" class="form_label2">Town/School:<span class="required">*</span></td>
			<td width="294" class="form_text2"><?php echo draw_text_input_element('town', '', 30, 22, $town, 'validate_string(\'text\', this):'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Team Name:</td>
			<td class="form_text2"><?php echo draw_text_input_element('team_name', '', 30, 20, $team_name, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Abbrev:</td>
			<td class="form_text2"><?php echo draw_text_input_element('short_name', '', 6, 3, $short_name, 'validate_string(\'text\', this); uppercase(this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Gender:<span class="required">*</span></td>
			<td class="form_text2"><?php draw_team_gender_select($gender); ?>
		</td>
		</tr>
		<tr>
			<td class="formLabel">Letter:<span class="required">*</span></td>
			<td class="formText"><?php draw_team_type_select($type); ?></td>
		</tr>
		<tr><td colspan="2" height="1" class="divider2"></td></tr>
		<tr><td colspan="4" height="1" class="chartTitleC">ORGANIZATION</td></tr>
		<tr>
			<td class="form_label2">State:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_state_select('state', $state_abbrev); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Conference:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('conference', '', 25, 20, $conference, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">League:</td>
			<td class="form_text2"><?php echo draw_text_input_element('league', '', 25, 20, $league, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Division:</td>
			<td class="form_text2"><?php echo draw_text_input_element('division', '', 6, 3, $division, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="required">*Required<?php echo draw_hidden_input_element('teamMasterRef', $teamMasterRef); ?></td>
			<td class="buttonText"><?php echo draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
		</table>
		</form>
	</div>
	<!-- EOF BODY -->
