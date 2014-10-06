<?php
//test privileges
test_team_password($teamMasterRef, $password);

define('PAGE_TITLE', 'Coach\'s Corner');
$masthead_logo = MASTHEAD_CORNER_BLOG;
$tpl_menubar = MENUBAR_PUBLIC;

$name = '';
$email = '';
$comment = '';

$params = get_all_get_params(array('p')).'&a=s';
$href_action = set_href(FILENAME_CORNER_BLOG, $params);

$message = '';
if($action != ''){
	switch($action){
		//download file
		case 'dlf':
			$message = new downloader('blog_file', $blog_ref);
			if($message === false){
				$message = 'Error downloading file.';
			}
			break;
		//save comment
		case 's':
			//retrieve POST variables
			$name = $db->db_sanitize($_POST['name']);
			$email = $db->db_sanitize($_POST['email']);
			$comment = $db->db_sanitize($_POST['comment']);
			//validate
			if(empty($name)){
				$message = 'You must enter a name. ';
			}
			if(empty($comment)){
				$message .= 'You must enter a comment.';
			}
			//write to disk
			if($message == ''){
				$sql_data_array = array('reference' => NULL,
										'blogRef' => $blog_ref,
										'name' => $name,
										'email' => $email,
										'comments' => $comment,
										'created' => NULL
										);
				$message = $db->db_write_array('blog', $sql_data_array);
			}
			//proceed
			if($message == ''){
				$params = get_all_get_params(array('p', 'a'));
				redirect(set_href(FILENAME_CORNER_BLOG, $params));
			}
			break;
	}
}
$blogs = get_blogs2($blog_ref);
$comments = get_blog_comments2($blog_ref);
?>