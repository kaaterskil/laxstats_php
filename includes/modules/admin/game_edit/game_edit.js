// JavaScript Document

/*************************************************************
FORMATTING
*************************************************************/
/*------------------------------------------------------------
GET Y OFFSET
------------------------------------------------------------*/
function get_offsetY(){
	var y = 0;
	if(document.all){
		if(!document.documentElement.scrollTop){
			y = document.body.scrollTop;
		}else{
			y = document.documentElement.scrollTop;
		}
	}else{
		y = window.pageYOffset;
	}
	return y;
}

/*------------------------------------------------------------
SET Y OFFSET
------------------------------------------------------------*/
function set_offsetY(f){
	var y = get_offsetY();
	f.offsetY.value = y;
}

/*************************************************************
MATHEMATICS
*************************************************************/
/*------------------------------------------------------------
TEST FOR NUMBER
------------------------------------------------------------*/
function get_number(obj){
	var v = parseInt(obj.value);
	if(v > 0){
		obj.value = v;
		return v;
	}else{
		obj.value = '';
		return 0;
	}
}

/*------------------------------------------------------------
COMPUTES GAME TOTAL
------------------------------------------------------------*/
function get_total(f){
	var a1 = get_number(f.va1);
	var a2 = get_number(f.va2);
	var a3 = get_number(f.va3);
	var a4 = get_number(f.va4);
	var aOT = get_number(f.vaOT);
	var b1 = get_number(f.vb1);
	var b2 = get_number(f.vb2);
	var b3 = get_number(f.vb3);
	var b4 = get_number(f.vb4);
	var bOT = get_number(f.vbOT);
	f.vaT.value = a1 + a2 + a3 + a4 + aOT;
	f.vbT.value = b1 + b2 + b3 + b4 + bOT;
}

/*************************************************************
ACTION
*************************************************************/
/*------------------------------------------------------------
PAGE ACTION
------------------------------------------------------------*/
function set_action(url, t){
	var y = get_offsetY();
	if(t){
		var msg = 'Delete this record?';
		if(confirm(msg)){
			window.location.href = url + '&sc=' + y;
		}
	}else{
		window.location.href = url + '&sc=' + y;
	}
}

/*------------------------------------------------------------
TOGGLE PLAYER ROSTER
------------------------------------------------------------*/
function toggle_roster(e, idh, idv){
	var h = find_DOM(idh);
	var v = find_DOM(idv);
	if(e.value == 'home'){
		h.style.display = 'block';
		v.style.display = 'none';
	}else{
		h.style.display = 'none';
		v.style.display = 'block';
	}
}

/*------------------------------------------------------------
GETS PLAYER POSITION
------------------------------------------------------------*/
function get_position(obj, f){
	f.position.value = '';
	var t = validate_select(obj, 2);
	if(t){
		for(var i = 0; i < obj.length; i++){
			if(obj.options[i].selected){
				var p = obj.options[i].text.indexOf(' ');
				if(p > 0 && p < 4){
					var str = obj.options[i].text.substr(0, p);
					var pos = str.match(/[a-zA-Z]/);
					if(pos){
						f.position.value = str;
					}
				}
				break;
			}
		}
	}
}

/*------------------------------------------------------------
SETS PLAYER STATUS TO 'PLAYED'
------------------------------------------------------------*/
function set_played(obj){
	if(obj.options[obj.selectedIndex].value > 0){
		document.plays.played.checked = true;
	}
}

/*************************************************************
FIELD VALIDATION
*************************************************************/
/*------------------------------------------------------------
VALIDATE GAME DATE
------------------------------------------------------------*/
function validate_game_date(obj){
	var str = validate_date(obj);
	if(str){
		obj.value = str;
		var date_array = str.split('/');
		var year = date_array[2];
		document.game.edit_season.value = year;
	}
}

/*------------------------------------------------------------
VALIDATE DROP-DOWN TEAM LIST
------------------------------------------------------------*/
function validate_select(obj, n){
	var t = '';
	var v = obj.options[obj.selectedIndex].value;
	if(v == 0){
		switch(n){
			case 1:
				t = 'field';
				break;
			case 2:
				t = 'player';
				break;
		}
		obj.options[0].selected = true;
		var msg = 'Please select a ' + t + '.';
		alert(msg);
		return false;
	}
	return true;
}

/*------------------------------------------------------------
VALIDATE STARTER PLAYED STATUS
------------------------------------------------------------*/
function validate_start(obj){
	if(obj.checked){
		document.plays.played.checked = true;
	}
}

/*------------------------------------------------------------
VALIDATE TIME CLOCK
validates up to 15-minute period
------------------------------------------------------------*/
function validate_clock(obj){
	var v = obj.value;
	var pattern = /^(0?[0-9]|[1][0-5])\:(0?[1-9]|[0-5][0-9])$/;
	var parts = v.match(pattern);
	if(parts){
		var minutes = parts[1];
		var seconds = parts[2];
		if(minutes.length < 2){
			minutes = '0' + minutes;
		}
		if(seconds.length < 2){
			seconds = '0' + seconds;
		}
		var r = minutes + ':' + seconds;
		obj.value = r;
		return true;
	}else{
		var msg = 'Please enter a valid clock time.';
		obj.value = '';
		alert(msg);
		return false;
	}
}

/*------------------------------------------------------------
VALIDATE PENALTY DURATION
------------------------------------------------------------*/
function validate_duration(obj){
	var v = obj.value;
	var pattern = /^([1-9]|[0-9]?\.(?:[0]|[5])|EJECT(?:ED)?|eject(?:ed)?)$/;
	var t = v.match(pattern);
	if(!t){
		var msg = 'Please enter a penalty time in decimal format, e.g. 1.0, 0.5, etc. or EJECT';
		obj.value = '';
		alert(msg);
		return false;
	}
	if(v.length == 1){
		v += '.0';
	}else{
		if(v.charAt(0) == '.'){
			v = '0' + v;
		}
	}
	obj.value = v.toUpperCase();
	return true;
}

/*------------------------------------------------------------
TEST FOR DUPLICATE SCORER / ASSIST
------------------------------------------------------------*/
function test_duplicate(obj){
	var assistID = obj.options[obj.selectedIndex].value;
	var f = document.goals;
	if(f.team[0].checked){
		var team = f.team[0].value;
	}else{
		var team = f.team[1].value;
	}
	if(team == 'home'){
		var o = f.roster_home_scorer;
	}else{
		var o = f.roster_visitor_scorer;
	}
	var scorerID = o.options[o.selectedIndex].value;
	if(assistID == scorerID){
		obj.options[0].selected = true;
		var msg = 'Dude, you can\'t assist your own goal.';
		alert(msg);
	}
}

/*------------------------------------------------------------
TEST IF PLAYER HAS BEEN SELECTED
------------------------------------------------------------*/
function test_player(f){
	var eh = f.roster_home;
	var ev = f.roster_visitor;
	var h = eh.options[eh.selectedIndex].value;
	var v = ev.options[ev.selectedIndex].value;
	if((h == 0 || h == null) && (v == 0 || e == null)){
		var msg = 'Please select a player.';
		alert(msg);
		return false;
	}
	return true;
}

/*------------------------------------------------------------
TEST FOR DATA
------------------------------------------------------------*/
function test_totals(f){
	get_total(f);
	var a = parseInt(f.vaT.value);
	var b = parseInt(f.vbT.value);
	if(a == 0 && b == 0){
		var msg = 'No data was entered.';
		alert(msg);
		return false;
	}
	return true;
}

/*************************************************************
FORM VALIDATION
*************************************************************/
/*------------------------------------------------------------
VALIDATE GAME
------------------------------------------------------------*/
function validate_game(f){
	f.edit_game_date.required = true;
	f.edit_game_time.required = true;
	f.edit_fieldRef.required = true;
	f.edit_weather.pattern = 'text';
	f.edit_referee.pattern = 'text';
	f.edit_umpire.pattern = 'text';
	f.edit_field_judge.pattern = 'text';
	f.edit_scorekeeper.pattern = 'text';
	f.edit_timekeeper.pattern = 'text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}

/*------------------------------------------------------------
VALIDATE PLAYER
------------------------------------------------------------*/
function validate_play(f){
	var t = test_player(f);
	if(!t){
		return false;
	}
	if(!f.played.checked){
		f.played.checked = true;
	}
	f.position.required = true;
	f.position.pattern = 'pattern';
	t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}

/*------------------------------------------------------------
VALIDATE GOAL
------------------------------------------------------------*/
function validate_goal(f){
	var t = test_player(f);
	if(!t){
		return false
	}
	f.quarter.required = true;
	f.clock.required = true;
	f.quarter.pattern = 'quarter';
	f.clock.pattern = 'clock';
	t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}

/*------------------------------------------------------------
VALIDATE PENALTY
------------------------------------------------------------*/
function validate_penalty(f){
	t = test_player(f);
	if(!t){
		return false;
	}
	f.quarter.required = true;
	f.clock.required = true;
	f.infraction.required = true;
	f.duration.required = true;
	f.quarter.pattern = 'quarter';
	f.clock.pattern = 'clock';
	f.duration.pattern = 'float';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}

/*------------------------------------------------------------
VALIDATE SAVE
------------------------------------------------------------*/
function validate_save(f){
	var t = test_player(f);
	if(!t){
		return false;
	}
	t = test_totals(f);
	if(!t){
		return false;
	}
	set_offsetY(f);
	return true;
}

/*------------------------------------------------------------
VALIDATE FACEOFF
------------------------------------------------------------*/
function validate_faceoff(f){
	var t = test_player(f);
	if(!t){
		return false;
	}
	t = test_totals(f);
	if(!t){
		return false;
	}
	set_offsetY(f);
	return true;
}

/*------------------------------------------------------------
VALIDATE FACEOFF
------------------------------------------------------------*/
function validate_clear(f){
	t = test_totals(f);
	if(!t){
		return false;
	}
	set_offsetY(f);
	return true;
}

/*----------------------------------------------------------------------
SUBMIT FINAL GAME
----------------------------------------------------------------------*/
function confirm_submit(url){
	var msg = 'Submit the game as \'Final\'?';
	if(confirm(msg)){
		window.location.href = url;
		return true;
	}else{
		return false;
	}
}
