<?php
include(FILENAME_ADMIN_PAGE_HEADER);
?>
	<!-- BOF BODY -->
	<div class="body_container" style="clear:both; ">
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
			<td width="125" class="chartHeaderC">Town</td>
			<td width="1" class="divider"></td>
			<td width="123" class="chartHeaderC">Name</td>
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
	$password = $team_obj->field['password'];
	//process data
	$params = 'tmr='.$teamMasterRef.'&nmh=1';
	$href_edit = set_href(FILENAME_ADMIN_TEAM_NEW, $params);
	$background = set_background(0);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="10" class="chartC"><a href="#" onClick="edit_team('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a></td>
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
		
		<!-- bof password block -->
<?php
			if($edit_test){
				if($password != ''){
					$string = $password;
					$password_test = true;
				}else{
					$string = 'There is no password. This may be a security issue.';
					$password_test = false;
				}
				$params = 'tmr='.$teamMasterRef.'&sn=&et=1&a=ap';
				$href_action = set_href(FILENAME_ADMIN_TEAM, $params);
?>
		<form name="password" method="post" action="<?php echo $href_action; ?>">
		<table border="0" cellspacing="0" cellpadding="0" width="460">
		<tr><td colspan="2" height="10" class="divider2"></td></tr>
		<tr>
			<td colspan="2" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('teamPassword');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>TEAM PASSWORD</span>
			</td>
		</tr>
		<tr align="left">
			<td width="120" class="formLabel2">Password:</td>
<?php
				if($password_test=="T"){
?>
			<td class="chartL2"><?php echo $string; ?></td>
<?php
				}else{
?>
			<td class="chartL9"><?php echo $string; ?></td>
<?php
				}
?>
		</tr>
		<tr align="left">
			<td class="formLabel2">New password:</td>
			<td class="formText2"><?php echo draw_password_input_element('password', '', 30, 20, ''); ?></td>
		</tr>
		<tr>
<?php
				if($edit_test){
?>
			<td colspan="2" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('submit', 'Change'); ?></td>
<?php
				}else{
?>
			<td colspan="2" class="buttonText"><?php echo draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_button('submit', 'Change', 'onClick="return userNotice(\'P\');"'); ?></td>
<?php
				}
?>
		</tr>
		<tr><td colspan="2" class="error"><?php echo $password_message; ?></td></tr>
		<tr align="left"><td colspan="2" class="note">NOTE: A Team Password provides security to the Coach's Corner and Playbook, areas where you might not want the public or your competition to visit. We recommend that you set a password that permits access for only team members, staff, their parents and other key people.</td></tr>
		</table>
		</form>
		<!-- eof password block -->
<?php
			}
?>
	</div>
	<!-- EOF BODY -->
