	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="header">FAN REGISTRATION</div>
	</div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<!-- bof text block -->
		<div class="letterContainer">
			<p class="letterText">Signing up keeps you connected to your team and gives the coach the opportunity to contact you with schedule changes, news or important communication. Rest assured that Laxstats won't share your information with anyone else or send you anything annoying - that's not our style. If you have any questions, see our <a href="<?php echo $href_privacy; ?>">privacy policy</a>.</p>
			<p class="letterText"><b>To register</b>, please enter information in the following form and click the Submit button. You don't need to give us any more information than what what you want, but know that your team's booster coordinators may want to be able to talk with you! At a minimum, required fields are shown with a red asterisk.</p>
			<p class="letterText"><b>To remove your name</b> from the fan list, please email the <a href="mailto:<?php echo COMPANY_EMAIL_ADDRESS; ?>">webmaster</a> with a request to be removed and include your name and team affiliation.</p>
		</div>
		<!-- eof text block -->
		
		<!-- bof registration form -->
		<div class="signIn">
			<form name="fan" method="post" onSubmit="return validate_fan(this);" action="<?php echo $href_action; ?>">
			<table border="0" cellspacing="0" cellpadding="0" width="450">
			<tr><td colspan="2" class="chartTitleC">Fan Registration</td></tr>
			<tr>
				<td class="form_label2">First Name:<span class="required">*</span></td>
				<td class="form_text2"><?php echo draw_text_input_element('first_name', '', 25, 20, $first_name, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Last Name:<span class="required">*</span></td>
				<td class="form_text2"><?php echo draw_text_input_element('last_name', '', 25, 20, $last_name, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Street:</td>
				<td class="form_text2"><?php echo draw_text_input_element('street1', '', 35, 30, $street1, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2"></td>
				<td class="form_text2"><?php echo draw_text_input_element('street2', '', 35, 30, $street2, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">City:</td>
				<td class="form_text2"><?php echo draw_text_input_element('city', '', 25, 20, $city, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">State:</td>
				<td class="form_text2"><?php draw_state_select('state', $state); ?></td>
			</tr>
			<tr>
				<td class="form_label2">ZIP Code:</td>
				<td class="form_text2"><?php echo draw_text_input_element('zip_code', '', 12, 10, $ZIP_Code, 'validate_string(\'ZIP_Code\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Telephone:</td>
				<td class="form_text2"><?php echo draw_text_input_element('telephone', '', 15, 12, $telephone, 'validate_string(\'telephone\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">email:<span class="required">*</span></td>
				<td class="form_text2"><?php echo draw_text_input_element('email', '', 40, 100, $email, 'validate_string(\'email\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Team affiliation:<span class="required">*</span></td>
				<td class="form_text2"><?php draw_team_select2('teamMasterRef', $teamMasterRef, ''); ?></td>
			</tr>
			<tr>
				<td class="required">*Required</td>
				<td class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Submit'); ?></td>
			</tr>
			<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
			</table>
			</form>
		</div>
		<!-- eof registration form -->
	</div>
	<!-- EOF BODY -->
