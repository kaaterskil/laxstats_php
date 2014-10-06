<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php echo PAGE_TITLE; ?></title>
<meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>" />
<?php
//load css stylesheets
$main_dir = $template->get_template_files('includes/styles/', '/^styles/', '.css');
while(list($key, $value) = each($main_dir)){
	echo '<link rel="stylesheet" type="text/css" href="includes/styles/'.$value.'">'."\n";
}
$file_dir = $template->get_template_files($tpl_directory, '/\w/', '.css');
while(list($key, $value) = each($file_dir)){
	echo '<link rel="stylesheet" type="text/css" href="'.$tpl_directory.$value.'">'."\n";
}

//load javascript files
$main_dir = $template->get_template_files('includes/javascript/', '/\w+/', '.js');
while(list($key, $value) = each($main_dir)){
	echo '<script type="text/javascript" src="includes/javascript/'.$value.'"></script>'."\n";
}
$file_dir = $template->get_template_files($tpl_directory, '/\w/', '.js');
while(list($key, $value) = each($file_dir)){
	echo '<script type="text/javascript" src="'.$tpl_directory.$value.'"></script>'."\n";
}
if($page_ref == 'a13n'){
	echo '<script type="text/javascript" src="includes/tinymce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		theme : "advanced",
		mode: "exact",
		elements : "blog_text",
		theme_advanced_toolbar_location : "top",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,"
		+ "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
		+ "bullist,numlist,outdent,indent",
		theme_advanced_buttons2 : "link,unlink,anchor,image,separator,"
		+"undo,redo,cleanup,code,separator,sub,sup,charmap",
		theme_advanced_buttons3 : "",
		height:"350px",
		width:"520px",
		file_browser_callback : \'myFileBrowser\'
	});

	function myFileBrowser (field_name, url, type, win) {
		var fileBrowserWindow = new Array();
		fileBrowserWindow[\'title\'] = \'File Browser\';
		fileBrowserWindow[\'file\'] = "my_cms_script.php" + "?type=" + type;
		fileBrowserWindow[\'width\'] = \'420\';
		fileBrowserWindow[\'height\'] = \'400\';
		tinyMCE.openWindow(fileBrowserWindow, { window : win, resizable : \'yes\', inline : \'yes\' });
		return false;
	}
</script>
'."\n";
}
?>
</head>
