<?php
$page_code = (isset($_GET['p']) ? $_GET['p'] : '');
switch($page_code){
	case 'a1':
		$directory = 'admin/home';
		break;
	case 'a2':
		$directory = 'admin/team_index';
		break;
	case 'a3':
		$directory = 'admin/team';
		break;
	case 'a3n':
		$directory = 'admin/team_new';
		break;
	case 'a4':
		$directory = 'admin/season';
		break;
	case 'a5':
		$directory = 'admin/roster';
		break;
	case 'a6':
		$directory = 'admin/staff';
		break;
	case 'a7':
		$directory = 'admin/player';
		break;
	case 'a7n':
		$directory = 'admin/player_new';
		break;
	case 'a8':
		$directory = 'admin/photos';
		break;
	case 'a9':
		$directory = 'admin/game_new';
		break;
	case 'a10':
		$directory = 'admin/game_edit';
		break;
	case 'a11':
		$directory = 'admin/towns';
		break;
	case 'a12':
		$directory = 'admin/field';
		break;
	case 'a12n':
		$directory = 'admin/field_new';
		break;
	case 'a13':
		$directory = 'admin/blog';
		break;
	case 'a13n':
		$directory = 'admin/blog_new';
		break;
	case 'a14':
		$directory = 'admin/playbook';
		break;
	case 'a15':
		$directory = 'admin/corner';
		break;
	case 'a16':
		$directory = 'admin/athletics';
		break;
	case 'a17':
		$directory = 'admin/academics';
		break;
	case 'a18':
		$directory = 'admin/tests';
		break;
	case 'a19':
		$directory = 'admin/letters';
		break;
	case 'a20':
		$directory = 'admin/notes';
		break;
	case 'a20n':
		$directory = 'admin/note_attachment';
		break;
	case 'a21':
		$directory = 'admin/boosters';
		break;
	case 'a22':
		$directory = 'admin/logout';
		break;
	case 'b1':
		$directory = 'fans';
		break;
	case 'c1':
		$directory = 'corner/corner';
		break;
	case 'c2':
		$directory = 'corner/blog';
		break;
	case 'c3':
		$directory = 'corner/playbook';
		break;
	case 'c9':
		$directory = 'corner/download';
		break;
	case 'd1':
		$directory = 'designer/admin';
		break;
	case 'd2':
		$directory = 'designer/users';
		break;
	case 'd3':
		$directory = 'designer/users_new';
		break;
	case 'd4':
		$directory = 'designer/payments';
		break;
	case 'd5':
		$directory = 'designer/fouls';
		break;
	case 'd6':
		$directory = 'designer/fouls_new';
		break;
	case 'd7':
		$directory = 'designer/conference';
		break;
	case 'f1':
		$directory = 'fields/fields';
		break;
	case 'f2':
		$directory = 'fields/fields_print';
		break;
	case 'h1':
		$directory = 'help/sitemap';
		break;
	case 'h2':
		$directory = 'help/terms';
		break;
	case 'h3':
		$directory = 'help/privacy';
		break;
	case 'h4':
		$directory = 'help/subscribe';
		break;
	case 'h5':
		$directory = 'help/error';
		break;
	case 'p1':
		$directory = 'players/summary';
		break;
	case 'p2':
		$directory = 'players/stats';
		break;
	case 'p3':
		$directory = 'players/game_log';
		break;
	case 'p4':
		$directory = 'players/splits';
		break;
	case 'r1':
		$directory = 'rankings/teams';
		break;
	case 'r2':
		$directory = 'rankings/leaderboard';
		break;
	case 'r3':
		$directory = 'rankings/players';
		break;
	case 'r4':
		$directory = 'conference/rankings';
		break;
	case 'r5':
		$directory = 'conference/game_log';
		break;
	case 's1':
		$directory = 'results/scoreboard';
		break;
	case 's2':
		$directory = 'results/schedule';
		break;
	case 's3':
		$directory = 'results/box_score';
		break;
	case 't1':
		$directory = 'teams/team_index';
		break;
	case 't2':
		$directory = 'teams/stats';
		break;
	case 't3':
		$directory = 'teams/schedule';
		break;
	case 't4':
		$directory = 'teams/roster';
		break;
	case 't5':
		$directory = 'teams/depth';
		break;
	case 't6':
		$directory = 'teams/photos';
		break;
	case 'u1':
		$directory = 'login';
		break;
	case 'u2':
		$directory = 'new_user';
		break;
	default:
		$directory = 'home';
		break;
}
$tpl_directory = 'includes/modules/'.$directory.'/';
$tpl_name = (strrpos($directory, '/') !== false ? substr($directory, strrpos($directory, '/')) : $directory);
$tpl_body_file = $tpl_directory.$tpl_name.'.php';

//load page-specific language definitions
if($template->test_file_exists($tpl_directory, 'language.php')){
	include($tpl_directory.'language.php');
}
//load page-specific pre-processor
if($template->test_file_exists($tpl_directory, 'header.php')){
	include($tpl_directory.'header.php');
}

?>