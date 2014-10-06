// JavaScript Document

/*------------------------------------------------------------
TEST FOR SELECTED TEAM
------------------------------------------------------------*/
function test_selected_team(v){
	if(v == 0){
		var msg = "Please select a team.";
		alert(msg);
	}
}

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validateUser(f){
	f.first_name.required = true;
	f.last_name.required = true;
	f.teamMasterRef.required = true;
	f.email.required = true;
	f.email2.required = true;
	f.username.required = true;
	f.password.required = true;
	f.password2.required = true;
	f.first_name.pattern = 'text';
	f.last_name.pattern = 'text';
	f.telephone.pattern = 'telephone';
	f.email.pattern = 'email';
	f.email2.pattern = 'email';
	f.username.pattern = 'text';
	f.password.pattern = 'text';
	f.password.pattern = 'text';
	
	var err = '';
	if(f.email.value != f.email2.value){
		err += "\n" + 'The email addresses must match.';
	}
	if(f.password.value != f.password2.value){
		err += "\n" + 'The passwords must match.';
	}
	if(err! = ""){
		var msg = "Hold up!\n" + err;
		alert(msg);
		return false;
	}
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}
