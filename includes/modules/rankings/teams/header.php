<?php
$masthead_logo = MASTHEAD_TEAM_RANKING;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Team Highs');

//retrieve data
$goals_obj = get_top_team_goals($season);
$assists_obj = get_top_team_assists($season);
$shots_obj = get_top_team_shots($season);
$saves_obj = get_top_team_saves($season);
$gb_obj = get_top_team_gb($season);
?>