<?php
$current_month = date('n');
$current_year = date('Y');
$href_teams = set_href(FILENAME_TEAM_INDEX);

$param = 's='.$current_year.'&m='.$current_month;
$href_scoreboard = set_href(FILENAME_SCOREBOARD, $param);
$href_schedule = set_href(FILENAME_SCHEDULE, $param);

$param = 's='.$current_year;
$href_leaderboard = set_href(FILENAME_LEADERBOARD, $param);

$param = 'f=A';
$href_fields = set_href(FILENAME_FIELD, $param);
$href_fans = set_href(FILENAME_FAN);
$href_admin = set_href(FILENAME_LOGIN);
?>
<!-- BOF MENUBAR -->
<div id="menuBar">
	<a class="menuTitles" href="index.php">HOME</a> | 
	<a class="menuTitles" href="<?php echo $href_teams; ?>">TEAMS</a> | 
	<a class="menuTitles" href="<?php echo $href_scoreboard; ?>">SCOREBOARD</a> | 
	<a class="menuTitles" href="<?php echo $href_schedule; ?>">SCHEDULE</a> | 
	<a class="menuTitles" href="<?php echo $href_leaderboard; ?>">PLAYERS</a> | 
	<a class="menuTitles" href="<?php echo $href_fields; ?>">FIELDS</a> | 
	<a class="menuTitles" href="<?php echo $href_fans; ?>">FANS</a> | 
	<a class="menuTitles" href="<?php echo $href_admin; ?>">MANAGER'S OFFICE</a>
</div>
<!-- EOF MENUBAR -->
