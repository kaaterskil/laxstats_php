// JavaScript Document

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validate_academic(f){
	f.date.required = true;
	f.gpa.pattern = 'float';
	f.classes.pattern = 'text';
	f.activities.pattern = 'text';
	f.major.pattern = 'text';
	f.colleges.pattern = 'text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}