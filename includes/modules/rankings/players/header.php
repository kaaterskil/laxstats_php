<?php
$masthead_logo = MASTHEAD_PLAYER_RANKING;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Player Rankings');

//retrieve data
$plays = get_player_playing_stats($season);
$goals_obj = get_player_scoring_stats($season);
$penalties_obj = get_player_penalty_stats($season);
?>