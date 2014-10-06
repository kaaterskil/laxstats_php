// JavaScript Document

/*----------------------------------------------------------------------
EDIT TEAM
----------------------------------------------------------------------*/
function edit_team(url){
	var w = 400;
	var h = 240;
	var ref = 'newTeam';
	open_popup(ref, url, w, h);
	return false;
}

/*------------------------------------------------------------
NEW / EDIT STAFF
------------------------------------------------------------*/
function open_staff(url){
	var w = 500;
	var h = 300;
	var ref = 'staff_window';
	open_popup(ref, url, w, h);
	return false;
}

/*------------------------------------------------------------
SELECT NEW / RETURNING PLAYER
------------------------------------------------------------*/
function select_form(url){
	var obj = document.select_player.player_type[1];
	var ep = find_DOM('returning_player');
	if(obj.checked){
		var er = find_DOM('roster');
		var ery = er.offsetTop;
		window.scrollTo(0, ery);
		ep.style.display = 'none';
		
		var w = screen.availWidth;
		var h = screen.availHeight;
		var x = 0;
		var y = 0;
		var wh = 0;
		var t = document.select_player.teamRef.value;
		if(h > 600){
			x = (w / 2) - 270;
			y = (h / 2) - 315;
			wh = 630;
		}else{
			x = (w / 2) - 270;
			y = (h / 2) - 250;
			wh = 500;
		}
		var new_player = window.open(url, 'new_player', 'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=no,width=600,height=' + wh + ',left=' + x + ',top=' + y);
		return false;
	}else{
		ep.style.display = 'inline';
	}
}

/*------------------------------------------------------------
NEW / EDIT PLAYER
------------------------------------------------------------*/
function open_player(url){
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
CONFIRM DELETE
------------------------------------------------------------*/
function confirm_delete(ty, url){
	var msg = '';
	switch(ty){
		case 1:
			msg = 'Delete this staff person?';
			break;
		case 2:
			msg = 'Remove this player from the roster?';
			break;
	}
	if(confirm(msg)){
		window.location.href = url;
	}
	return false;
}
