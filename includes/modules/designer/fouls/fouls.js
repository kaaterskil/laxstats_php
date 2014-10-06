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
NEW / EDIT FOUL
------------------------------------------------------------*/
function open_foul(url){
	var w = 420;
	var h = 250;
	var ref = 'user';
	open_popup(ref, url, w, h);
	return false;
}
