	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
<?php
if($record_id == 0){
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="note" method="post" onSubmit="return validate_note(this);" action="<?php echo $href_action; ?>">
		<!-- bof note header -->
		<table border="0" cellspacing="0" cellpadding="0" width="540">
		<tr><td colspan="4" class="chartTitleC">
			<div class="information"><a href="#" onClick="openInfo('academics');"><?php draw_image('images/b_info1.png'); ?></a></div>
			<div>Data Entry</div>
		</td></tr>
		<tr>
			<td width="104" class="form_label2">Date:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('date', '', 12, 10, $date, 'validate_date(this);'); ?></td>
			<td width="74" class="form_label2">Type:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_note_type_select('type', $type, 'select_note_form(this.options[this.selectedIndex].value);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2" valign="top">Contact:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('contact', '', 68, 255, $contact, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		</table>
		<!-- eof note header -->
		
		<!-- bof email -->
		<div id="email">
			<table border="0" cellspacing="0" cellpadding="0" width="540">
			<tr>
				<td width="104" class="form_label" valign="top">Send to:<span class="required">*</span></td>
				<td width="430"><?php echo draw_text_input_element('recipients', '', 68, 255, $recipients, 'validate_string(\'email\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2" valign="top"></td>
				<td class="form_label2">NOTE: You send an email to multiple recipients by typing a comma and a space between valid email addresses.</td>
			</tr>
			<tr>
				<td class="form_label" valign="top">Attachments:</td>
				<td><?php echo draw_checkbox_input_element('attachment1', '', 'Personal information', $attachment1, 'P'); ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo draw_checkbox_input_element('attachment2', '', 'Academic information and test scores', $attachment2. 'A'); ?></td>
			</tr>
			<tr>
				<td class="form_label2" valign="top"></td>
				<td class="form_text2"><?php echo draw_checkbox_input_element('attachment3', '', 'Athletic information and summary statistics', $attachment3, 'S'); ?></td>
			</tr>
			</table>
		</div>
		<!-- eof email -->
		
		<!-- bof note body -->
		<table border="0" cellspacing="0" cellpadding="0" width="540">
		<tr>
			<td width="104" class="form_label2" valign="top">Subject:<span class="required">*</span></td>
			<td width="424" colspan="2" class="form_text2"><?php echo draw_text_input_element('subject', '', 35, 30, $subject, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2" valign="top">Text:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_textarea_element('text', '', 55, 16, $text, 'validate_string(\'html_text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="required">*Required</td><?php echo draw_hidden_input_element('record_id', $record_id); ?>
			<td class="buttonText"><?php echo draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
		</table>
		<!-- eof note body -->
		</form>
	</div>
	<!-- EOF BODY -->
<?php
}else{
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="540">
		<tr>
			<td width="94" class="chartL">Created:</td>
			<td width="414" class="chartL"><?php echo $created; ?></td>
		</tr>
		<tr>
			<td width="94" class="chartL">Contact:</td>
			<td width="414" class="chartL"><?php echo $contact; ?></td>
		</tr>
		<tr>
			<td width="94" class="chartL">Email:</td>
			<td width="414" class="chartL"><?php echo $recipients; ?></td>
		</tr>
		<tr>
			<td width="94" class="chartL">Note Date:</td>
			<td width="414" class="chartL"><?php echo $date; ?></td>
		</tr>
		<tr>
			<td width="94" class="chartL">Type:</td>
			<td width="414" class="chartL"><?php echo $type; ?></td>
		</tr>
		<tr>
			<td width="94" class="chartL">Subject:</td>
			<td width="414" class="chartL"><b><?php echo $subject; ?></b></td>
		</tr>
		<tr valign="top">
			<td width="94" class="chartL">Text:</td>
			<td width="414" class="chartL"><?php echo $text2; ?></td>
		</tr>
<?php
	if($attachment_test){
?>
	<tr>
		<td width="94" class="chartL"></td>
		<td width="414" class="chartL"><a href="#" onClick="view_attachment('<?php echo $href_attachment; ?>');">Attachment</a></td>
	</tr>
<?php
	}
?>
		</table>
	</div>
	<!-- EOF BODY -->
<?php
}
?>
