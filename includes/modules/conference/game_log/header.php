<?php
$masthead_logo = MASTHEAD_CONFERENCE_GAME_LOG;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Game Log');

$params = get_all_get_params(array('p', 'tmr'));
$href_conference = set_href(FILENAME_CONFERENCE_RANKING, $params);

$conference_record	= '0-0';
$league_record		= '0-0';
$division_record	= '0-0';
$overall_record		= '0-0';

$team = get_conference_team_data($teamMasterRef, $season);
$town				= $team->field['town'];
$team_name			= strtoupper($team->field['team_name']);
$state				= $team->field['state'];
$conference			= $team->field['conference'];
$league				= $team->field['league'];
$division			= $team->field['division'];
$dt					= $team->field['t_division'];
$wins				= $team->field['wins'];
$losses				= $team->field['losses'];

$division			= ($dt != null && $dt != $division ? $dt : $division);
$overall_record		= $wins.'-'.$losses;
$header_title		= $team_name.'<br>'.$season.' GAME LOG ('.$overall_record.')';

$team_data = 'State: <b>'.$state.'</b><br>Conference: <b>'.$conference.'</b><br>League: <b>'.$league.'</b><br>Division: <b>'.$division.'</b>';

$games = get_conference_team_log($teamMasterRef, $season);
?>