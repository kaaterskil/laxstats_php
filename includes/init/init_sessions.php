<?php
//set the session name and path
get_session_name('laxstats');
save_session_path('');

//set session cookie params
session_set_cookie_params(0, '/', (not_null($current_domain) ? $current_domain : ''));

//set session ID
if(isset($_POST[get_session_name()])){
	get_session_id($_POST[get_session_name()]);
}elseif($request_type == 'SSL' && isset($_GET[get_session_name()])){
	get_session_id($_GET[get_session_name()]);
}

//start session
start_user_session();
$session_started = true;

//set host address
if(!isset($_SESSION['user_host_address'])){
	$_SESSION['user_host_address'] = @gethostbyaddr($_SERVER['REMOTE_ADDR']);
}

//verify SSL session ID if enabled
if($request_type == 'SSL' && $session_started == true){
	$ssl_session_id = $_SERVER['SSL_SESSION_ID'];
	//save as session variable
	if(!isset($_SESSION['ssl_session_id'])){
		$_SESSION['ssl_session_id'] = $ssl_session_id;
	}elseif($_SESSION['ssl_session_id'] != $ssl_session_id){
		die('no active session');
		destroy_user_session();
						//////////////////////////////
		redirect();		//NEED TO CREATE AN ERROR PAGE
						//////////////////////////////
	}
}
?>