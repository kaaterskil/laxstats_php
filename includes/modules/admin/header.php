<?php
if($_SESSION['user_affiliation'] == 'Administrator'){
	$href_home = set_href(FILENAME_ADMIN_DESIGNER_HOME);
}else{
	$href_home = set_href(FILENAME_ADMIN_USER_HOME);
}
$param = 'se=a';
$href_team_index = set_href(FILENAME_ADMIN_TEAM_INDEX, $param);
$href_fields = set_href(FILENAME_ADMIN_FIELD);
?>
	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="header"><?php echo PAGE_HEADER ?></div>
		<div class="subheader">
			<a href="<?php echo $href_home; ?>">Manager's Office</a> | 
			<a href="<?php echo $href_team_index; ?>">Full Team List</a> | 
			<a href="<?php echo $href_fields; ?>">Playing Fields</a>
<?php
if($page_ref == FILENAME_ADMIN_TEAM_INDEX && $teamMasterRef == 0){
	$param = 'sn='.(isset($state) ? $state : '');
	$href_state = set_href(FILENAME_ADMIN_TEAM_INDEX, $param);
	$selected_value = $href_state;
	$onChange = 'select_state(this.options[this.selectedIndex].value);';
	echo ' | State: ';
	draw_team_state_select('state', $selected_value, FILENAME_ADMIN_TEAM_INDEX, $onChange);
}
if($page_ref == FILENAME_ADMIN_FIELD){
	$param = 'sn='.(isset($state) ? $state : '');
	$href_state = set_href(FILENAME_ADMIN_FIELD, $param);
	$selected_value = $href_state;
	$onChange = 'select_state(this.options[this.selectedIndex].value);';
	echo ' | State: ';
	draw_team_state_select('state', $selected_value, FILENAME_ADMIN_FIELD, $onChange);
}
if($page_ref == FILENAME_ADMIN_PHOTOS){
	echo ' | ';
	draw_team_season_select($teamMasterRef, $season, FILENAME_ADMIN_PHOTOS);
}
if($page_ref == FILENAME_ADMIN_PLAYER){
	draw_team_season_select2($team_obj, FILENAME_ADMIN_PLAYER, $season);
	if($season != ''){
?>
			<span><?php draw_player_select2($teamRef, $playerMasterRef, FILENAME_ADMIN_PLAYER); ?></span>
<?php
	}
}
?>
		</div>
	</div>
	<!-- EOF HEADER -->
