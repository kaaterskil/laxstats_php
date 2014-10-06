	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="player" method="post" enctype="multipart/form-data" onSubmit="return validate_player(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="520">
		<tr>
			<td colspan="4" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('playerEntry2');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>PERSONAL INFORMATION</span>
			</td>
		</tr>
		<tr>
			<td class="form_label2">Jersey No:<span class="required">*</span></td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('jerseyNo', '', 5, 3, $jerseyNo, 'validate_string(\'jerseyNo\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Last Name:<span class="required">*</span></td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('last_name', '', 25, 20, $last_name, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">First Name:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('first_name', '', 25, 20, $first_name, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td width="94" class="form_label2">Position:<span class="required">*</span></td>
			<td width="214" class="form_text2"><?php draw_position_select('position', $position); ?></td>
			<td width="64" class="form_label2">Depth:</td>
			<td width="124" class="form_text2"><?php draw_depth_select('depth', $depth); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Class:</td>
			<td class="form_text2"><?php echo draw_text_input_element('class', '', 6, 4, $class, 'validate_string(\'year\', this)'); ?></td>
			<td colspan="2" class="form_text2"><?php echo draw_checkbox_input_element('captain', '', $season.' captain', 'T', $captain); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Height:</td>
			<td class="form_text2"><?php echo draw_text_input_element('height', '', 6, 4, $height, 'validate_string(\'text\', this);'); ?></td>
			<td class="form_label2">Weight:</td>
			<td class="form_text2"><?php echo draw_text_input_element('weight', '', 6, 3, $weight, 'validate_string(\'integer\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Birthdate:</td>
			<td class="form_text2"><?php echo draw_text_input_element('birthdate', '', 12, 10, $birthdate, 'validate_date(this);'); ?></td>
			<td class="form_label2">Hand:</td>
			<td class="form_text2"><?php echo draw_hand_select('hand', $hand); ?></td>
		</tr>
		<tr>
			<td class="form_label2">School:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('school', '', 35, 30, $school, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Counselor:</td>
			<td class="form_text2"><?php echo draw_text_input_element('counselor', '', 35, 30, $counselor, 'validate_string(\'text\', this);'); ?></td>
			<td class="form_label2">Phone:</td>
			<td class="form_text2"><?php echo draw_text_input_element('telephone_counselor', '', 20, 14, $telephone_counselor, 'validate_string(\'telephone\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Upload Photo:</td>
			<td colspan="3" class="form_text2"><?php echo draw_upload_input_element('photo', 45, 120, 'photo'); ?></td>
		</tr>
		<tr><td colspan="4" height="10" class="divider2"></td></tr>
		<tr><td colspan="4" class="chartTitleC">COLLEGE</td></tr>
		<tr>
			<td class="form_label2">College:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('college', '', 35, 30, $college, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Link:</td>
			<td colspan="4" class="form_text2"><?php echo draw_text_input_element('college_link', '', 45, 100, $college_link, 'validate_string(\'url\', this);'); ?></td>
		</tr>
		<tr><td colspan="4" height="10" class="divider2"></td></tr>
		<tr><td colspan="4" class="chartTitleC">CONTACT</td></tr>
		<tr>
			<td class="formLabel">Address:</td>
			<td colspan="3" class="formText"><?php echo draw_text_input_element('street1', '', 35, 30, $street1, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2"></td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('street2', '', 35, 30, $street2, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">City, State, ZIP:</td>
			<td class="form_text2"><?php echo draw_text_input_element('city', '', 25, 20, $city, 'validate_string(\'text\', this);'); ?></td>
			<td class="form_text2"><?php draw_state_select2('state', $state); ?></td>
			<td class="form_text2"><?php echo draw_text_input_element('ZIP_Code', '', 12, 10, $ZIP_Code, 'validate_string(\'ZIP_Code\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Home Phone:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('telephone_home', '', 20, 12, $telephone_home, 'validate_string(\'telephone\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">E-Mail:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('email_player', '', 45, 100, $email_player, 'validate_string(\'email\', this);'); ?></td>
		</tr>
		<tr><td colspan="4" height="10" class="divider2"></td></tr>
		<tr><td colspan="4" class="chartTitleC">PARENT / GUARDIAN INFORMATION</td></tr>
		<tr>
			<td class="form_label2">Name:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('parent', '', 35, 30, $parent, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">E-Mail:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('email_parent', '', 45, 100, $email_parent, 'validate_string(\'email\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2"></td>
			<td class="form_text2"><?php echo draw_checkbox_input_element('release', '', 'Release data to other coaches', 'Y', $release); ?></td>
			<td class="form_label2">Date:</td>
			<td class="form_text2"><?php echo draw_text_input_element('release_date', '', 15, 10, $release_date, 'validate_date(this);'); ?></td>
		</tr>
		<tr>
			<td class="required">*Required</td>
			<td><?php echo draw_hidden_input_element('playerRef', $playerRef), draw_hidden_input_element('playerMasterRef', $playerMasterRef), draw_hidden_input_element('teamRef', $teamRef), draw_hidden_input_element('teamMasterRef', $teamMasterRef); ?></td>
			<td colspan="2" class="buttonText"><?php echo draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('submit', 'Save'); ?></td>
		</tr>
		<tr><td colspan="4" class="error"><?php echo $message; ?></td></tr>
		</table>
		</form>
	</div>
	<!-- EOF BODY -->
