<?php
include('includes/modules/corner/header.php');
?>
	<!-- BOF BODY -->
	<div class="body_container">
<?php
include('includes/modules/corner/menu.php');
?>
		<!-- bof blog -->
		<div class="right_container">
<?php
include('includes/modules/corner/blog_entry.php');
?>

			<!-- bof data entry -->
			<form name="blog_comment" method="post" onSubmit="return validate_comment(this);" action="<?php echo $href_action; ?>">
			<table border="0" cellspacing="0" cellpadding="0" width="370">
			<tr><td colspan="2" class="menu_category">Post a Comment</td></tr>
			<tr>
				<td class="formLabel">Name:<span class="required">*</span></td>
				<td class="formText"><?php echo draw_text_input_element('name', '', 35, 30, $name, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel">Email:</td>
				<td class="formText"><?php echo draw_text_input_element('email', '', 43, 96, $email, 'validate_string(\'email\', this);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel" valign="top">Comment:<span class="required">*</span></td>
				<td class="formText"><?php echo draw_textarea_element('comment', '', 40, 8, '', 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="required">*Required</td>
				<td class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Post'); ?></td>
			</tr>
			<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
			</table>
			</form>
			<!-- eof data entry -->
		</div>
		<!-- eof blog -->
	</div>
	<!-- EOF BODY -->
