<?php
include(FILENAME_ADMIN_PAGE_HEADER);
?>

	<!-- BOF BODY -->
	<!-- bof team info -->
	<div class="season_container">
		<table border="0" cellspacing="0" cellpadding="0" width="470">
		<tr><td colspan="4" class="buttonText"><?php echo draw_button('edit_team', 'Edit Team', 'onClick="edit_team(\''.$href_edit_team.'\');"'); ?></td></tr>
		<tr><td colspan="4" class="chartTitleC"><?php echo $season; ?> SEASON INFORMATION</td></tr>
		<tr>
			<td width="74" class="chartL">Town:</td>
			<td width="129" class="chartL3"><?php echo $town; ?></td>
			<td width="74" class="chartL">Name:</td>
			<td width="169" class="chartL3"><?php echo $team_name; ?></td>
		</tr>
		<tr>
			<td class="chartL">Gender:</td>
			<td class="chartL3"><?php echo $gender; ?></td>
			<td class="chartL">Letter:</td>
			<td class="chartL3"><?php echo $letter; ?></td>
		</tr>
		<tr>
			<td class="chartL">Conference:</td>
			<td class="chartL3"><?php echo $conference; ?></td>
			<td class="chartL">League:</td>
			<td class="chartL3"><?php echo $league; ?></td>
		</tr>
		<tr>
			<td class="chartL">Division:</td>
			<td class="chartL3"><?php echo $division; ?></td>
			<td class="chartL">Abbrev.:</td>
			<td class="chartL3"><?php echo $short_name; ?></td>
		</tr>
		</table>
	</div>
	<!-- eof team info -->
	
	<!-- bof staff info -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="750">
		<tr><td colspan="11" class="buttonText"><?php echo draw_button('add_staff', 'Add Staff', 'onClick="open_staff(\''.$href_new_staff.'\');"'); ?></td></tr>
		<tr>
			<td colspan="11" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('staffEntry1');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span><?php echo $season; ?> Staff</span>
			</td>
		</tr>
		<tr>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="103" class="chartHeaderC">title</td>
			<td width="1" class="divider"></td>
			<td width="143" class="chartHeaderC">name</td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartHeaderC">phone</td>
			<td width="1" class="divider"></td>
			<td width="307" class="chartHeaderC">email</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
if(isset($staff->result['reference'])){
	$row = 0;
	while(!$staff->eof){
		//get data
		$staffRef		= $staff->field['reference'];
		$staff_name		= $staff->field['name'];
		$telephone		= $staff->field['phone'];
		$extension		= $staff->field['phoneExt'];
		$telephone2		= $staff->field['phone2'];
		$email			= $staff->field['email'];
		$type			= intval($staff->field['type']);
		//process data
		$title = set_staff_short_title($type);
		if($telephone != ''){
			$telephone = ($extension != '' ? $telephone.' x'.$extension : $telephone);
		}elseif($telephone2 != ''){
			$telephone = $telephone2;
		}
		$background = set_background($row);
		//set links
		$params = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&sr='.$staffRef.'&a=ds';
		$href_delete = set_href(FILENAME_ADMIN_ROSTER, $params);
		$params = 'sr='.$staffRef.'&tmr='.$teamMasterRef.'&tr='.$teamRef.'&nmh=1';
		$href_edit = set_href(FILENAME_ADMIN_STAFF, $params);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="28" class="chartC">
				<a href="#" onClick="confirm_delete(1, '<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
				<a href="#" onClick="open_staff('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
			</td>
			<td width="1" class="divider"></td>
			<td width="103" class="chartL"><?php echo $title; ?></td>
			<td width="1" class="divider"></td>
			<td width="143" class="chartL"><?php echo $staff_name; ?></td>
			<td width="1" class="divider"></td>
			<td width="133" class="chartL"><?php echo $telephone; ?></td>
			<td width="1" class="divider"></td>
			<td width="307" class="chartL"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		$row++;
		$staff->move_next();
	}
}else{
?>
		<tr>
			<td width="1" class="divider"></td>
			<td colspan="9" class="chartL3" style="font-style:italic;">No staff have been set up yet.</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
}
?>
		<tr><td colspan="11" class="error"><?php echo $staff_message; ?></td></tr>
		</table>
	</div>
	<!-- eof staff info -->
	
	<!-- bof add player -->
	<div class="player_select_container">
		<div class="chartTitleC">
			<span class="information"><a href="#" onClick="openInfo('playerEntry1');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
			<span>Add Player</span>
		</div>
		<form name="select_player" method="post" onSubmit="return validate_player(this);" action="<?php echo $href_action_return; ?>">
		<!-- bof player selection -->
		<div class="add_player">
			<span class="formLabel">Player Type: </span>
			<span><?php echo draw_radio_input_element2('player_type', 'Returning', 'checked="checked" onClick="select_form();"'); ?></span>
			<span><?php echo draw_radio_input_element2('player_type', 'New', 'onClick="select_form(\''.$href_new_player.'\');"'); ?></span>
		</div>
		<!-- eof player selection -->
		<!-- bof returning player -->
		<div id="returning_player" class="add_player">
			<span class="formLabel">Player: </span>
			<span><?php draw_returning_player_select('playerRef', $teamMasterRef, $prior_year); ?></span>
			<span class="buttonText"><?php echo draw_hidden_input_element('teamRef', $teamRef), draw_submit_button('add_returning_player', 'Add Player'); ?></span><?php echo draw_hidden_input_element('teamRef', $teamRef), draw_hidden_input_element('teamMasterRef', $teamMasterRef); ?>
		</div>
		<!-- eof returning player -->
		</form>
		<div class="error"><?php echo $player_message; ?></div>
	</div>
	<!-- eof add player -->
	
	<!-- bof roster -->
	<div id="roster" class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="750">
		<tr>
			<td colspan="23" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('roster');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span><?php echo $season; ?> Roster</span>
			</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="28" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC">##</td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC">Pos</td>
			<td width="1" class="divider"></td>
			<td width="142" class="chartHeaderC">Name</td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC">Capt</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">Class</td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC">Ht</td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartHeaderC">Wt</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">Hand</td>
			<td width="1" class="divider"></td>
			<td width="93" class="chartHeaderC">Home Phone</td>
			<td width="1" class="divider"></td>
			<td width="183" class="chartHeaderC">email</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
if(isset($roster->result['playerMasterRef'])){
	$row = 0;
	while(!$roster->eof){
		//get data
		$playerRef			= $roster->field['reference'];
		$playerMasterRef	= $roster->field['playerMasterRef'];
		$first_name			= $roster->field['FName'];
		$last_name			= $roster->field['LName'];
		$jerseyNo			= $roster->field['jerseyNo'];
		$captain			= $roster->field['captain'];
		$position			= $roster->field['position'];
		$class				= $roster->field['class'];
		$height				= $roster->field['height'];
		$weight				= $roster->field['weight'];
		$hand				= $roster->field['dominantHand'];
		$player_telephone	= $roster->field['homePhone'];
		$player_email		= $roster->field['email'];
		//process data
		$player_name		= set_player_name($first_name, $last_name);
		$captain			= ($captain == 'T' ? '&radic;' : '');
		$weight				= ($weight > 0 ? strval($weight) : '');
		$hand				= set_dominant_hand($hand);
		$background			= set_background($row);
		//set links
		$param = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&pmr='.$playerMasterRef.'&a=dp';
		$href_delete = set_href(FILENAME_ADMIN_ROSTER, $param);
		$param = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&pr='.$playerRef.'&nmh=1&ct=0';
		$href_edit = set_href(FILENAME_ADMIN_PLAYER_NEW, $param);
		$param = 'tmr='.$teamMasterRef.'&s='.$season.'&pmr='.$playerMasterRef;
		$href_player = set_href(FILENAME_ADMIN_PLAYER, $param);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="28" class="chartC">
				<a href="#" onClick="confirm_delete(2, '<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
				<a href="#" onClick="open_player('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
			</td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC"><?php echo $jerseyNo; ?></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC"><?php echo $position; ?></td>
			<td width="1" class="divider"></td>
			<td width="142" class="chartL"><a href="<?php echo $href_player; ?>"><?php echo $player_name; ?></a></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC"><?php echo $captain; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><?php echo $class; ?></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC"><?php echo $height; ?></td>
			<td width="1" class="divider"></td>
			<td width="28" class="chartC"><?php echo $weight; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><?php echo $hand; ?></td>
			<td width="1" class="divider"></td>
			<td width="93" class="chartC"><?php echo $player_telephone; ?></td>
			<td width="1" class="divider"></td>
			<td width="183" class="chartL"><a href="mailto:<?php echo $player_email; ?>"><?php echo $player_email; ?></a></td>
			<td width="1" class="divider"></td>
		</tr>
<?php		
		$row++;
		$roster->move_next();
	}
}else{
?>
		<tr>
			<td width="1" class="divider"></td>
			<td colspan="21" class="chartL3" style="font-style:italic;">No players have been set up yet.</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
}
?>
		</table>
	</div>
	<!-- eof roster -->
	<!-- EOF BODY -->
