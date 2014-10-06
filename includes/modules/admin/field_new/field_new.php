	<!-- BOF HEADER -->
	<div class="popup_header"><?php echo $page_header; ?></div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div class="body_container">
		<form name="field" method="post" onSubmit="return validate_field(this);" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="420">
		<tr>
			<td colspan="3" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('fields');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>FIELD INFORMATION</span>
			</td>
		</tr>
		<tr>
			<td width="104" class="form_label2">State:<span class="required">*</span></td>
			<td width="304" class="form_text2"><?php draw_state_select('state', $state); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Town:<span class="required">*</span></td>
			<td class="form_text2"><?php echo draw_text_input_element('town', '', 25, 20, $town, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Name:</td>
			<td class="form_text2"><?php echo draw_text_input_element('name', '', 25, 20, $name, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="form_label2">Surface:</td>
			<td class="form_text2"><?php draw_surface_select('type', $type); ?></td>
		</tr>
		<tr>
			<td class="form_label2" style="vertical-align:top; ">Directions:</td>
			<td class="form_text2"><?php echo draw_textarea_element('directions', 'formText', 68, 15, $directions, 'validate_string(\'text\', this);'); ?></td>
		</tr>
		<tr>
			<td class="required">*Required</td><?php echo draw_hidden_input_element('fieldRef', $fieldRef); ?>
			<td class="buttonText"><?php echo draw_button('cancel', 'Cancel', 'onClick="close_window();"').'&nbsp;&nbsp;'.draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
		</tr>
		<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
		</table>		
		</form>
	</div>
	<!-- EOF BODY -->
