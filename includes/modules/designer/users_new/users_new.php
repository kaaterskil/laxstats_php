	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="user" method="post" onSubmit="return validate_user(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="430">
		<tr><td colspan="2" class="chartTitleC">USER ENTRY</td></tr>
		<tr>
			<td class="form_label2">Affiliation:</td>
			<td class="form_text2"><?php echo draw_affiliation_select('affiliation', $affiliation); ?></td>
		</tr>
		<tr>
			<td class="form_label2">First Name:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('first_name', '', 25, 20, $first_name, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Last Name:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('last_name', '', 25, 20, $last_name, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Telephone:</td>
			<td class="form_text2"><?php echo draw_text_input_element('telephone', '', 14, 12, $telephone, 'validate_string(\'telephone\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Email:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('email', '', 35, 96, $email, 'validate_string(\'email\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Username:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('username', '', 25, 20, $username, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Password:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('password', '', 10, 8, $password, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="required">* Required</td><?php echo draw_hidden_input_element('userRef', $userRef); ?>
			<td class="buttonText"><?php echo draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
		</table>
		</form>
	</div>
	<!-- EOF BODY -->
