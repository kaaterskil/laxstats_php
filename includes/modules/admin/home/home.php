	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="header"><?php echo $team_name; ?> MANAGER'S OFFICE</div>
		<div class="subheader" style="float:left; ">
			<a href="<?php echo $href_team_index; ?>">Full Team List</a> | 
			<a href="<?php echo $href_fields; ?>">Field List</a>
		</div>
		<div id="noteOpener">[ <a href="#" onClick="hideNote();">Collapse text</a> ]</div>
		<div id="noteCloser">[ <a href="#" onClick="showNote();">Show text</a> ]</div>
		<div id="noteBody">
			<p>Here is where you enter new games, edit unfinished ones and submit final stats to be included on the public side of the site. You can manage your team information, create new seasons, add and change players to your roster, and update field conditions and driving directions. To help your coaching duties, you can post notices, letters and reports to your blog, as well as design plays and drills for the Playbook. And the Player Profile is a rich area for player development where you can record notes and records of contacts and conversations, send emails and record a player's academic information for use with recruitment.</p>
			<p>You'll see that the top menu bar is different here in the Office. You'll find all you need to enter data and manage your team, your players, your blog, your private playbook, and any photos or media you want to upload. If you need to create an opposing team, there's a full team list you can link to.</p>
			<p>Data entry can be a little daunting: <i>"Um, what goes where?" "Do I have it right?" "Gee, there's alot of confusing stuff here!" "Do I need to enter stuff in ALL the boxes?"</i> Stay calm! We've added a help system to guide you in case you need it. Just click on one of those little question-mark icons and a window will pop-up with some helpful notes.</p>
			<p>This is a secure area, so the system will log you out after a certain period of inactivity.</p>
		</div>
	</div>
	<!-- EOF HEADER -->
	
	<!-- BOF BODY -->
	<div>
		<!-- bof unfinished games -->
		<div class="body_container">
			<div class="header">GAMES IN PROGRESS</div>
			<div class="subheader"><?php echo draw_image('images/b_drop.png', 10, 10); ?> Delete&nbsp;&nbsp;<?php echo draw_image('images/b_edit.png', 10, 10); ?> Edit&nbsp;&nbsp;<?php echo draw_image('images/b_submit.png', 10, 10); ?> Submit</div>
			<table border="0" cellpadding="0" cellspacing="0" width="660">
			<tr>
				<td colspan="15" height="1" class="chartTitleC">
					<span class="information"><a href="#" onClick="openInfo('games');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
					<span>Unfinished Games</span>
				</td>
			</tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="42" class="chartHeaderC"></td>
				<td width="1" class="divider"></td>
				<td width="68" class="chartHeaderC">date</td>
				<td width="1" class="divider"></td>
				<td width="63" class="chartHeaderC">time</td>
				<td width="1" class="divider"></td>
				<td width="123" class="chartHeaderL">home</td>
				<td width="1" class="divider"></td>
				<td width="123" class="chartHeaderL">visitor</td>
				<td width="1" class="divider"></td>
				<td width="123" class="chartHeaderL">field</td>
				<td width="1" class="divider"></td>
				<td width="68" class="chartHeaderC">modified</td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
if(isset($game_obj->result['gameRef'])){
	$row = 0;
	while(!$game_obj->eof){
		//get data
		$gameRef = $game_obj->field['gameRef'];
		$teamRef = $game_obj->field['teamRef'];
		$date = $game_obj->field['date'];
		$seconds = $game_obj->field['time_as_seconds'];
		$created = $game_obj->field['created'];
		$modified = $game_obj->field['modified'];
		$town = $game_obj->field['town'];
		$opponent = $game_obj->field['opponent'];
		$field_town = $game_obj->field['site'];
		$field_name = $game_obj->field['field_name'];
		//processs data
		$game_timestamp = strtotime($date) + $seconds;
		$game_date = date('m/d/Y', $game_timestamp);
		$game_time = date('g:i a', $game_timestamp);
		$field = set_team_name($field_town, $field_name);
		if($town == $field_town){
			$home = $town;
			$visitor = $opponent;
		}else{
			$home = $opponent;
			$visitor = $town;
		}
		$modified_date = date('m/d/Y', strtotime($modified));
		$background = set_background($row);
		//set links
		$param = 'gr='.$gameRef.'&a=v';
		$href_validate = set_href(FILENAME_ADMIN_USER_HOME, $param);
		$param = 'gr='.$gameRef;
		$href_edit = set_href(FILENAME_ADMIN_GAME_EDIT, $param);
		$param = 'gr='.$gameRef.'&a=dg';
		$href_delete = set_href(FILENAME_ADMIN_USER_HOME, $param);
?>
			<tr class="<?php echo $background; ?>">
				<td class="divider"></td>
				<td class="chartC">
					<a href="#" onClick="return confirmDelete(0, '<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
					<a href="<?php echo $href_edit; ?>"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
					<a href="#" onClick="return confirmSubmit('<?php echo $href_validate; ?>')"><?php echo draw_image('images/b_submit.png', 10, 10); ?></a>
				</td>
				<td class="divider"></td>
				<td class="chartC"><?php echo $game_date; ?></td>
				<td class="divider"></td>
				<td class="chartC"><?php echo $game_time; ?></td>
				<td class="divider"></td>
				<td class="chartL"><?php echo $home; ?></td>
				<td class="divider"></td>
				<td class="chartL"><?php echo $visitor; ?></td>
				<td class="divider"></td>
				<td class="chartL"><?php echo $field; ?></td>
				<td class="divider"></td>
				<td class="chartC"><?php echo $modified_date; ?></td>
				<td class="divider"></td>
			</tr>
<?php
		$row++;
		$game_obj->move_next();
	}
}else{
?>
			<tr>
				<td width="1" class="divider"></td>
				<td colspan="13" class="chartL9">You have no unfinished business.</td>
				<td width="1" class="divider"></td>
			</tr>
<?php
}
?>
			<tr>
				<td><?php echo draw_hidden_input_element('affiliation', $_SESSION['user_affiliation']); ?></td>
				<td colspan="16" class="buttonText"><?php echo draw_button('new_game', 'Start New Game', 'onClick="new_game(\''.$href_game_action.'\');"'); ?></td>
			</tr>
			<tr><td colspan="17" class="error"><?php echo $game_message; ?></td></tr>
			</table>
		</div>
		<!-- eof unfinished games -->
		
		<!-- bof team maintenance -->
		<div class="body_container">
			<div class="header">TEAM DATA</div>
			<!-- bof team master block -->
			<table border="0" cellpadding="0" cellspacing="0" width="460">
			<tr>
				<td colspan="13" class="chartTitleC">
					<span class="information"><a href="#" onClick="openInfo('teamData1');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
					<span>Team</span>
				</td>
			</tr>
			<tr>
				<td width="1" class="divider4"></td>
				<td width="10" class="chartHeaderC"></td>
				<td width="1" class="divider"></td>
				<td width="125" class="chartHeaderL">Town</td>
				<td width="1" class="divider"></td>
				<td width="123" class="chartHeaderL">Name</td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartHeaderC">Letter</td>
				<td width="1" class="divider"></td>
				<td width="73" class="chartHeaderC">Conf</td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartHeaderC">Div</td>
				<td width="1" class="divider4"></td>
			</tr>
<?php
if(isset($team_obj->result['town'])){
	//get data
	$town = $team_obj->field['town'];
	$name = $team_obj->field['teamName'];
	$team_type = $team_obj->field['type'];
	$conference = $team_obj->field['conference'];
	$division = $team_obj->field['division'];
	//process data
	$params = 'tmr='.$_SESSION['user_tmr'].'&et=1';
	$href_edit = set_href(FILENAME_ADMIN_TEAM, $params);
?>
			<tr class="<?php echo $background; ?>">
				<td width="1" class="divider"></td>
				<td width="10" class="chartC"><a href="<?php echo $href_edit; ?>"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a></td>
				<td width="1" class="divider"></td>
				<td width="125" class="chartL"><?php echo $town; ?></td>
				<td width="1" class="divider"></td>
				<td width="123" class="chartL"><?php echo $name; ?></td>
				<td width="1" class="divider"></td>
				<td width="53" class="chartC"><?php echo $team_type; ?></td>
				<td width="1" class="divider"></td>
				<td width="73" class="chartC"><?php echo $conference; ?></td>
				<td width="1" class="divider"></td>
				<td width="33" class="chartC"><?php echo $division; ?></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
}else{
?>
			<tr>
				<td width="1" class="divider"></td>
				<td colspan="11" class="chartL9">No teams have been created yet.</td>
				<td width="1" class="divider"></td>
			</tr>
<?php
}
?>
			<tr><td colspan="13" height="10" class="divider2"></td></tr>
			</table>
			<!-- eof team master block -->
			
<?php
include(FILENAME_ADMIN_SEASON_INDEX);
?>
		</div>
		<!-- eof team  maintenance -->
	</div>
	<!-- EOF BODY -->
	