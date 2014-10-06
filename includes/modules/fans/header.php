<?php
$masthead_logo = MASTHEAD_FAN;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Fan Registration');

$teamMasterRef = 0;
$first_name = '';
$last_name = '';
$street1 = '';
$street2 = '';
$city = '';
$state = '';
$ZIP_Code = '';
$telephone = '';
$email = '';
$user_IP = '';

$href_privacy = set_href(FILENAME_PRIVACY);
$param = 'a=s';
$href_action = set_href(FILENAME_FAN, $param);

if(!isset($_GET['m'])){
	$message = '';
}else{
	$message = 'Thanks for signing up!';
}
if($action != ''){
	switch($action){
		case 's':
			//retrieve POST variables
			$first_name		= $db->db_sanitize($_POST['first_name']);
			$last_name		= $db->db_sanitize($_POST['last_name']);
			$street1		= $db->db_sanitize($_POST['street1']);
			$street2		= $db->db_sanitize($_POST['street2']);
			$city			= $db->db_sanitize($_POST['city']);
			$state			= $_POST['state'];
			$ZIP_Code		= $db->db_sanitize($_POST['ZIP_Code']);
			$telephone		= $db->db_sanitize($_POST['telephone']);
			$email			= $db->db_sanitize($_POST['email']);
			$teamMasterRef	= $_POST['teamMasterRef'];
			$user_IP		= $_SERVER['REMOTE_ADDR'];
			
			//validation
			//1. test for duplicate email
			$sql = 'SELECT email
					FROM people 
					WHERE email=\''.$email.'\'';
			$result_array = $db->db_query($sql);
			if($result_array->field['email'] != ''){
				$message = 'You are already registered. ';
			}
			//2. test for duplicate name
			$sql = 'SELECT FName 
					FROM people 
					WHERE FName=\''.$first_name.'\' 
					AND LName=\''.$last_name.'\' 
					AND teamMasterRef='.$teamMasterRef;
			$result_array = $db->db_query($sql);
			if($result_array->field['FName'] != ''){
				$message = 'You are already registered. ';
			}
			//3. test for duplicate IP address
			$sql = 'SELECT userIP
					FROM people 
					WHERE userIP=\''.$user_IP.'\'';
			$result_array = $db->db_query($sql);
			if(count($result_array->result['userIP']) > 3){
				$message .= 'A maximum of 3 individuals from this IP address may register.';
			}
			
			if($message == ''){
				//write to database
				$sql_data_array = array('ref'			=> 'null',
										'teamMasterRef'	=> $teamMasterRef,
										'FName'			=> $first_name,
										'LName'			=> $last_name,
										'street1'		=> $street1,
										'street2'		=> $street2,
										'city'			=> $city,
										'state'			=> $state,
										'zip'			=> $ZIP_Code,
										'phone'			=> $telephone,
										'email'			=> $email,
										'userIP'		=> $user_IP,
										'created'		=> 'null',
										'modified'		=> 'null'
										);
				$message = $db->db_write_array('people', $sql_data_array);
			}
			//proceed
			if($message == ''){
				$params = get_all_get_params(array('p', 'a')).'&m=1';
				redirect(set_href($page_ref, $params));
			}
			break;
	}
}
?>
