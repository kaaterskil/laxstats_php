// JavaScript Document
function enterPassword(href){
	msg = 'Please enter your team password:';
	if(pt = prompt(msg, '')){
		window.location.href = href + '&pt=' + pt;
	}
}

function changeYear(h){
	window.location.href = h;
}

function changeTeam(h){
	window.location.href = h;
}

function changeSort(tmr, tr, s, ty, st){
	var url = 'index.php?p=t3&tmr=' + tmr + '&tr=' + tr + '&s=' + s + '&ty=' + ty + '&st=' + st;
	window.location.href=url;
}

function openWindow(h){
	window.open('image.php?id=' + h, 'Image', 'location=no,menubar=no,scrollbars=yes,toolbar=no');
}

function show_stat(s){
	var es = find_DOM(s);
	es.style.visibility = 'visible';
}

function hide_stat(s){
	var es = find_DOM(s);
	es.style.visibility = 'hidden';
}
