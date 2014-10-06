// JavaScript Document

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validate_foul(f){
	f.description.required = true;
	f.description.pattern = 'text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}
