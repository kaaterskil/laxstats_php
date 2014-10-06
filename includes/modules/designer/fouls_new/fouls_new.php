	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="fouls" method="post" onSubmit="return validate_foul(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="340">
		<tr><td colspan="3" class="chartTitleC">INPUT</td></tr>
		<tr>
			<td class="form_label2">Description:<span class="required">*</span></td>
			<td colspan="2" class="form_text2"><?php echo draw_text_input_element('description', '', 30, 20, $description, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Type:</td>
			<td class="form_text2"><?php echo draw_radio_input_element('type', '', 'Personal', 'P', $type); ?></td>
			<td class="form_text2"><?php echo draw_radio_input_element('type', '', 'Team', 'T', $type); ?></td>
		</tr>
		<tr>
			<td class="form_label2"></td>
			<td colspan="2" class="form_text2"><?php echo draw_checkbox_input_element('releasable', '', 'Releasable', 'T', $releasable); ?></td>
		</tr>
		<tr>
			<td class="required">*Required</td>
			<td><?php echo draw_hidden_input_element('foulRef', $recordID); ?></td>
			<td class="buttonText"><?php echo draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="3" class="error"><?php echo $message; ?></td></tr>
		</table>
		</form>
	</div>
	<!-- EOF BODY -->
