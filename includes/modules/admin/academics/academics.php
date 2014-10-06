	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="academic" method="post" onSubmit="return validate_academic(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="490">
		<tr><td colspan="4" class="chartTitleC">
			<div class="information"><a href="#" onClick="openInfo('academics');"><?php draw_image('images/b_info1.png'); ?></a></div>
			<div>current school</div>
		</td></tr>
		<tr>
			<td class="form_label2">Date:<span class="required">*</span></td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('date', '', 12, 10, $date, 'validate_date(this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Year:</td>
			<td class="form_text2"><?php echo draw_school_year_select('year', $year); ?></td>
			<td class="form_label2">Semester:</td>
			<td class="form_text2"><?php echo draw_semester_select('semester', $semester); ?></td>
		</tr>
		<tr>
			<td class="form_label2">GPA:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('gpa', '', 7, 4, $gpa, 'validate_string(\'float\', this);'); ?> out of <?php echo draw_text_input_element('gpaMax', '', 7, 4, $gpaMax, 'validate_string(\'float\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Class rank:</td>
			<td colspan="3" class="form_text2"><?php echo draw_class_rank_select('rank', $rank); ?></td>
		</tr>
		<tr valign="top">
			<td class="form_label2">Honors Classes:</td>
			<td colspan="3" class="form_text2" valign="top"><?php echo draw_textarea_element('classes', '', 50, 6, $classes, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr valign="top">
			<td class="form_label2">Activities:</td>
			<td colspan="3" class="form_text2"><?php echo draw_textarea_element('activities', '', 50, 6, $activities, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr><td colspan="4" height="20" class="divider2"></td></tr>
		<tr><td colspan="4" class="chartTitleC">Post-graduation goals</td></tr>
		<tr>
			<td class="form_label2" valign="top">Goals/Major:</td>
			<td colspan="3" class="form_text2"><?php echo draw_text_input_element('major', '', 40, 40, $major, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2" valign="top">Intended Schools:</td>
			<td colspan="3" class="form_text2"><?php echo draw_textarea_element('colleges', '', 50, 6, $colleges, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="required">*Required</td>
			<td><?php echo draw_hidden_input_element('recordID', $recordID); ?></td>
			<td colspan="3" class="buttonText"><?php echo draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="4" class="error"><?php echo $message; ?></td></tr>
		</table>
		</form>
	</div>
	<!-- EOF BODY -->
