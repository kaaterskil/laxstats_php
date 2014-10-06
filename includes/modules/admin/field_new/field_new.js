// JavaScript Document

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validate_field(f){
	f.state.required = true;
	f.town.required = true;
	f.town.pattern = 'text';
	f.name.pattern = 'text';
	f.directions.pattern = 'text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}