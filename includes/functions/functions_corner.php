<?php

/*------------------------------------------------------------
TEST PASSWORD
------------------------------------------------------------*/
function test_team_password($teamMasterRef, $password){
	global $db;
	$sql = 'SELECT password
			FROM teamsMaster
			WHERE teamMasterRef='.$teamMasterRef;
	$test = $db->db_query($sql);
	$password_test = $test->field['password'];
	if($password_test != NULL && $password != $password_test){
		$params = 'e=3';
		redirect(set_href(FILENAME_ERROR, $params));
	}
}

/*------------------------------------------------------------
GET BLOGS
------------------------------------------------------------*/
function get_blogs($teamMasterRef){
	global $db;
	$sql = 'SELECT reference, date, title, letter, fileName, fileType, filePath
			FROM coachLetters
			WHERE teamMasterRef='.$teamMasterRef.'
				AND type=\'B\'
			ORDER BY date DESC';
	$r = $db->db_query($sql);
	return $r;
}
function get_blogs2($recordID){
	global $db;
	$sql = 'SELECT reference, date, title, letter, fileName, fileType, filePath
			FROM coachLetters
			WHERE reference='.$recordID;
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
GET BLOG COMMENTS
------------------------------------------------------------*/
function get_blog_comments($teamMasterRef){
	global $db;
	$sql = 'SELECT b.blogRef, b.name, b.comments, b.created
			FROM blog b
			INNER JOIN coachLetters c
				ON b.blogRef=c.reference
			WHERE c.teamMasterRef='.$teamMasterRef.'
			ORDER BY b.blogRef, b.created DESC';
	$r = $db->db_query($sql);
	return $r;
}
function get_blog_comments2($recordID){
	global $db;
	$sql = 'SELECT blogRef, name, comments, created
			FROM blog
			WHERE blogRef='.$recordID.'
			ORDER BY created DESC';
	$r = $db->db_query($sql);
	return $r;
}

/*------------------------------------------------------------
SET DOWNLOAD ICON IMAGE
------------------------------------------------------------*/
function set_icon($file_name){
	$r = '';
	$parts = explode('.', $file_name);
	$extension = strtolower(end($parts));
	switch($extension){
		case 'doc':
			$r = 'images/iconword.gif';
			break;
		case'xls':
			$r = 'images/iconxl.gif';
			break;
		case 'ppt':
			$r = 'images/iconppt.gif';
			break;
		case 'pdf':
			$r = 'images/iconpdf.gif';
			break;
	}
	return $r;
}

/*------------------------------------------------------------
PARSE BLOG TEXT
------------------------------------------------------------*/
function format_string($str){
	$r = '';
	for($i = 0; $i < strlen($str); $i++){
		if(substr($str, $i, 1) == chr(13) && substr($str, $i - 1, 1) != '>'){
			$r .= '<br>';
		}else{
			$r .= substr($str, $i, 1);
		}
	}
	return $r;
}
?>