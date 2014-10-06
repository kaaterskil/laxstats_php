<?php
//test privileges
test_privileges(1);
//set headers
$masthead_logo = MASTHEAD_ADMIN_PLAYER;
$tpl_menubar = MENUBAR_ADMIN2;
define('PAGE_TITLE', 'Players');

$team_name = '';
$player_name = '';
$birthdate = '';
$class = '';
$height = '';
$weight = '';
$dominant_hand = '';
$jerseyNo = '';
$position = '';
$telephone_home = '';
$email_home = '';
$parent_name = '';
$email_parent = '';
$parent_release = '';
$release_date = '';
$school = '';
$counselor = '';
$telephone_counselor = '';
$college = '';
$address = '';
$age = '';
$photo_test = false;

$athletic_message = '';
$academic_message = '';
$test_message = '';
$comment_message = '';
$note_message = '';
if($action != ''){
	$recordID = $selection;
	switch($action){
		//delete athletic record
		case 'dat':
			if($recordID > 0){
				$sql = 'DELETE FROM playerAthletics
						WHERE reference='.$recordID;
				$athletic_message = $db->db_write($sql);
			}
			if($athletic_message == ''){
				$params = get_all_get_params(array('p', 'se', 'a'));
				redirect(set_href(FILENAME_ADMIN_PLAYER, $params));
			}
			break;
		//delete academic record
		case 'dac':
			if($recordID > 0){
				$sql = 'DELETE FROM playerAcademics
						WHERE reference='.$recordID;
				$academic_message = $db->db_write($sql);
			}
			if($academic_message == ''){
				$params = get_all_get_params(array('p', 'se', 'a'));
				redirect(set_href(FILENAME_ADMIN_PLAYER, $params));
			}
			break;
		//delete test record
		case 'dt':
			if($recordID > 0){
				$sql = 'DELETE FROM playerTests
						WHERE reference='.$recordID;
				$test_message = $db->db_write($sql);
			}
			if($_message == ''){
				$params = get_all_get_params(array('p', 'se', 'a'));
				redirect(set_href(FILENAME_ADMIN_PLAYER, $params));
			}
			break;
		//delete comment record
		case 'dc':
			if($recordID > 0){
				$sql = 'DELETE FROM playerComments
						WHERE reference='.$recordID;
				$comment_message = $db->db_write($sql);
			}
			if($comment_message == ''){
				$params = get_all_get_params(array('p', 'se', 'a'));
				redirect(set_href(FILENAME_ADMIN_PLAYER, $params));
			}
			break;
		//delete note record
		case 'dn':
			if($recordID > 0){
				$sql = 'DELETE FROM contactNotes
						WHERE reference='.$recordID;
				$note_message = $db->db_write($sql);
			}
			if($note_message == ''){
				$params = get_all_get_params(array('p', 'se', 'a'));
				redirect(set_href(FILENAME_ADMIN_PLAYER, $params));
			}
			break;
	}
}

//get town data
$sql = 'SELECT DISTINCT season, teamRef, IF(name!=\'\', CONCAT_WS(\' \', town, name), town) AS team_name
		FROM teams
		WHERE teamMasterRef='.$_SESSION['user_tmr'].'
		ORDER BY season DESC';
$team = $db->db_query($sql);
$team_name	= $team->field['team_name'];
$season		= ($season != '' ? $season : $team->field['season']);
$teamRef	= ($teamRef > 0 ? $teamRef : $team->field['teamRef']);

//get player data
if($playerMasterRef > 0){
	$param = ' AND teamRef='.$teamRef;
	$player = get_player_personal_info($playerMasterRef, $param);
	//get data
	$playerRef				= $player->field['playerRef'];
	$player_name			= $player->field['player_name'];
	$birthdate				= $player->field['birthdate'];
	$dominant_hand			= $player->field['dominantHand'];
	$jerseyNo				= $player->field['jerseyNo'];
	$position				= $player->field['position'];
	$street1				= $player->field['street1'];
	$street2				= $player->field['street2'];
	$city					= $player->field['city'];
	$state					= $player->field['state'];
	$ZIP_Code				= $player->field['zip'];
	$email_home				= $player->field['email'];
	$email_parent			= $player->field['parentEmail'];
	$parent_release			= $player->field['parentRelease'];
	$release_date			= $player->field['releaseDate'];
	$telephone_counselor	= $player->field['counselorPhone'];
	$photo					= $player->field['photo'];
	$college				= $player->field['collegeName'];
	$href_college			= $player->field['collegeLink'];
	$class					= ($player->field['class'] != ''		? $player->field['class']			: 'n/a');
	$height					= ($player->field['height'] != ''		? $player->field['height']			: 'n/a');
	$weight					= ($player->field['weight'] != ''		? $player->field['weight'].' lbs'	: 'n/a');
	$telephone_home			= ($player->field['homePhone'] != ''	? $player->field['homePhone']		: 'n/a');
	$parent_name			= ($player->field['parentName'] != ''	? $player->field['parentName']		: 'n/a');
	$school					= ($player->field['school'] != ''		? $player->field['school']			: 'n/a');
	$counselor				= ($player->field['counselor'] != ''	? $player->field['counselor']		: 'n/a');
	
	//process data
	$hand				= set_dominant_hand($dominant_hand);
	$position			= get_position($position);
	$address			= get_address($street1, $city, $state, $ZIP_Code, $street2);
	$email_home			= ($email_home != '' ? '<a href="mailto:'.$email_home.'">'.$email_home.'</a>' : 'n/a');
	$email_parent		= ($email_parent != '' ? '<a href="mailto:'.$email_parent.'">'.$email_parent.'</a>' : 'n/a');
	if($college != ''){
		if($href_college != ''){
			$college	= '<b>College: </b><a href="'.$href_college.'">'.$college.'</a>';
		}else{
			$college	= '<b>College: </b>'.$college;
		}
	}
	if($birthdate != '0000-00-00' && $birthdate != NULL){
		$date			= strtotime($birthdate);
		$birthdate		= date('F j, Y', $date);
		$age 			= intval(date('Y', time() - $date)) - 1970;
	}else{
		$birthdate		= 'n/a';
		$age			= 'n/a';
	}
	$photo_test			= ($photo != '' ? true : false);
	$param				= 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&pr='.$playerRef.'&nmh=1&ct=0';
	$href_edit_player	= set_href(FILENAME_ADMIN_PLAYER_NEW, $param);
	
	//get other player data
	$athletics			= get_player_athletics($playerMasterRef);
	$academics			= get_player_academics($playerMasterRef);
	$tests				= get_player_tests($playerMasterRef);
	$letters			= get_player_letters($playerMasterRef);
	$notes				= get_player_notes($playerMasterRef);
	
	//set links
	$params				= get_all_get_params(array('p', 'se')).'&se=0&nmh=1';
	$href_new_athletic	= set_href(FILENAME_ADMIN_ATHLETICS, $params);
	$href_new_academic	= set_href(FILENAME_ADMIN_ACADEMICS, $params);
	$href_new_test		= set_href(FILENAME_ADMIN_TESTS, $params);
	$href_new_letter	= set_href(FILENAME_ADMIN_LETTERS, $params);
	$href_new_note		= set_href(FILENAME_ADMIN_NOTES, $params);
	
	//set header
	$page_header = '#'.$jerseyNo.' '.strtoupper($player_name);
	$page_header .= '<br>'.strtoupper($team_name);
}else{
	$page_header = $season.' '.strtoupper($team_name).'<br>PLAYER MAINTENANCE';
}
?>