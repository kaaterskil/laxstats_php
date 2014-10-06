// JavaScript Document

/*------------------------------------------------------------
REDIRECT
------------------------------------------------------------*/
function confirm_delete(url){
	var msg = 'Are you sure you want to delete this record?';
	if(confirm(msg)){
		window.location.href = url;
	}
}


/*------------------------------------------------------------
NEW / EDIT USER
------------------------------------------------------------*/
function open_user(url){
	var w = 560;
	var h = 400;
	var ref = 'user';
	open_popup(ref, url, w, h);
	return false;
}
