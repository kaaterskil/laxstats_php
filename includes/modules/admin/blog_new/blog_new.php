	<!-- BOF HEADER -->
	<div class="popup_header" id="title1"><?php echo $page_header1; ?></div>
	<div class="popup_header" id="title2"><?php echo $page_header2; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="blog" method="post" enctype="multipart/form-data" onSubmit="return validate_blog(this);" action="<?php echo $href_action; ?>">
		<!-- bof data entry header -->
		<table border="0" cellspacing="0" cellpadding="0" width="520">
		<tr>
			<td colspan="4" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('blog2');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>INPUT</span>
			</td>
		</tr>
		<tr>
			<td width="84" class="form_label2">Date:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('date', '', 12, 10, $date, 'validate_date(this);'); ?></td>
			<td class="form_label2"> Type:</td>
			<td class="form_text2"><?php echo draw_blog_form_type_select('blog_type', $blog_type, 'select_form(this.options[this.selectedIndex].value);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Title:<span class="required">*</span></td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('title', '', 45, 40, $title, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		</table>
		<!-- eof data entry header -->
		
		<!-- bof email data entry -->
		<div id="email">
		<table border="0" cellspacing="0" cellpadding="0" width="520">
		<tr>
			<td width="84" rowspan="4" class="form_label2" valign="top">Send To:<span class="required">*</span></td>
			<td width="84" class="form_label2"><?php echo draw_checkbox_input_element('ePlayer', '', 'Players', 'T', $ePlayer); ?></td>
			<td class="form_label2"><?php echo draw_checkbox_input_element('eStaff', '', 'Staff', 'S', $eStaff); ?></td>
			<td class="form_label2"><?php echo draw_checkbox_input_element('eParent', '', 'Parents', 'P', $eParent); ?></td>
			<td class="form_text2"><?php echo draw_blog_email_select('eIndividual', $teamMasterRef, $teamRef, $eIndividual, 'add_email(this.options[this.selectedIndex].value);'); ?></td>
		</tr>
		<tr>
			<td colspan="2" class="form_label2"><?php echo draw_checkbox_input_element('eBooster', '', 'Fans and Boosters', 'B', $eBooster); ?></td>
			<td colspan="3" class="form_label2"><?php echo draw_checkbox_input_element('eAlumni', '', 'Alumni', 'A', $eAlumni); ?></td>
		</tr>
		<tr valign="top">
			<td class="form_label2">Others:</td>
			<td colspan="3" class="form_text2"><?php echo draw_textarea_element('eOther', '', 40, 2, $eOther, 'validate_string(\'email\', this);'); ?></td>
		</tr>
		<tr>
			<td colspan="4" class="form_label2">NOTE: You send an email to multiple recipients by typing a comma and a space between valid email addresses. By checking the above boxes, you don't need to re-enter anyone's email address in the "Other" field.</td>
		</tr>
		</table>
		</div>
		<!-- eof email data entry -->
		
		<!-- bof data entry -->
		<table border="0" cellspacing="0" cellpadding="0" width="520">
		<!--
		<tr>
			<td colspan="4" class="formLabel" align="right" valign="bottom">
				<span style="text-align:left; float:left; ">Text:<span class="required">*</span> (Type directly or cut and paste into the field)<br>To bold, highlight or italicize text, select text and click on a button.</span>
				<a href="#" onClick="bold_this();return false;"><?php //echo draw_image('images/b_bold.png'); ?></a>&nbsp;<a href="#" onClick="highlight_this();return false;"><?php //echo draw_image('images/b_highlight.png'); ?></a>&nbsp;<a href="#" onClick="italicize_this();return false;"><?php //echo draw_image('images/b_italic.png'); ?></a>
			</td>
		</tr>
		-->
		<tr>
			<td colspan="4" class="form_text2" style="padding:5px 0px 5px 0px; "><?php echo draw_textarea_element('blog_text', '', '70%', 18, $blog_text, 'validate_string(\'html_text\', this)'); ?></td>
		</tr>
		<tr>
			<td width="94" class="form_label2">Upload file:</td>
			<td colspan="3" class="form_text2" style="text-align:right; "><?php echo draw_upload_input_element('user_file', 50, 120, 'user_file'); ?></td>
		</tr>
		<tr>
			<td class="required">* Required</td>
			<td colspan="3" class="buttonText"><?php echo draw_hidden_input_element('blog_ref', $blog_ref), draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save_blog', 'Save'); ?></td>
		</tr>
		<tr><td colspan="4" class="error"><?php echo $message; ?></td></tr>
		</table>
		<!-- eof data entry -->
		</form>
	</div>
	<!-- EOF BODY -->
