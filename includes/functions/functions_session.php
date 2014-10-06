<?php
/*----------------------------------------------------------------------
GET SESSION NAME
----------------------------------------------------------------------*/
function get_session_name($name = ''){
	if(!empty($name)){
		$r = session_name($name);
	}else{
		$r = session_name();
	}
	return $r;
}

/*----------------------------------------------------------------------
SET SESSION PATH
----------------------------------------------------------------------*/
function save_session_path($path = ''){
	if(!empty($path)){
		$r = session_save_path($path);
	}else{
		$r = session_save_path();
	}
	return $r;
}

/*----------------------------------------------------------------------
GET SESSION ID
----------------------------------------------------------------------*/
function get_session_id($session_id = ''){
	if(!empty($session_id)){
		$r = session_id($session_id);
	}else{
		$r = session_id();
	}
	return $r;
}

/*----------------------------------------------------------------------
START SESSION
----------------------------------------------------------------------*/
function start_user_session(){
	//@ini_set('session.gc_probability', 1);
	//@ini_set('session.gc_divisor', 2);
	return session_start();
}

/*----------------------------------------------------------------------
DESTROY SESSION
----------------------------------------------------------------------*/
function destroy_user_session(){
	return session_destroy();
}
?>