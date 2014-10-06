<?php
//test privileges
test_privileges(0);
define('PAGE_TITLE', 'New/Edit User');
$page_header = ($playerRef > 0 ? 'EDIT USER' : 'NEW USER');

$first_name = '';
$last_name = '';
$affiliation = '';
$teamMasterRef = 0;
$telephone = '';
$email = '';
$username = '';
$password = '';

$params = 'nmh=1&a=s';
$href_action = set_href(FILENAME_ADMIN_USERS_NEW, $params);

$message = '';
if($action != ''){
	switch($action){
		case 's':
			//retrieve POST variables
			$userRef = $_POST['userRef'];
			$affiliation = $_POST['affiliation'];
			$first_name = $db->db_sanitize($_POST['first_name']);
			$last_name = $db->db_sanitize($_POST['last_name']);
			$telephone = $db->db_sanitize($_POST['telephone']);
			$email = $db->db_sanitize($_POST['email']);
			$username = $db->db_sanitize($_POST['username']);
			$password = $db->db_sanitize($_POST['password']);
			//process data
			$parts = explode(':', $_POST['affiliation']);
			$teamMasterRef = $parts[0];
			$affiliation = $parts[1];
			//validate
			if(empty($first_name)){
				$message = 'You must enter a first name. ';
			}
			if(empty($last_name)){
				$message .= 'You must enter a last name. ';
			}
			if(empty($email)){
				$message .= 'You must enter an email address. ';
			}
			if(empty($username)){
				$message .= 'You must enter a username. ';
			}
			if(empty($password)){
				$message .= 'You must enter a password. ';
			}
			if($userRef == 0){
				$sql = 'SELECT COUNT(*) AS duplicates
						FROM users
						WHERE username=\''.$username.'\'';
				$test = $db->db_query($sql);
				if($test->field['duplicates'] > 0){
					$message .= 'That username is already taken.';
				}
			}
			//write to disk
			if($message == ''){
				if($userRef > 0){
					$sql_data_array = array('FName' => $first_name,
											'LName' => $last_name,
											'phone' => $telephone,
											'email' => $email,
											'username' => $username,
											'password' => $password,
											'modified' => 'now'
											);
					$param = 'userRef='.$userRef;
					$message = $db->db_write_array('users', $sql_data_array, 'update', $param);
				}else{
					$sql_data_array = array('userRef' => NULL,
											'FName' => $first_name,
											'LName' => $last_name,
											'phone' => $telephone,
											'email' => $email,
											'affiliation' => $affiliation,
											'teamMasterRef' => $teamMasterRef,
											'username' => $username,
											'password' => $password,
											'created' => 'now',
											'modified' => 'now'
											);
					$message = $db->db_write_array('users', $sql_data_array);
					$userRef = $db->db_insert_id();
				}
			}
			//proceed
			if($message == ''){
				$params = 'ur='.$userRef.'&nmh=1';
				redirect(set_href(FILENAME_ADMIN_USERS_NEW, $params));
			}
			break;
	}
}

if($userRef > 0){
	$sql = 'SELECT FName, LName, phone, email, affiliation, teamMasterRef, username, password
			FROM users
			WHERE userRef='.$userRef;
	$users = $db->db_query($sql);
	$first_name = $users->field['FName'];
	$last_name = $users->field['LName'];
	$telephone = $users->field['phone'];
	$email = $users->field['email'];
	$affiliation = $users->field['affiliation'];
	$teamMasterRef = $users->field['teamMasterRef'];
	$username = $users->field['username'];
	$password = $users->field['password'];
}
?>