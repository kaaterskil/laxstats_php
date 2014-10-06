// JavaScript Document

/*----------------------------------------------------------------------
CREATE FIELD
----------------------------------------------------------------------*/
function open_blog(url){
	var w = 590;
	var sh = screen.availHeight;
	if(sh >= 780){
		h = 780;
	}else{
		h = 500;
	}
	var ref = 'blog';
	open_popup(ref, url, w, h);
	return false;
}

/*----------------------------------------------------------------------
DELETE FIELD
----------------------------------------------------------------------*/
function confirm_delete(url){
	var msg = 'Delete this record?';
	if(confirm(msg)){
		window.location.href = url;
	}
	return false;
}
