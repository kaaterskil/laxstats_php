// JavaScript Document

/*----------------------------------------------------------------------
CONFIRM DELETE
----------------------------------------------------------------------*/
function confirmDelete(type, url){
	if(type == 0){
		var msg = 'Delete the whole game?';
	}else{
		var msg = 'Delete the whole season, including players and staff?';
	}
	if(confirm(msg)){
		window.location.href = url;
		return true;
	}else{
		return false;
	}
}

/*----------------------------------------------------------------------
CONFIRM SUBMIT
----------------------------------------------------------------------*/
function confirmSubmit(url){
	var msg = 'Submit the game as \'Final\'?';
	if(confirm(msg)){
		window.location.href = url;
		return true;
	}else{
		return false;
	}
}

/*----------------------------------------------------------------------
CREATE NEW GAME
----------------------------------------------------------------------*/
function new_game(url){
	window.location.href = url;
}

/*----------------------------------------------------------------------
CREATE NEW SEASON
----------------------------------------------------------------------*/
function new_season(url){
	var w = 500;
	var h = 300;
	var ref = 'new_season';
	open_popup(ref, url, w, h);
	return false;
}

/*----------------------------------------------------------------------
FORMATTING FUNCTIONS
----------------------------------------------------------------------*/
function hideNote(){
	var e1 = find_DOM('noteOpener');
	var e2 = find_DOM('noteCloser');
	var e3 = find_DOM('noteBody');
	e1.style.display = 'none';
	e2.style.display = 'block';
	e3.style.display = 'none';
}
	
function showNote(){
	var e1 = find_DOM('noteOpener');
	var e2 = find_DOM('noteCloser');
	var e3 = find_DOM('noteBody');
	e1.style.display = 'block';
	e2.style.display = 'none';
	e3.style.display = 'block';
}

/*----------------------------------------------------------------------
CONFIRM SEASON DELETE
----------------------------------------------------------------------*/
function confirm_season_delete(url){
	var msg = 'Are you sure you want to delete this season?\nThis action will delete any related players and staff.';
	if(confirm(msg)){
		window.location.href = url;
	}
}

