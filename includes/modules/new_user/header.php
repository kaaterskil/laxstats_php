<?php
$masthead_logo = MASTHEAD_NEW_USER;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'New User');

$first_name = '';
$last_name = '';
$email = '';
$email2 = '';
$telephone = '';
$username = '';
$password = '';
$password2 = '';

$params = 'a=s';
$href_action = set_href(FILENAME_NEW_USER, $params);

$message = '';
if($action != ''){
	if($action == 's'){
		//retrieve POST variables
		$teamMasterRef	= $_POST['teamMasterRef'];
		$first_name		= $db->db_sanitize($_POST['first_name']);
		$last_name		= $db->db_sanitize($_POST['last_name']);
		$email			= $db->db_sanitize($_POST['email']);
		$email2			= $db->db_sanitize($_POST['email2']);
		$telephone		= $db->db_sanitize($_POST['telephone']);
		$username		= $db->db_sanitize($_POST['username']);
		$password		= $db->db_sanitize($_POST['password']);
		$password2		= $db->db_sanitize($_POST['password2']);
		
		//validate data
		if(empty($first_name)){
			$message = 'The first name must not be blank. ';
		}
		if(empty($last_name)){
			$message .= 'The last name must not be blank. ';
		}
		if(empty($username)){
			$message .= 'The username must not be blank. ';
		}
		//test email
		if(empty($email)){
			$message .= 'The email address must not be blank. ';
		}elseif($email == $email2){
			$email_test = ereg('^(.+)@(.+)$', $email, $email_array);
			if($email_test < 1){
				$message .= 'You must enter a valid email address. ';
			}else{
				$user_pattern		= '[a-zA-Z0-9_\-\.]+';
				$domain_pattern		= '^([a-zA-Z0-9_\-\.]+).([a-zA-Z]{2,4})$';
				$user_test			= ereg($user_pattern, $email_array[1]);
				$domain_test		= ereg($domain_pattern, $email_array[2]);
				if($user_test < 1 || $domain_test < 1){
					$message .= 'You must enter a valid email address. ';
				}
			}
		}else{
			$message .= 'The two email addresses must match. ';
		}
		//test password
		if(empty($password) || empty($password2)){
			$message .= 'You must enter a password. ';
		}elseif($password != $password2){
			$message .= 'The two passwords must match. ';
		}
		//test for existing user or multiple users
		if($message == ''){
			$sql = 'SELECT userRef
					FROM users
					WHERE (username=\''.$username.'\' OR email=\''.$email.'\')
						AND password=\''.$password.'\'';
			$test = $db->db_query($sql);
			if($test->count_records() > 0){
				$message = 'You are already registered.';
			}else{
				$sql = 'SELECT userRef 
						FROM users 
						WHERE username=\''.$username.'\'';
				$test = $db->db_query($sql);
				if($test->count_records() > 0){
					$message = 'That username is already in use.';
				}
			}
			$sql = 'SELECT COUNT(u.userRef) AS users, tm.town
					FROM users u
					RIGHT JOIN teamsMaster tm
						USING(teamMasterRef)
					WHERE tm.teamMasterRef='.$teamMasterRef.'
					GROUP BY tm.teamMasterRef';
			$test = $db->db_query($sql);
			if($test->field['users'] > 3){
				$message = 'You have exceeded the number of allowed users.';
			}
		}
		
		//write to database
		if($message == ''){
			$affiliation = $test->field['town'];
			$sql_data_array = array('FName'			=> $first_name,
									'LName'			=> $last_name,
									'phone'			=> $telephone,
									'email'			=> $email,
									'affiliation'	=> $affiliation,
									'teamMasterRef'	=> $teamMasterRef,
									'username'		=> $username,
									'password'		=> $password,
									'userIP'		=> $_SERVER['REMOTE_ADDR'],
									'created'		=> 'now',
									'modified'		=> 'now'
									);
			$message = $db->db_write_array('users', $sql_data_array);
		}
		
		//send confirmation to user
		if($message == ''){
			$new_line = "\n";
			//a. build plain text message
			$subject = 'Laxstats Registration Validation';
			$text = 'Dear '.$first_name.','.$new_line;
			$text .= 'Thank you for your interest in Laxstats! Your registration information is as follows:'.$new_line.$new_line;
			$text .= 'First Name: '.$first_name.$new_line;
			$text .= 'Last Name: '.$last_name.$new_line;
			$text .= 'Telephone: '.$telephone.$new_line;
			$text .= 'email: '.$email.$new_line;
			$text .= 'Team affiliation: '.$affiliation.$new_line;
			$text .= 'Username: '.$username.$new_line;
			$text .= 'Password: '.$password.$new_line.$new_line;
			$text .= 'Your registration gives you access to all the data-entry areas of the Manager\'s Office with respect to your team. However, you will not be able to save or edit any information unless you have purchased a subscription to our service.'.$new_line;
			$text .= 'If you have a problem with your registration, or forget your username or password, please contact the webmaster at <a href="mailto:webmaster@laxstats.net">webmaster@laxstats.net</a>.'.$new_line;
			$text .= 'We\'re here to help improve the game and make your coaching duties easier - please contact us with questions, comments or advice. Thanks for your interest!'.$new_line;
			
			//b. build html data array
			$html_data_array = array();
			$html_data_array[] = array('USER_FIRST_NAME'	=> $first_name,
									   'USER_LAST_NAME'		=> $last_name,
									   'USER_TELEPHONE'		=> $telephone,
									   'USER_EMAIL'			=> $email,
									   'USER_TOWN'			=> $affiliation,
									   'USER_USERNAME'		=> $username,
									   'USER_PASSWORD'		=> $password,
									   'EMAIL_MESSAGE_HTML'	=> $text
									   );
			$html_module = array(HTML_EMAIL_NEW_USER);
			//c. send mail
			$recipients = $email.', '.COMPANY_EMAIL_ADDRESS;
			send_mail($recipients, COMPANY_NAME.' <'.COMPANY_EMAIL_ADDRESS.'>', COMPANY_EMAIL_ADDRESS, $subject, $text, '', $html_data_array, $html_module);
			
			//proceed
			redirect(set_href(FILENAME_LOGIN));
		}
	}
}
?>
