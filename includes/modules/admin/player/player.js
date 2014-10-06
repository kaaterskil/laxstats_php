// JavaScript Document

/*----------------------------------------------------------------------
REDIRECT
----------------------------------------------------------------------*/
function change_season(url){
	window.location.href = url;
}
function change_player(url){
	window.location.href = url;
}

/*------------------------------------------------------------
EDIT PLAYER
------------------------------------------------------------*/
function edit_player(url){
	var w = screen.availWidth;
	var h = screen.availHeight;
	var x = 0;
	var y = 0;
	var wh = 0;
	if(h > 600){
		x = (w / 2) - 270;
		y = (h / 2) - 315;
		wh = 630;
	}else{
		x = (w / 2) - 270;
		y = (h / 2) - 250;
		wh = 500;
	}
	var edit_player = window.open(url, 'edit_player','toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,width=600,height=' + wh + ',left=' + x + ',top=' + y);
	return false;
}

/*------------------------------------------------------------
NEW / EDIT ATHLETIC RECORD
------------------------------------------------------------*/
function open_athletic(url){
	var w = 560;
	var h = 350;
	var ref = "athletic";
	open_popup(ref, url, w, h);
	return false;
}

/*------------------------------------------------------------
NEW / EDIT ACADEMIC RECORD
------------------------------------------------------------*/
function open_academic(url){
	var w = 560;
	var h = screen.height > 600 ? 600 : screen.height;
	var ref = "academic";
	open_popup(ref, url, w, h);
	return false;
}

/*------------------------------------------------------------
NEW / EDIT TEST RECORD
------------------------------------------------------------*/
function open_test(url){
	var w = 560;
	var h = 260;
	var ref = "test";
	open_popup(ref, url, w, h);
	return false;
}

/*------------------------------------------------------------
NEW / EDIT COMMENT RECORD
------------------------------------------------------------*/
function open_comment(url){
	var w = 560;
	var h = 480;
	var ref = "comment";
	open_popup(ref, url, w, h);
	return false;
}

/*------------------------------------------------------------
NEW / EDIT NOTE RECORD
------------------------------------------------------------*/
function open_note(url){
	var w = 600;
	var h = 550;
	var ref = "note";
	open_popup(ref, url, w, h);
	return false;
}

/*------------------------------------------------------------
CONFIRM DELETE RECORD
------------------------------------------------------------*/
function confirm_delete(n, url){
	var v = new Array('athletic', 'academic', 'test', 'comment', 'note');
	var msg = 'Delete the ' + v[n] + ' record?';
	if(confirm(msg)){
		window.location.href = url;
		return true;
	}
	return false;
}
