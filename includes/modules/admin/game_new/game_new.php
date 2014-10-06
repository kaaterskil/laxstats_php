<?php
include(FILENAME_ADMIN_PAGE_HEADER);
?>
	<!-- BOF BODY -->
	<div>
		<!-- bof data entry -->
		<div class="body_container">
			<form name="new_game" method="post" onSubmit="return validate_game(this);" action="<?php echo $href_action; ?>">
			<table border="0" cellspacing="0" cellpadding="0" width="350">
			<tr><td colspan="3" class="chartTitleC2">
				<span class="information"><a href="#" onClick="openInfo('gameSetup');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>New Game Entry</span>
			</td></tr>
			<tr>
				<td width="114" class="formLabel2">Game date:<span class="required">*</span></td>
				<td width="224" class="formText2"><?php echo draw_text_input_element('date', '', 13, 10, $date, 'validate_game_date(this);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Time:<span class="required">*</span></td>
				<td class="formText2"><?php echo draw_text_input_element('start_time', '', 13, 10, $start_time, 'validate_time(this);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Field:<span class="required">*</span></td>
				<td class="formText2"><?php echo draw_game_field_select('fieldRef', $fieldRef, 'validate_select(this, 1);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Home team:<span class="required">*</span></td>
				<td class="formText2"><?php echo draw_team_select2('home_tmr', $home_tmr, 'validate_select(this, 2);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Visiting team:<span class="required">*</span></td>
				<td class="formText2"><?php echo draw_team_select2('visitor_tmr', $visitor_tmr, 'validate_select(this, 2);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Season:</td>
				<td class="formText2"><?php echo draw_checkbox_input_element('post_season', '', 'Post-season', 'T', $post_season); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Game type:</td>
				<td class="formText2"><?php echo draw_checkbox_input_element('exhibition', '', 'Non-conference', 'T', $exhibition); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Weather:</td>
				<td class="formText2"><?php echo draw_text_input_element('weather', '', 20, 20, $weather, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Referee:</td>
				<td class="formText2"><?php echo draw_text_input_element('referee', '', 20, 20, $referee, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Umpire:</td>
				<td class="formText2"><?php echo draw_text_input_element('umpire', '', 20, 20, $umpire, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Field judge:</td>
				<td class="formText2"><?php echo draw_text_input_element('field_judge', '', 20, 20, $field_judge, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Scorekeeper:</td>
				<td class="formText2"><?php echo draw_text_input_element('scorekeeper', '', 20, 20, $scorekeeper, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="formLabel2">Timekeeper:</td>
				<td class="formText2"><?php echo draw_text_input_element('timekeeper', '', 20, 20, $timekeeper, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="required">*Required<?php echo draw_hidden_input_element('season', $season); ?></td>
				<td class="buttonText"><?php echo draw_submit_button('submit', 'Save'); ?></td>
			</tr>
			<tr>
				<td colspan="2" class="error"><?php echo $message; ?></td>
			</tr>
			</table>
			</form>
		</div>
		<!-- eof data entry -->
		
		<!-- bof commentary -->
		<div class="text_container">
			<p><b>Questions?</b></p>
			<p><b>Q: What if I don't see the playing field on the list?</b><br>A: You can add a new one: <a href="<?php echo $href_fields; ?>">Click here.</a></p>
			<p><b>Q: What if I don't see either me or my opponent's team?</b><br>A: If you or your opponent aren't listed on the drop-down menus, or an error message says that there's no current roster, it means you gotta create them first. <a href="<?php echo $href_team_index; ?>">Click here</a> to create a team and/or build a roster. Then come back to this page to continue.</p>
			<p><b>Q: What if I'm setting up a future game and the date or playing time change?</b><br>A: No problem. While you need to specify a date and time when you initially create a game, you can change this information any time.</p>
			<p><b>Q: Wow, this form looks scary. Do I need to track all this information?</b><br>
			A: No! Different teams track different statistics. Minimum required information is shown with a <span style="color:#CC0000; ">red</span> asterisk. Everything else is optional.</p>
		</div>
		<!-- eof commentary -->
	</div>
	<!-- EOF BODY -->
