<?php
$masthead_logo = MASTHEAD_LEADERBOARD;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Leaderboard');

//retrieve data
$points_obj		= get_top_points($season);
$goals_obj		= get_top_goals($season);
$assists_obj	= get_top_assists($season);
$shots_obj		= get_top_shots($season);
$gb_obj			= get_top_gb($season);
$saves_obj		= get_top_saves($season);
$penalties_obj	= get_top_penalties($season);
$minutes_obj	= get_top_minutes($season);
?>