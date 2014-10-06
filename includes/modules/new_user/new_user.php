	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="header">NEW USER REGISTRATION</div>
	</div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<!-- bof data entry -->
		<table border="0" cellpadding="0" cellspacing="0" width="450">
		<form name="new_user" method="post" onSubmit="return validate_user(this);" action="<?php echo $href_action; ?>">
		<tr><td colspan="2" class="chartTitleC">New User Registration</td></tr>
		<tr>
			<td width="184" class="form_label2">First Name:<span class="required">*</span></td>
			<td width="254" class="form_text2"><?php echo draw_text_input_element('first_name', '', 20, 20, $first_name, 'validate_string(\'text\', this);'); ?></td>
		<tr>
			<td class="form_label2">Last Name:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('last_name', '', 20, 20, $last_name, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Team affiliation:<span class="required">*</span></td>
			<td class="form_text2"><?php draw_team_select2('teamMasterRef', $teamMasterRef, 'test_selected_team(this.options[this.selectedIndex].value);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Telephone:</td>
			<td class="form_text2"><?php echo draw_text_input_element('telephone', '', 20, 140, $telephone, 'validate_string(\'telephone\', this); telephone_format(this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Email address:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('email', '', 35, 96, $email, 'validate_string(\'email\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Re-enter email address:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('email2', '', 35, 96, '', 'validate_string(email2, this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Desired username:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('username', '', 20, 15, $username, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Password (up to 8 characters):<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_password_input_element('password', '', 12, 8, $password, 'validate_string(\'text\', this);'); ?></td>
		</tr>
			<tr>
			<td class="form_label2">Re-enter password:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_password_input_element('password2', '', 12, 8, '', 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="required">* Required</td>
			<td class="buttonText"><?php echo draw_submit_button('save', 'Submit'); ?></td>
		</tr>
		<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
		</form>
		</table>
		<!-- eof data entry -->
		
		<!-- bof text -->
		<div class="commentary">
			<p><b>Questions?</b></p>
			<p><b>Q: Why do I need a team affiliation?<br>
			A:</b> Data integrity is a big thing around statistics. We don't think it's a good idea to have more than one or two people entering data for a team because it increases the probability of duplicate information and bad data, and erodes security.</p>
			<p><b>Q: Why so strict?<br>
			A:</b> Well, we feel that the only value this website has to offer is its ability to report information in a way that improves the sport's appeal and each player's ability. While sport statistics can be interesting, fun, and something to learn from, what comes out of the system is only as good as what goes in. The data needs to be as accurate as possible. Oh, and by the way, eat your peas.</p>
			<p><b>Q: What if I don't see my town on the list?<br>
			A:</b> We'd be thrilled if you joined us! More participation means we'll be able to provide more cool stuff. Just contact our <a href="mailto:questions@laxstats.net">webmaster</a> and they'll add you to the community.</p>
			<p><b>Q: Why do you need to know so much about me?<br>
			A:</b> If we feel that someone might be abusing the system, we'd like to be able to follow up. This protects everyone who uses the site, including you. So be a team player, dude, and don't write something bogus.</p>
		</div>
		<!-- eof text -->
	</div>
	<!-- EOF BODY -->
