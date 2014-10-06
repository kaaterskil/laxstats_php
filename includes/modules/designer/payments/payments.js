// JavaScript Document

/*------------------------------------------------------------
SELECT TEAM
------------------------------------------------------------*/
function select_team(url, search_value){
	window.location.href = url + search_value;
}

/*------------------------------------------------------------
VALIDATE FORM
------------------------------------------------------------*/
function validate_payment(f){
	f.season.required = true;
	f.payment.required = true;
	f.season.pattern = 'year';
	f.payment.pattern = 'dollar';
	var t = validate_form(f);
	if(!t){
		return false
	}
	return true;
}
