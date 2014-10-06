<?php
$masthead_logo = MASTHEAD_LOGIN;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Login');

$params = 'a=a';
$href_action = set_href(FILENAME_LOGIN, $params);
$href_new_user = set_href(FILENAME_NEW_USER);

$message = '';
$username = '';
$password = '';
if($action != ''){
	if($action == 'a'){
		//retrieve POST variables
		$username = $db->db_sanitize($_POST['username']);
		$password = $db->db_sanitize($_POST['password']);
		$user_IP = $_SERVER['REMOTE_ADDR'];
		
		//validate
		if(empty($username)){
			$message = ERROR_NO_LOGIN_USERNAME;
		}
		if(empty($password)){
			$message = ERROR_NO_LOGIN_PASSWORD;
		}
		
		if($message == ''){
			//test for email or username
			$email_test = ereg('^(.+)@(.+)$', $username, $test_array);
			$user_test = 0;
			$domain_test = 0;
			$ip_test = 0;
			if($email_test > 1){
				$user_pattern = '[[:alnum:]]+';
				$domain_pattern = '([[:alnum:]]+).([A-Za-z0-9]{2,4})';
				$ip_pattern = '^([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3}).([0-9]{1,3})$';
				$user_test = ereg($user_pattern, $test_array[1], $user_array);
				$domain_test = ereg($domain_pattern, $test_array[2], $domain_array);
				$ip_test = ereg($ip_pattern, $test_array[2], $ip_array);
			}
			
			//query database
			if(($user_test > 1 && $domain_test > 1) || $ip_test > 1){
				$sql = 'SELECT u.userRef, u.FName, u.LName, u.teamMasterRef, u.affiliation, u.userIP, u.email, py.paidStatus
						FROM users u
						LEFT JOIN payments py
							USING(teamMasterRef)
						WHERE u.email=\''.$username.'\' AND u.password=\''.$password.'\'
						ORDER BY py.season DESC';
			}else{
				$sql = 'SELECT u.userRef, u.FName, u.LName, u.teamMasterRef, u.affiliation, u.userIP, u.email, py.paidStatus
						FROM users u
						LEFT JOIN payments py
							USING(teamMasterRef)
						WHERE u.username=\''.$username.'\' AND u.password=\''.$password.'\'
						ORDER BY py.season DESC';
			}
			$test = $db->db_query($sql);
			if(!isset($test->result['userRef'])){
				$message = ERROR_BAD_LOGIN;
			}
			
			//authorize
			if($message == ''){
				//retrieve user data
				$user_first_name	= $test->field['FName'];
				$user_last_name		= $test->field['LName'];
				$user_id			= $test->field['userRef'];
				$user_tmr			= $test->field['teamMasterRef'];
				$user_affiliation	= $test->field['affiliation'];
				$user_paid_status	= $test->field['paidStatus'];
				$user_email			= $test->field['email'];
				$ipt				= $test->field['userIP'];
				
				//update IP address as necessary
				if($ipt != $user_IP){
					$sql_data_array = array('userIP' => $user_IP,
											'modified' => 'now'
											);
					if(($user_test > 1 && $domain_test > 1) || $ip_test > 1){
						$param = 'email=\''.$username.'\' AND password=\''.$password.'\'';
					}else{
						$param = 'username=\''.$username.'\' AND password=\''.$password.'\'';
					}
					$message = $db->db_write_array('users', $sql_data_array, 'update', $param);
				}
				
				//proceed
				if($message == ''){
					$_SESSION['user_first_name']	= $user_first_name;
					$_SESSION['user_last_name']		= $user_last_name;
					$_SESSION['user_id']			= $user_id;
					$_SESSION['user_tmr']			= $user_tmr;
					$_SESSION['user_affiliation']	= $user_affiliation;
					$_SESSION['user_paid_status']	= $user_paid_status;
					$_SESSION['user_email']			= $user_email;
					if($user_affiliation == 'Administrator'){
						$_SESSION['admin_level'] = SECURITY_ADMIN_SUPERUSER;
						redirect(set_href(FILENAME_ADMIN_DESIGNER_HOME));
					}else{
						$_SESSION['admin_level'] = SECURITY_ADMIN_SUBSCRIBER;
						redirect(set_href(FILENAME_ADMIN_USER_HOME));
					}
				}
			}
		}
	}
}
?>
