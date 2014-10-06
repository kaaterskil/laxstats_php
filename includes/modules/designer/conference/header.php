<?php
//test privileges
test_privileges(0);
//set headers
$masthead_logo = MASTHEAD_ADMIN_RANKINGS;
$tpl_menubar = MENUBAR_ADMIN3;
define('PAGE_TITLE', 'Rankings Update');

$params = 'a=e';
$href_action = set_href(FILENAME_ADMIN_RANKINGS, $params);

$year = date('y');
$reader = array();
$message = '';
if($action != ''){
	if($action == 'e'){
		//retrieve POST variables
		$region1 = (isset($_POST['region1']) ? true : false);
		$region2 = (isset($_POST['region2']) ? true : false);
		$region3 = (isset($_POST['region3']) ? true : false);
		$region4 = (isset($_POST['region4']) ? true : false);
		$region5 = (isset($_POST['region5']) ? true : false);
		$region6 = (isset($_POST['region6']) ? true : false);
		$year = (isset($_POST['season']) ? substr($_POST['season'], 2, 4) : $year);
		//read pages
		for($i = 0; $i < 6; $i++){
			$region = '';
			$href = '';
			$start_string = 'george@laxpower.com';
			switch($i){
				case 0:
					if($region1){
						$region = 'MA MIAA East';
						$href = 'http://www.laxpower.com/update'.$year.'/binboy/rating33.php';
					}
					break;
				case 1:
					if($region2){
						$region = 'MA MIAA Central';
						$href = 'http://www.laxpower.com/update'.$year.'/binboy/rating34.php';
					}
					break;
				case 2:
					if($region3){
						$region = 'MA MIAA West';
						$href = 'http://www.laxpower.com/update'.$year.'/binboy/rating35.php';
					}
					break;
				case 3:
					if($region4){
						$region = 'MD MIAA/DC IAC';
						$href = 'http://www.laxpower.com/update'.$year.'/binboy/rating28.php';
					}
					break;
				case 4:
					if($region5){
						$region = 'VA Northern AAA';
						$href = 'http://www.laxpower.com/update'.$year.'/binboy/rating85.php';
					}
					break;
				case 5:
					if($region6){
						$region = 'New Jersey NJSIAA';
						$href = 'http://www.laxpower.com/update'.$year.'/binboy/rating47.php';
					}
					$start_string = 'tournament seedings on the LaxPower';
					break;
			}
			if($href != ''){
				$reader[] = new laxpower_reader($href, $year, $start_string);
			}
		}//end for
	}
}
?>