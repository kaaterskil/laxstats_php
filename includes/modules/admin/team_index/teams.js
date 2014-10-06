// JavaScript Document
/*----------------------------------------------------------------------
REDIRECT
----------------------------------------------------------------------*/
function select_state(url){
	window.location.href = url;
}

/*----------------------------------------------------------------------
CREATE TEAM
----------------------------------------------------------------------*/
function new_team(url){
	var w = 500;
	var h = 360;
	var ref = 'new_team';
	open_popup(ref, url, w, h);
	return false;
}

/*----------------------------------------------------------------------
EDIT TEAM
----------------------------------------------------------------------*/
function edit_team(url){
	var w = 500;
	var h = 360;
	var ref = 'newTeam';
	open_popup(ref, url, w, h);
	return false;
}

/*----------------------------------------------------------------------
DELETE TEAM
----------------------------------------------------------------------*/
function confirm_delete(url){
	var msg = 'Delete this team?';
	if(confirm(msg)){
		window.location.href = url;
	}
}

/*----------------------------------------------------------------------
USER ALERT
----------------------------------------------------------------------*/
function user_notice(){
	var msg = 'This team is a current Laxstats subscriber. You may not edit it.';
	alert(msg);
}
