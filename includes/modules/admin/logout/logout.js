// JavaScript Document

/*------------------------------------------------------------
REDIRECT
------------------------------------------------------------*/
var c = 0;
var i = window.setInterval(gotoHome, 100);

function gotoHome(){
	c++;
	if(c == 30){
		window.clearInterval(i);
		window.location.href = 'index.php';
	}
}
