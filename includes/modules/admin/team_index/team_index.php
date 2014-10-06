<?php
include(FILENAME_ADMIN_PAGE_HEADER);
?>

	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="700">
<?php
if($teamMasterRef == 0){
	$param = 'tmr=0&nmh=1';
	$href_new = set_href(FILENAME_ADMIN_TEAM_NEW, $param);
?>
		<tr valign="bottom">
			<td colspan="13" class="note">NOTE: Opposing teams must appear on this list and have the appropriate season roster before they can be assigned to a game. Click the button at the right to create a team if it doesn't already exist. Click on a team name to create or edit a season roster.</td>
			<td colspan="4" class="buttonText"><?php echo draw_button('new_team', 'New Team', 'onClick="new_team(\''.$href_new.'\');"'); ?></td>
		</tr>
<?php
}
?>
		<tr>
			<td colspan="17" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('teamEntry1');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>TEAMS</span>
			</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="33" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="138" class="chartHeaderL">Town/School</td>
			<td width="1" class="divider"></td>
			<td width="107" class="chartHeaderL">Name</td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartHeaderC">Gender</td>
			<td width="1" class="divider"></td>
			<td width="63" class="chartHeaderC">Letter</td>
			<td width="1" class="divider"></td>
			<td width="93" class="chartHeaderC">Conference</td>
			<td width="1" class="divider"></td>
			<td width="123" class="chartHeaderC">League</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Div</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
if(isset($teams->result['teamMasterRef'])){
	$row = 0;
	while(!$teams->eof){
		//get data
		$tmr = $teams->field['teamMasterRef'];
		$teamName = $teams->field['teamName'];
		$town = $teams->field['town'];
		$conference = $teams->field['conference'];
		$league = $teams->field['league'];
		$division = $teams->field['division'];
		$type = $teams->field['type'];
		$gender = $teams->field['gender'];
		$password = $teams->field['password'];
		$paid_status = $teams->field['paidStatus'];
		//process data
		$type = get_team_type($type);
		$gender = strtolower(set_gender($gender));
		$gender = ucwords($gender);
		$password_test = ($password != '' ? true : false);
		$edit_test = ($paid_status == 'T' && $_SESSION['user_tmr'] != $tmr && $_SESSION['user_affiliation'] != 'Administrator' ? false : true);
		$background = set_background($row);
		$params = 'tmr='.$tmr.'&sn='.$state.'a=d';
		$href_delete = set_href(FILENAME_TEAM_INDEX, $params);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="33" class="chartC">
<?php
		if($edit_test){
			$params = 'tmr='.$tmr.'&nmh=1';
			$href_edit = set_href(FILENAME_ADMIN_TEAM_NEW, $params);
?>
				<a href="#" onClick="confirm_delete('<?php echo $href_delete; ?>')"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
				<a href="#" onClick="edit_team('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
<?php
		}else{
?>
				<a href="#" onClick="user_notice();"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
				<a href="" onClick="user_notice();"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
<?php
		}
?>
			</td>
			<td width="1" class="divider"></td>
<?php
		if($edit_test){
			if($_SESSION['user_tmr'] == $tmr || $_SESSION['user_affiliation'] == 'Administrator'){
				$params = 'tmr='.$tmr.'&et=1';
				$href_edit = set_href(FILENAME_ADMIN_TEAM, $params);
			}else{
				$params = 'tmr='.$tmr.'&et=0';
				$href_edit = set_href(FILENAME_ADMIN_TEAM, $params);
			}
?>
			<td width="138" class="chartL"><a href="<?php echo $href_edit; ?>"><?php echo $town; ?></a></td>
<?php
		}else{
?>
			<td width="138" class="chartL"><a href="#" onClick="user_notice();"><?php echo $town; ?></a></td>
<?php
		}
?>
			<td width="1" class="divider"></td>
			<td width="107" class="chartL"><?php echo $teamName; ?></td>
			<td width="1" class="divider"></td>
			<td width="53" class="chartC"><?php echo $gender; ?></td>
			<td width="1" class="divider"></td>
			<td width="63" class="chartC"><?php echo $type; ?></td>
			<td width="1" class="divider"></td>
			<td width="93" class="chartC"><?php echo $conference; ?></td>
			<td width="1" class="divider"></td>
			<td width="123" class="chartC"><?php echo $league; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><?php echo $division; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		$row++;
		$teams->move_next();
	}
}
?>
		<tr><td colspan="17" class="error"><?php echo $message; ?></td></tr>
		</table>
	</div>
	<!-- EOF BODY -->
