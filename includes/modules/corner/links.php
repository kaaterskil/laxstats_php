<?php
$params			= 'tmr='.$teamMasterRef.'&tr='.$teamRef.'&s='.$season;
$href_stats		= set_href(FILENAME_TEAM_STATS, $params).'&ty=F';
$href_schedule	= set_href(FILENAME_TEAM_SCHEDULE, $params);
$href_roster	= set_href(FILENAME_TEAM_ROSTER, $params);
$href_depth		= set_href(FILENAME_TEAM_DEPTH, $params);
$href_photos	= set_href(FILENAME_TEAM_PHOTOS, $params).'&se=A';

$params			= get_all_get_params(array('p', 'br', 'a'));
$href_corner	= set_href(FILENAME_CORNER_HOME, $params);
$href_playbook	= set_href(FILENAME_CORNER_PLAYBOOK, $params);
?>
			<!-- bof cool stuff -->
			<div class="menu_category">Cool Stuff
				<div class="menu_list"><a href="<?php echo $href_stats; ?>">Statistics</a></div>
				<div class="menu_list"><a href="<?php echo $href_schedule; ?>">Schedule</a></div>
				<div class="menu_list"><a href="<?php echo $href_roster; ?>">Roster</a></div>
				<div class="menu_list"><a href="<?php echo $href_depth; ?>">Depth Chart</a></div>
				<div class="menu_list"><a href="<?php echo $href_photos; ?>">Photos</a></div>
				<div class="menu_list"><a href="<?php echo $href_corner; ?>">Coach's Corner</a></div>
				<div class="menu_list"><a href="<?php echo $href_playbook; ?>">Playbook</a></div>
			</div>
			<!-- eof cool stuff -->
