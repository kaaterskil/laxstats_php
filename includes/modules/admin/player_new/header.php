<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'New/Edit Player');
$page_header = ($playerRef > 0 ? 'EDIT PLAYER' : 'NEW PLAYER');

$playerMasterRef = ($playerMasterRef > 0 ? $playerMasterRef : 0);
$playerRef = ($playerRef > 0 ? $playerRef : 0);
$last_name = '';
$first_name = '';
$jerseyNo = '';
$position = '';
$depth = '';
$class = '';
$captain = 'F';
$height = '';
$weight = '';
$birthdate = '';
$hand = '';
$school = '';
$counselor = '';
$telephone_counselor = '';
$college = '';
$college_link = '';
$street1 = '';
$street2 = '';
$city = '';
$state = '';
$ZIP_Code = '';
$telephone_home = '';
$email_player = '';
$parent = '';
$email_parent = '';
$release = 'N';
$release_date = '';

$params = 'nmh=1&a=s';
$href_action = set_href(FILENAME_ADMIN_PLAYER_NEW, $params);

$message = '';
if($action != ''){
	switch($action){
		case 's':
			//get POST variables
			$jerseyNo				= $db->db_sanitize($_POST['jerseyNo']);
			$last_name				= $db->db_sanitize($_POST['last_name']);
			$first_name				= $db->db_sanitize($_POST['first_name']);
			$class					= $db->db_sanitize($_POST['class']);
			$height					= $db->db_sanitize($_POST['height']);
			$weight					= $db->db_sanitize($_POST['weight']);
			$birthdate				= $db->db_sanitize($_POST['birthdate']);
			$school					= $db->db_sanitize($_POST['school']);
			$counselor				= $db->db_sanitize($_POST['counselor']);
			$telephone_counselor	= $db->db_sanitize($_POST['telephone_counselor']);
			$college				= $db->db_sanitize($_POST['college']);
			$college_link			= $db->db_sanitize($_POST['college_link']);
			$street1				= $db->db_sanitize($_POST['street1']);
			$street2				= $db->db_sanitize($_POST['street2']);
			$city					= $db->db_sanitize($_POST['city']);
			$state					= $_POST['state'];
			$ZIP_Code				= $db->db_sanitize($_POST['ZIP_Code']);
			$telephone_home			= $db->db_sanitize($_POST['telephone_home']);
			$email_player			= $db->db_sanitize($_POST['email_player']);
			$parent					= $db->db_sanitize($_POST['parent']);
			$email_parent			= $db->db_sanitize($_POST['email_parent']);
			$release_date			= $db->db_sanitize($_POST['release_date']);
			$captain				= (isset($_POST['captain']) ? 'T' : 'F');
			$release				= (isset($_POST['release']) ? 'T' : 'F');
			$position				= $_POST['position'];
			$depth					= $_POST['depth'];
			$hand					= $_POST['hand'];
			$playerRef				= $_POST['playerRef'];
			$playerMasterRef		= $_POST['playerMasterRef'];
			$teamRef				= $_POST['teamRef'];
			$teamMasterRef			= $_POST['teamMasterRef'];
			
			//process data
			$birthdate_write = '0000-00-00';
			if($birthdate != ''){
				$birthdate = validate_date($birthdate);
				$birthdate_write = date('Y-m-d', strtotime($birthdate));
			}
			$release_date_write = '0000-00-00';
			if($release_date != ''){
				$birthdate = validate_date($release_date);
				$release_date_write = date('Y-m-d', strtotime($release_date));
			}
		
			//validate
			//1. test for active subscription
			$message = subscriber_test($_SESSION['user_affiliation'], $_SESSION['user_paid_status']);
			//2. test fields
			if($message == ''){
				if(empty($jerseyNo)){
					$message .= 'The jersey number must not be blank. ';
				}else{
					if(!ereg('^([1-9]|[1-9][0-9]|[1-9][0-9][0-9])$', $jerseyNo)){
						$message .= 'Please enter a jersey number as a integer greater than "0" or "00". ';
					}
				}
				if(empty($last_name)){
					$message .= 'The last name must not be blank. ';
				}
				if($position == ''){
					$message .= 'Please specify a position. ';
				}
				if($class != ''){
					if(!ereg('^([1][9][0-9][0-9]|[2][0][0-9][0-9])$', $class)){
						$message .= 'Please enter a valid 4-digit class year. ';
					}
				}
				if($telephone_home != ''){
					if(!ereg('^\(?([2-9][0-9][0-9])\)?([-\. ])?([2-9][0-9][0-9])([-\. ])?([0-9]{4})$', $telephone_home)){
						$message .= 'Please enter a valid home telephone number. ';
					}
				}
				if($telephone_counselor != ''){
					if(!ereg('^\(?([2-9][0-9][0-9])\)?([-\. ])?([2-9][0-9][0-9])([-\. ])?([0-9]{4})$', $telephone_counselor)){
						$message .= 'Please enter a valid counselor telephone number. ';
					}
				}
				if($email_player != ''){
					if(!ereg('^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,7})$', $email_player)){
						$message .= 'Please enter a valid player email address. ';
					}
				}
				if($email_parent != ''){
					if(!ereg('^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,7})$', $email_parent)){
						$message .= 'Please enter a valid parent email address. ';
					}
				}
				if($college_link != ''){
					if(!ereg('^((((ht|f)tp(s?))\://)?((([a-zA-Z0-9_\-]{2,}\.)+[a-zA-Z]{2,})|((?:(?:25[0-5]|2[0-4]\d|[01]\d\d|\d?\d)(?(\.?\d)\.)){4}))(:[a-zA-Z0-9]+)?(/[a-zA-Z0-9\-\._\?\,\'/\\\+&amp;%\$#\=~]*)?$', $college_link)){
						$message .= 'please enter a valid college URL. ';
					}
				}
			}
			//3. test for duplicate
			if($message == ''){
				$sql = 'SELECT COUNT(reference) AS duplicates
						FROM players
						WHERE FName=\''.$first_name.'\'
							AND LName=\''.$last_name.'\'
							AND teamRef='.$teamRef.'
							AND reference!='.$playerRef;
				$test = $db->db_query($sql);
				if($test->field['duplicates'] > 0){
					$message .= 'A player by that name already exists on this team.';
				}
			}
			//image management -> saves file to disk, not database
			if($message == ''){
				$image = new upload('photo');
				$image->set_destination('cache/images/tmr'.$teamMasterRef.'/');
				$upload_message = $image->parse_upload();
				if($upload_message == true){
					$image_name = $image->filename;
					$upload_message = $image->save_file();
					if(!$upload_message){
						$message = $upload_message;
					}
				}elseif($upload_message != FILE_UPLOADED_SUCCESSFULLY){
					$message = $upload_message;
				}
			}
			//write to disk
			if($message == ''){
				//1. create/update master record
				if($playerMasterRef == 0){
					$sql_data_array = array('LName'			=> $last_name,
											'FName'			=> $first_name,
											'birthdate'		=> $birthdate_write,
											'class'			=> $class,
											'height'		=> $height,
											'weight'		=> $weight,
											'dominantHand'	=> $hand,
											'jerseyNo'		=> $jerseyNo,
											'position'		=> $position,
											'street1'		=> $street1,
											'street2'		=> $street2,
											'city'			=> $city,
											'state'			=> $state,
											'zip'			=> $ZIP_Code,
											'homePhone'		=> $telephone_home,
											'email'			=> $email_player,
											'parentName'	=> $parent,
											'parentEmail'	=> $email_parent,
											'parentRelease' => $release,
											'releaseDate'	=> $release_date_write,
											'school'		=> $school,
											'counselor'		=> $counselor,
											'counselorPhone' => $telephone_counselor,
											'photo'			=> $image_name,
											'collegeName'	=> $college,
											'collegeLink'	=> $college_link,
											'modifiedBy'	=> $_SESSION['user_id'],
											'created'		=> 'now',
											'modified'		=> 'now'
											);
					$message = $db->db_write_array('playerMaster', $sql_data_array);
					$playerMasterRef = $db->db_insert_id();
				}else{
					$sql_data_array = array('LName'			=> $last_name,
											'FName'			=> $first_name,
											'birthdate'		=> $birthdate_write,
											'class'			=> $class,
											'height'		=> $height,
											'weight'		=> $weight,
											'dominantHand'	=> $hand,
											'jerseyNo'		=> $jerseyNo,
											'position'		=> $position,
											'street1'		=> $street1,
											'street2'		=> $street2,
											'city'			=> $city,
											'state'			=> $state,
											'zip'			=> $ZIP_Code,
											'homePhone'		=> $telephone_home,
											'email'			=> $email_player,
											'parentName'	=> $parent,
											'parentEmail'	=> $email_parent,
											'parentRelease' => $release,
											'releaseDate'	=> $release_date_write,
											'school'		=> $school,
											'counselor'		=> $counselor,
											'counselorPhone' => $telephone_counselor,
											'photo'			=> $image_name,
											'collegeName'	=> $college,
											'collegeLink'	=> $college_link,
											'modifiedBy'	=> $_SESSION['user_id'],
											'modified'		=> 'now'
											);
					$param = 'reference='.$playerMasterRef;
					$message = $db->db_write_array('playerMaster', $sql_data_array, 'update', $param);
				}
				//2. create player record
				if($playerRef == 0){
					$sql_data_array = array('playerMasterRef'	=> $playerMasterRef,
											'teamRef'			=> $teamRef,
											'jerseyNo'			=> $jerseyNo,
											'LName'				=> $last_name,
											'FName'				=> $first_name,
											'captain'			=> $captain,
											'position'			=> $position,
											'depth'				=> $depth,
											'class'				=> $class,
											'height'			=> $height,
											'weight'			=> $weight,
											'modifiedBy'		=> $_SESSION['user_id'],
											'created'			=> 'now',
											'modified'			=> 'now'
											);
					$message .= $db->db_write_array('players', $sql_data_array);
					$playerRef = $db->db_insert_id();
				}else{
					$sql_data_array = array('jerseyNo'			=> $jerseyNo,
											'LName'				=> $last_name,
											'FName'				=> $first_name,
											'captain'			=> $captain,
											'position'			=> $position,
											'depth'				=> $depth,
											'class'				=> $class,
											'height'			=> $height,
											'weight'			=> $weight,
											'modifiedBy'		=> $_SESSION['user_id'],
											'modified'			=> 'now'
											);
					$param = 'reference='.$playerRef;
					$message .= $db->db_write_array('players', $sql_data_array, 'update', $param);
				}
			}
			//proceed
			if($message == ''){
				$params = 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&pr='.$playerRef.'&nmh=1&ct=1';
				redirect(set_href(FILENAME_ADMIN_PLAYER_NEW, $params));
			}
			break;
	}
}
if($playerRef > 0){
	$sql = 'SELECT pm.LName, pm.FName, pm.birthdate, pm.class, pm.height, pm.weight, pm.dominantHand, pm.street1, pm.street2, pm.city, pm.state, pm.zip, pm.homePhone, pm.email, pm.parentName, pm.parentEmail, pm.parentRelease, pm.releaseDate, pm.school, pm.counselor, pm.counselorPhone, pm.collegeName, pm.collegeLink,
				p.playerMasterRef, p.jerseyNo, p.position, p.depth, p.captain
			FROM players p
			INNER JOIN playerMaster pm
				ON pm.reference=p.playerMasterRef
			WHERE p.reference='.$playerRef;
	$player = $db->db_query($sql);
	$playerMasterRef		= $player->field['playerMasterRef'];
	$last_name				= $player->field['LName'];
	$first_name				= $player->field['FName'];
	$jerseyNo				= $player->field['jerseyNo'];
	$position				= $player->field['position'];
	$depth					= $player->field['depth'];
	$class					= $player->field['class'];
	$captain				= $player->field['captain'];
	$height					= $player->field['height'];
	$weight					= $player->field['weight'];
	$dob					= $player->field['birthdate'];
	$hand					= $player->field['dominantHand'];
	$school					= $player->field['school'];
	$counselor				= $player->field['counselor'];
	$telephone_counselor	= $player->field['counselorPhone'];
	$college				= $player->field['collegeName'];
	$college_link			= $player->field['collegeLink'];
	$street1				= $player->field['street1'];
	$street2				= $player->field['street2'];
	$city					= $player->field['city'];
	$state					= $player->field['state'];
	$ZIP_Code				= $player->field['zip'];
	$telephone_home			= $player->field['homePhone'];
	$email_player			= $player->field['email'];
	$parent					= $player->field['parentName'];
	$email_parent			= $player->field['parentEmail'];
	$release				= $player->field['parentRelease'];
	$dor					= $player->field['releaseDate'];

	$birthdate		= ($dob != '0000-00-00' ? date('m/d/Y', strtotime($dob)) : '');
	$release_date	= ($dor != '0000-00-00' ? date('m/d/Y', strtotime($dor)) : '');
}
?>