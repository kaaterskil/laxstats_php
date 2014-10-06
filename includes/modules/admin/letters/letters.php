	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="letter" method="post" onSubmit="return validate_letter(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="490">
		<tr><td colspan="4" class="chartTitleC">
			<div class="information"><a href="#" onClick="openInfo('academics');"><?php draw_image('images/b_info1.png'); ?></a></div>
			<div>recommendation</div>
		</td></tr>
		<tr>
			<td class="form_label2">Date:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('date', '', 12, 10, $date, 'validate_date(this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2"></td>
			<td class="form_text2"><?php echo draw_checkbox_input_element('current', '', 'Include in printable Profile', $current, 'T'); ?></td>
		</tr>
		<tr>
			<td class="form_label2" valign="top">Text:</td>
			<td class="form_text2"><?php echo draw_textarea_element('comments', '', 50, 20, $comments, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="required">*Required<?php echo draw_hidden_input_element('recordID', $recordID); ?></td>
			<td colspan="2" class="buttonText"><?php echo draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
		</table>
		</form>
	</div>
	<!-- EOF BODY -->
