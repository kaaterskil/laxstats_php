// JavaScript Document

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validate_season(f){
	f.season.required = true;
	f.name.pattern = 'text';
	f.season.pattern = 'year';
	f.division.pattern = 'text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();
