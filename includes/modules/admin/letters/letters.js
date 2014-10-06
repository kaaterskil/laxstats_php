// JavaScript Document

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validate_letter(f){
	f.date.required = true;
	f.comments.pattern = 'text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}