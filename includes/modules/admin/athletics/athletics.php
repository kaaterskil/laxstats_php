	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="athletic" method="post" onSubmit="return validate_athletic(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="490">
		<tr><td colspan="2" class="chartTitleC">
			<div class="information"><a href="#" onClick="openInfo('athletics');"><?php echo draw_image('images/b_info1.png'); ?></div>
			<div>athletic activity</div>
		</td></tr>
		<tr>
			<td class="form_label2">Date:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('date', '', 12, 10, $date, 'validate_date(this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">School Year:</td>
			<td class="form_text2"><?php echo draw_school_year_select('year', $year); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Sport:</td>
			<td class="form_text2"><?php echo draw_sport_select('sport', $sport, 'toggle_label(this.options[this.selectedIndex].value);'); ?></td>
		</tr>
		<tr><td colspan="2" class="formLabel" id="description"><?php echo $description_label; ?></td></tr>
		<tr>
			<td class="form_label2"></td>
			<td class="form_text2"><?php echo draw_textarea_element('description', '', 50, 8, $description, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="required">*Required</td>
			<td class="buttonText"><?php echo draw_hidden_input_element('recordID', $recordID), draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
		</table>
		</form>
	</div>
	<!-- EOF BODY -->
