<?php
$masthead_logo = MASTHEAD_CONFERENCE_RANKING;
$tpl_menubar = MENUBAR_PUBLIC;
define('PAGE_TITLE', 'Conference Rankings');
$header_title = 'CONFERENCE STANDINGS';

//build ranking array
$rankings = array();
$teams = get_conference_teams($season, $state, $conference);
if(count($teams->result['teamMasterRef']) > 0){
	while(!$teams->eof){
		//get data
		$teamMasterRef	= $teams->field['teamMasterRef'];
		$town			= $teams->field['town'];
		$conference		= $teams->field['conference'];
		$league			= $teams->field['league'];
		$division		= $teams->field['division'];
		$t_division		= $teams->field['t_division'];
		$division		= ($t_division != NULL && $t_division != $division ? $t_division : $division);
		//get record
		$win				= 0;
		$loss				= 0;
		$division_win		= 0;
		$division_loss		= 0;
		$league_win			= 0;
		$league_loss		= 0;
		$conference_win		= 0;
		$conference_loss	= 0;
		$games = get_conference_team_games($teamMasterRef, $season);
		if(count($games->result['gameRef']) > 0){
			while(!$games->eof){
				//get data
				$us_score	= $games->field['us_score'];
				$them_score	= $games->field['them_score'];
				$ct			= $games->field['conference'];
				$lt			= $games->field['league'];
				$dt			= $games->field['division'];
				$dt2		= $games->field['t_division'];
				//process data
				$dt = ($dt2 != '' && $dt2 != $dt ? $dt2 : $dt);
				if($us_score > $them_score){
					$win++;
					$division_win		= ($dt == $division ? $division_win++ : $division_win);
					$league_win			= ($lt == $league ? $league_win++ : $league_win);
					$conference_win		= ($ct == $conference ? $conference_win++ : $conference_win);
				}elseif($them_score > $us_score){
					$loss++;
					$division_loss		= ($dt == $division ? $division_loss++ : $division_loss);
					$league_loss		= ($lt == $league ? $league_loss++ : $league_loss);
					$conference_loss	= ($ct == $conference ? $conference_loss++ : $conference_loss);
				}
				//increment
				$games->move_next();
			}
		}
		//process data
		$overall_pct	= ($win + $loss > 0 ? $win / ($win + $loss) : 0);
		$conference_pct	= ($conference_win + $conference_loss > 0 ? $conference_win / ($conference_win + $conference_loss) : 0);
		$league_pct		= ($league_win + $league_loss > 0 ? $league_win / ($league_win + $league_loss) : 0);
		$division_pct	= ($division_win + $division_loss > 0 ? $division_win / ($division_win + $division_loss) : 0);
		//add to array
		$rankings['teamMasterRef'][]	= $teamMasterRef;
		$rankings['town'][]				= $town;
		$rankings['conference'][]		= $conference;
		$rankings['league'][]			= $league;
		$rankings['division'][]			= $division;
		$rankings['win'][]				= $win;
		$rankings['loss'][]				= $loss;
		$rankings['conference_win'][]	= $conference_win;
		$rankings['conference_loss'][]	= $conference_loss;
		$rankings['league_win'][]		= $league_win;
		$rankings['league_loss'][]		= $league_loss;
		$rankings['division_win'][]		= $division_win;
		$rankings['division_loss'][]	= $division_loss;
		$rankings['overall_pct'][]		= $overall_pct;
		$rankings['conference_pct'][]	= $conference_pct;
		$rankings['league_pct'][]		= $league_pct;
		$rankings['division_pct'][]		= $division_pct;
		//increment
		$teams->move_next();
	}
}
?>