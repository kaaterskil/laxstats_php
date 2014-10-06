// JavaScript Document

/*------------------------------------------------------------
CHANGES RANKINGS SEASON
------------------------------------------------------------*/
function changeSeason(url){
	window.location.href = url;
}

function changeSelect(h){
	if(h != ''){
		window.location.href = h;
	}
}

/*------------------------------------------------------------
CHANGES RANKINGS SORT
------------------------------------------------------------*/
function changeSort(st){
	var q = window.location.search.substring(1);
	var qv = q.split('&', 2);
	var s = qv[1];
	var url = 'index.php?p=r3&' + s + '&st=' + st;
	window.location.href = url;
}
