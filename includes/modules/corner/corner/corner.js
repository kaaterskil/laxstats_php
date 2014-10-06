// JavaScript Document

/*------------------------------------------------------------
SHOW / HIDE BLOG COMMENTS
------------------------------------------------------------*/
function show_comments(obj, toggle){
	var sObj = obj + 's';
	var e = find_DOM(obj);
	var s = find_DOM(sObj);
	if(e){
		if(toggle){
			e.style.display = 'block';
			s.style.display = 'none';
		}else{
			e.style.display = 'none';
			s.style.display = 'inline';
		}
	}
}