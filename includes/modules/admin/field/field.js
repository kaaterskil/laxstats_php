// JavaScript Document

/*----------------------------------------------------------------------
REDIRECT
----------------------------------------------------------------------*/
function select_state(url){
	window.location.href = url;
}

/*----------------------------------------------------------------------
CREATE FIELD
----------------------------------------------------------------------*/
function new_field(url){
	var w = 500;
	var h = 460;
	var ref = 'new_field';
	open_popup(ref, url, w, h);
	return false;
}

/*----------------------------------------------------------------------
EDIT FIELD
----------------------------------------------------------------------*/
function edit_field(url){
	var w = 500;
	var h = 460;
	var ref = 'edit_field';
	open_popup(ref, url, w, h);
	return false;
}

/*----------------------------------------------------------------------
DELETE FIELD
----------------------------------------------------------------------*/
function confirm_delete(url){
	var msg = 'Delete this field?';
	if(confirm(msg)){
		window.location.href = url;
	}
	return false;
}
