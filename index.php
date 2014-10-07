<?php
//load initialization files
require('includes/application_top.php');

//load html header
require('includes/modules/html_header.php');

//set scroll
$set_scroll = ($offsetY > 0 ? 'window.scrollTo(0, '.$offsetY.');' : '');
//set popup close
$set_popup_close = ($close_popup_test == 1 ? 'window.close();' : '');
?>

<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" onLoad="set_footer('footer');<?php echo $set_scroll, $set_popup_close; ?>">

<?php
//load masthead
if($no_masthead == false){
?>
<div id="masthead"><img src="images/<?php echo $masthead_logo ?>" width="760" height="100" border="0" usemap="#map" alt=""><map name="map"><area shape="rect" coords="34,32,210,70" href="/index.php" alt="" ></map></div>
<?php
}

//load menubar
if(isset($tpl_menubar)){
	require($tpl_menubar);
}
?>

<div id="content">
<?php
//load page body
require($tpl_body_file);
?>
</div>

<?php
//load html footer
require('includes/application_bottom.php');
?>
</body>
</html>
