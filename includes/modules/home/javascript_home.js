// JavaScript Document
var rss_interval = null;
var rss_counter = 0;

function startCounter(){
	rss_interval = window.setInterval(refreshRSS, 1000 * 60);
}

function refreshRSS(){
	rss_counter++;
	if(rss_counter == 10){
		window.clearInterval(rss_interval);
		window.location.href = 'index.php';
	}
}
