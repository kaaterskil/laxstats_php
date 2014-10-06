<?php
//test privileges
test_team_password($teamMasterRef, $password);

define('PAGE_TITLE', 'Coach\'s Corner');

$masthead_logo = MASTHEAD_CORNER_HOME;
$tpl_menubar = MENUBAR_PUBLIC;

$message = '';
if($action != ''){
	if($action == 'dlf'){
		$message = new downloader('blog_file', $blog_ref);
		if($message === false){
			$message = 'Error downloading file.';
		}
	}
}

$blogs = get_blogs($teamMasterRef);
$comments = get_blog_comments($teamMasterRef);
?>