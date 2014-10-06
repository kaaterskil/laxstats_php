// JavaScript Document

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();

/*------------------------------------------------------------
TOGGLE DESCRIPTION LABEL
------------------------------------------------------------*/
function toggle_label(v){
	var e = find_DOM('description');
	e.innerHTML = (v == 'L' ? 'List achievements:' : 'List sport(s), position(s), achievements:');
}

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validate_athletic(f){
	f.date.required = true;
	f.sport.required = true;
	f.description.pattern = 'text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}