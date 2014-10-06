<?php
$param			= 'tmr='.$_SESSION['user_tmr'];
$href_team		= set_href(FILENAME_ADMIN_TEAM, $param);
$href_players	= set_href(FILENAME_ADMIN_PLAYER, $param);
$href_blog		= set_href(FILENAME_ADMIN_BLOG, $param);
$href_playbook	= set_href(FILENAME_ADMIN_PLAYBOOK, $param);
$href_photos	= set_href(FILENAME_ADMIN_PHOTOS, $param);

$href_game		= set_href(FILENAME_ADMIN_GAME_NEW);
$href_office	= set_href(FILENAME_ADMIN_USER_HOME);
$href_logout	= set_href(FILENAME_ADMIN_LOGOUT);
?>
<!-- BOF MENUBAR -->
<div id="menuBar">
	<a class="menuTitles" href="<?php echo $href_game; ?>">NEW GAME</a> | 
	<a class="menuTitles" href="<?php echo $href_team; ?>">TEAM</a> | 
	<a class="menuTitles" href="<?php echo $href_players; ?>">PLAYERS</a> | 
	<a class="menuTitles" href="<?php echo $href_blog; ?>">BLOG</a> | 
	<a class="menuTitles" href="<?php echo $href_playbook; ?>">PLAYBOOK</a> | 
	<a class="menuTitles" href="<?php echo $href_photos; ?>">PHOTOS</a> | 
	<a class="menuTitles" href="<?php echo $href_office; ?>">OFFICE</a> | 
	<a class="menuTitles" href="<?php echo $href_logout; ?>">LOG OUT</a>
	<div class="welcome">USER: <?php echo $_SESSION['user_first_name'].' '.$_SESSION['user_last_name']; ?></div>
</div>
<!-- EOF MENUBAR -->
