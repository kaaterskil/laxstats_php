// JavaScript Document

/*------------------------------------------------------------
CHANGE SEASON
------------------------------------------------------------*/
function changeYear(url){
	window.location.href = url;
}

/*------------------------------------------------------------
CONFIRM DELETE
------------------------------------------------------------*/
function confirm_delete(url){
	var msg = 'Are you sure you want to delete this record?';
	if(confirm(msg)){
		window.location.href = url;
	}
}

/*------------------------------------------------------------
FORM VALIDATION
------------------------------------------------------------*/
function validate_photo(f){
	f.title.required = true;
	f.photo_date.required = true;
	f.title.pattern = 'text';
	f.photo_date.pattern = 'date';
	f.photographer.pattern = 'text';
	f.notes.pattern = 'text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}
