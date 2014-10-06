<?php
if(isset($game)){
	$date			= $game->field['date'];
	$usTeamRef		= $game->field['usTeamRef'];
	$themTeamRef	= $game->field['themTeamRef'];
	$fieldRef		= $game->field['fieldRef'];
	$time			= $game->field['time'];
	$referee		= $game->field['referee'];
	$umpire			= $game->field['umpire'];
	$field_judge	= $game->field['fieldJudge'];
	$post_season	= $game->field['seasonType'];
	$conference		= $game->field['conference'];
	$weather		= $game->field['conditions'];
	$scorekeeper	= $game->field['scorekeeper'];
	$timekeeper		= $game->field['timekeeper'];
	$us_team		= $game->field['us_team'];
	$them_team		= $game->field['them_team'];
	$us_town		= $game->field['us_town'];
	$them_town		= $game->field['them_town'];
	$field_name		= $game->field['field_name'];
	$field_town		= $game->field['field_town'];
}
$exhibition			= ($conference == 'T' ? 'F' : 'T');
$game_timestamp		= strtotime($date) + $time;
$game_date			= date('m/d/y', $game_timestamp);
$game_time			= date('G:i', $game_timestamp);
$season_check		= ($post_season == 'T' ? '&radic;' : '');
$conference_check	= ($conference == 'T' ? '&radic;' : '');
?>
		<!-- bof game block -->
		<div class="block_container">
			<div class="chartTitleC">Game Information</div>
			<!-- bof data display -->
			<div class="left_container">
				<table border="0" cellpadding="0" cellspacing="0" width="450">
				<tr>
					<td colspan="4" class="chartHeaderC">date</td>
					<td class="divider"></td>
					<td class="chartHeaderL">home</td>
					<td class="divider"></td>
					<td class="chartHeaderL">visitor</td>
					<td class="divider"></td>
					<td colspan="2" class="chartHeaderL">field</td>
				</tr>
				<tr>
					<td class="divider"></td>
					<td colspan="3" class="chartC"><?php echo $game_date; ?></td>
					<td class="divider"></td>
					<td class="chartL"><?php echo $us_town; ?></td>
					<td class="divider"></td>
					<td class="chartL"><?php echo $them_town; ?></td>
					<td class="divider"></td>
					<td class="chartL"><?php echo $field_name; ?></td>
					<td class="divider"></td>
				</tr>
				<tr>
					<td colspan="4" class="chartHeaderC">time</td>
					<td class="divider"></td>
					<td class="chartHeaderL">referee</td>
					<td class="divider"></td>
					<td class="chartHeaderL">umpire</td>
					<td class="divider"></td>
					<td colspan="2" class="chartHeaderL">field judge</td>
				</tr>
				<tr>
					<td class="divider"></td>
					<td colspan="3" class="chartC"><?php echo $game_time; ?></td>
					<td class="divider"></td>
					<td class="chartL"><?php echo $referee; ?></td>
					<td class="divider"></td>
					<td class="chartL"><?php echo $umpire; ?></td>
					<td class="divider"></td>
					<td class="chartL"><?php echo $field_judge; ?></td>
					<td class="divider"></td>
				</tr>
				<tr>
					<td colspan="2" class="chartHeaderC">post</td>
					<td class="divider"></td>
					<td class="chartHeaderC">conf</td>
					<td class="divider"></td>
					<td class="chartHeaderL">conditions</td>
					<td class="divider"></td>
					<td class="chartHeaderL">scorekeeper</td>
					<td class="divider"></td>
					<td colspan="2" class="chartHeaderL">timekeeper</td>
				</tr>
				<tr>
					<td width="1" class="divider"></td>
					<td width="30" class="chartC"><?php echo $season_check; ?></td>
					<td width="1" class="divider"></td>
					<td width="30" class="chartC"><?php echo $conference_check; ?></td>
					<td width="1" class="divider"></td>
					<td width="118" class="chartL"><?php echo $weather; ?></td>
					<td width="1" class="divider"></td>
					<td width="118" class="chartL"><?php echo $scorekeeper; ?></td>
					<td width="1" class="divider"></td>
					<td width="118" class="chartL"><?php echo $timekeeper; ?></td>
					<td width="1" class="divider"></td>
				</tr>
				<tr><td colspan="11"><a href="<?php echo $href_edit_game; ?>"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a> Edit game</td></tr>
				</table>
			</div>
			<!-- eof data display -->
			
			<!-- bof data entry -->
			<div class="right_container">
				<form name="game" method="post" onSubmit="return validate_game(this);" action="<?php echo $href_action_game; ?>">
				<table border="0" cellspacing="0" cellpadding="0" width="295">
				<tr>
					<td colspan="2" class="chartTitle2">
						<span class="information"><a href="#" onClick="openInfo('gameEntry');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
						<span>Modify Game Information</span>
					</td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Date:<span class="required">*</span></td>
					<td width="189" class="formText2"><?php echo draw_text_input_element('game_date', '', 13, 10, $edit_game_date, 'validate_game_date(this);'); ?></td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Time:<span class="required">*</span></td>
					<td width="189" class="formText2"><?php echo draw_text_input_element('game_time', '', 13, 10, $edit_game_time, 'validate_time(this)'); ?></td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Field:<span class="required">*</span></td>
					<td width="189" class="formText2"><?php echo draw_game_field_select('fieldRef', $edit_fieldRef, 'validate_select(this, 1);'); ?></td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Season:</td>
					<td width="189" class="formText2"><?php echo draw_checkbox_input_element('post_season', '', 'Post-season', 'T', $edit_post_season); ?></td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Game Type:</td>
					<td width="189" class="formText2"><?php echo draw_checkbox_input_element('exhibition', '', 'Non-conference', 'T', $edit_exhibition); ?></td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Weather:</td>
					<td width="189" class="formText2"><?php echo draw_text_input_element('weather', '', 20, 20, $edit_weather, 'validate_string(\'text\', this)'); ?></td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Referee:</td>
					<td width="189" class="formText2"><?php echo draw_text_input_element('referee', '', 20, 20, $edit_referee, 'validate_string(\'text\', this)'); ?></td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Umpire:</td>
					<td width="189" class="formText2"><?php echo draw_text_input_element('umpire', '', 20, 20, $edit_umpire, 'validate_string(\'text\', this)'); ?></td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Field Judge:</td>
					<td width="189" class="formText2"><?php echo draw_text_input_element('field_judge', "", 20, 20, $edit_field_judge, 'validate_string(\'text\', this)'); ?></td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Scorekeeper:</td>
					<td width="189" class="formText2"><?php echo draw_text_input_element('scorekeeper', '', 20, 20, $edit_scorekeeper, 'validate_string(\'text\', this)'); ?></td>
				</tr>
				<tr>
					<td width="94" class="formLabel2">Timekeeper:</td>
					<td width="189" class="formText2"><?php echo draw_text_input_element('timekeeper', '', 20, 20, $edit_timekeeper, 'validate_string(\'text\', this)'); ?></td>
				</tr>
				<tr>
					<td width="94" class="required">*Required</td><?php echo draw_hidden_input_element('season', $edit_season); ?>
					<td width="189" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
				</tr>
				<tr><td colspan="2" class="error"><?php echo $game_message; ?></td></tr>
				</table>
				</form>
			</div>
			<!-- eof data entry -->
		</div>
		<!-- eof game block -->
