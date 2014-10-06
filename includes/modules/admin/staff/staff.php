	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="staff" method="post" onSubmit="return validate_staff(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="430">
		<tr>
			<td colspan="4" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('staffEntry2');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>STAFF INFORMATION</span>
			</td>
		</tr>
		<tr>
			<td class="form_label2">Name:<span class="required">*</span></td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('name', '', 23, 20, $name, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Position:<span class="required">*</span></td>
			<td colspan="3" class="form_text2"><?php echo draw_staff_type_select('staff_type', $staff_type); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Street:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('street1', '', 35, 30, $street1, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2"></td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('street2', '', 35, 30, $street2, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td width="94" class="form_label2">City, State, ZIP:</td>
			<td width="154" class="form_text2"><?php echo draw_text_input_element('city', '', 23, 20, $city, 'validate_string(\'text\', this);'); ?></td>
			<td width="64" class="form_text2"><?php echo draw_state_select2('state', $state); ?></td>
			<td width="94" class="form_text2"><?php echo draw_text_input_element('ZIP_Code', '', 11, 10, $ZIP_Code, 'validate_string(\'ZIP_Code\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Work Phone:</td>
			<td class="form_text2"><?php echo draw_text_input_element('telephone1', '', 16, 14, $telephone1, 'validate_string(\'telephone\', this); telephone_format(this);'); ?></td>
			<td class="form_label2">Ext.:</td>
			<td class="form_text2"><?php echo draw_text_input_element('extension', '', 6, 4, $extension, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Home Phone:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('telephone2', '', 16, 14, $telephone2, 'validate_string(\'telephone\', this); telephone_format(this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Email:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('email', '', 55, 96, $email, 'validate_string(\'email\', this);'); ?></td>
		</tr>
		<tr>
			<td class="required">* Required<?php echo draw_hidden_input_element('teamRef', $teamRef), draw_hidden_input_element('teamMasterRef', $teamMasterRef), draw_hidden_input_element('staffRef', $staffRef); ?></td>
			<td colspan="3" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="4" class="error"><?php echo $message; ?></td></tr>
		</table>
		</form>
	</div>
	<!-- EOF BODY -->
