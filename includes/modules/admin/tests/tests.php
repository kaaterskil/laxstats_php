	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="test" method="post" onSubmit="return validate_test(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="490">
		<tr>
			<td class="form_label2">Test:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_test_select('test', $test, 'change_test(\''.href_test.'\', this.options[this.selectedIndex].value);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Scores:</td>
			<td class="form_text2"><?php echo draw_subtest('subtest', $subtest); ?></td>
		</tr>
		<tr>
			<td class="required">*Required</td>
			<td class="buttonText"><?php echo draw_hidden_input_element('recordID', $recordID), draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
		</table>
		</form>
	</div>
	<!-- EOF BODY -->
