// JavaScript Document

/*----------------------------------------------------------------------
EDIT TEAM
----------------------------------------------------------------------*/
function edit_team(url){
	var w = 500;
	var h = 360;
	var ref = 'edit_team';
	open_popup(ref, url, w, h);
	return false;
}

/*----------------------------------------------------------------------
NEW SEASON
----------------------------------------------------------------------*/
function new_season(url){
	var w = 500;
	var h = 300;
	var ref = 'new_season';
	open_popup(ref, url, w, h);
	return false;
}

/*----------------------------------------------------------------------
CONFIRM SEASON DELETE
----------------------------------------------------------------------*/
function confirm_season_delete(url){
	var msg = 'Are you sure you want to delete this season?\nThis action will delete any related players and staff.';
	if(confirm(msg)){
		window.location.href = url;
	}
}
