// JavaScript Document
/*--------------------------------------------------
VALIDATE FORM
--------------------------------------------------*/
function validate_fan(f){
	var tm = f.teamMasterRef.options[f.teamMasterRef.selectedIndex].value;
	if(tm == 0){
		var msg = 'Please select a team.';
		alert(msg);
		return false;
	}else{
		f.first_name.required = true;
		f.last_name.required = true;
		f.email.required = true;
		f.first_name.pattern = 'text';
		f.last_name.pattern = 'text';
		f.street1.pattern = 'text';
		f.street2.pattern = 'text';
		f.city.pattern = 'text';
		f.zip_code.pattern = 'ZIP_Code';
		f.telephone.pattern = 'telephone';
		f.email.pattern = 'email';
		var t = validate_form(f);
		if(!t){
			return false;
		}
		return true;
	}
}
