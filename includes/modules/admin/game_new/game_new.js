// JavaScript Document
/*------------------------------------------------------------
VALIDATE GAME
------------------------------------------------------------*/
function validate_game(f){
	f.date.required = true;
	f.start_time.required = true;
	f.fieldRef.required = true;
	f.home_tmr.required = true;
	f.visitor_tmr.required = true;
	f.weather.pattern = 'text';
	f.referee.pattern = 'text';
	f.umpire.pattern = 'text';
	f.field_judge.pattern = 'text';
	f.scorekeeper.pattern = 'text';
	f.timekeeper.pattern = 'text';
	var t = validate_form(f);
	if(!t){
		return false;
	}
	return true;
}

/*------------------------------------------------------------
VALIDATE DATE
------------------------------------------------------------*/
function validate_game_date(obj){
	var str = validate_date(obj);
	if(str){
		obj.value = str;
		var date_array = str.split('/');
		var year = date_array[2];
		document.new_game.season.value = year;
	}
}

/*------------------------------------------------------------
VALIDATE DROP-DOWN LIST
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
				t = 'team';
				break;
		}
		obj.options[0].selected == true;
		var msg = 'Please select a ' + t + '.';
		alert(msg);
	}else{
		if(n == 2){
			var he = document.new_game.home_tmr;
			var ve = document.new_game.visitor_tmr;
			var home_tmr = he.options[he.selectedIndex].value;
			var visitor_tmr = ve.options[ve.selectedIndex].value;
			if(home_tmr == visitor_tmr){
				var msg = 'You must select two different teams.';
				he.options[0].selected = true;
				ve.options[0].selected = true;
				alert(msg);
			}
		}
	}
}
