<?php
$href_game = set_href(FILENAME_ADMIN_GAME_NEW);
$param = 'se=a';
$href_team_index = set_href(FILENAME_ADMIN_TEAM_INDEX, $param);
$href_fields = set_href(FILENAME_ADMIN_FIELD);
$href_fouls = set_href(FILENAME_ADMIN_FOULS);
$href_updates = set_href(FILENAME_ADMIN_RANKINGS);
$href_users = set_href(FILENAME_ADMIN_USERS);
$href_payments = set_href(FILENAME_ADMIN_PAYMENTS);
$href_office = set_href(FILENAME_ADMIN_DESIGNER_HOME);
$href_logout = set_href(FILENAME_ADMIN_LOGOUT);
?>
<!-- BOF MENUBAR -->
<div id="menuBar">
	<a class="menuTitles" href="<?php echo $href_game; ?>">NEW GAME</a> | 
	<a class="menuTitles" href="<?php echo $href_team_index; ?>">TEAMS</a> | 
	<a class="menuTitles" href="<?php echo $href_fields; ?>">FIELDS</a> | 
	<a class="menuTitles" href="<?php echo $href_fouls; ?>">FOULS</a> | 
	<a class="menuTitles" href="<?php echo $href_updates; ?>">UPDATES</a> | 
	<a class="menuTitles" href="<?php echo $href_users; ?>">USERS</a> | 
	<a class="menuTitles" href="<?php echo $href_payments; ?>">PAYMENTS</a> | 
	<a class="menuTitles" href="<?php echo $href_office; ?>">OFFICE</a> | 
	<a class="menuTitles" href="<?php echo $href_logout; ?>">LOG OUT</a>
	<div class="welcome">USER: <?php echo $_SESSION['user_first_name'].' '.$_SESSION['user_last_name']; ?></div>
</div>
<!-- EOF MENUBAR -->
