// JavaScript Document

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validate_user(f){
	f.first_name.required = true;
	f.last_name.required = true;
	f.affiliation.required = true;
	f.email.required = true;
	f.username.required = true;
	f.password.required = true;
	f.first_name.pattern = 'text';
	f.last_name.pattern = 'text';
	f.telephone.pattern = 'telephone';
	f.email.pattern = 'email';
	f.username.pattern = 'text';
	f.password.pattern = 'text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}
