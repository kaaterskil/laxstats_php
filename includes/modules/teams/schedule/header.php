<?php
define('PAGE_TITLE', 'Team Schedule');
$masthead_logo = MASTHEAD_TEAM_SCHEDULE;
$tpl_menubar = MENUBAR_PUBLIC;

$scores = get_team_scores($teamRef);
$goals_obj = get_team_goals($teamRef);
$plays = get_team_plays($teamRef);
$faceoffs = get_team_faceoffs($teamRef);
$penalty_obj = get_team_penalties($teamRef);
?>