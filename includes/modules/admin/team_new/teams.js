// JavaScript Document

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();

/*----------------------------------------------------------------------
VALIDATE NEW/EDIT TEAM FORM
----------------------------------------------------------------------*/
function validateTeam(f){
	f.town.required = true;
	f.gender.required = true;
	f.type.required = true;
	f.conference.required = true;
	f.town.pattern = 'text';
	f.team_name.pattern = 'text';
	f.short_name.pattern = 'text';
	f.conference.pattern = 'text';
	f.league.pattern = 'text';
	f.division.pattern = 'text';
	var t = validateForm(f);
	if(!t){
		return false;
	}
	return true;
}
