// JavaScript Document

/*------------------------------------------------------------
RELOAD PARENT WINDOW
------------------------------------------------------------*/
window.opener.location.reload();

/*----------------------------------------------------------------------
VALIDATE NEW/EDIT STAFF FORM
----------------------------------------------------------------------*/
function validate_staff(f){
	f.name.required = true;
	f.staff_type.required = true;
	f.name.pattern = 'text';
	f.street1.pattern = 'text';
	f.street2.pattern = 'text';
	f.city.pattern = 'text';
	f.ZIP_Code.pattern = 'ZIP_Code';
	f.telephone1.pattern = 'telephone';
	f.telephone2.pattern = 'telephone';
	f.extension.pattern = 'text';
	f.email.pattern = 'email';
	var t = validateForm(f);
	if(!t){
		return false;
	}
	return true;
}
