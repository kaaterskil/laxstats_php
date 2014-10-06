<?php
include('includes/modules/corner/header.php');
?>
	<!-- BOF BODY -->
	<div class="body_container">
<?php
include('includes/modules/corner/menu.php');
?>
		<!-- bof playbook -->
		<div class="right_container">
			<div class="commentary" style="padding:0px 0px 5px 0px; ">
				<div style="float:left; "><b>Make Your Own Play!</b></div>
				<div style="text-align:right; "><a href="#" onClick="playbookPrint(document.playbook.teamMasterRef.value);">Printable Version</a></div>
			</div>
			<div class="movie">
				<div id="non_js"><div class="movieContainer">Sorry dude, but you need a javascript enabled browser to run the animation.</div>
			</div>
			<form name="playbook" action=""><?php echo draw_hidden_input_element('teamMasterRef', $teamMasterRef), draw_hidden_input_element('gender', $gender); ?></form>
			<script type="text/javascript" language="javascript">
			<!--
			if(is_js >= 1.0){
				var e = find_DOM('non_js');
				e.style.display = 'none';
				if(is_win){
					if(is_ie3 && is_win31){
						document.write('<div class="movieContainer">Sorry dude, but IE3 on Windows 3.1 won\'t support the animation.</div>');
						//theoretically, one could run it with Flash v6 without getURL.
					}else if((is_nav3 || is_nav4) && (is_win31)){
						document.write('<div class="movieContainer">Sorry dude, but Netscape 3 or Netscape 4 on Windows 3.1 won\'t support the animation.</div>');
						//theoretically, one could run it with Flash v6 without getURL.
					}else if(is_nav6 && (is_minor >= 6.0 && is_minor < 6.2)){
						//use FlashVars
						flashVarsMovie();
					}else{
						//use fscommand and swLiveConnect
						fscommandMovie();
					}
				}else if(is_mac){
					if(is_ie4){
						document.write('<div class="movieContainer">Sorry dude, but IE4 doesn\'t support this animation.</div>');
						//theoretically, one could run it with Flash v6 without getURL.
					}else if(is_mac68k){
						document.write('<div class="movieContainer">Sorry dude, but a 68000 Mac won\'t run the animation.</div>');
						//theoretically, one could run it with Flash v6 without getURL.
					}else if(is_ie){
						if((is_Flash) && (is_FlashVersion >= 7)){
							ieMovie();
						}else{
							var fv=plugin.description.substring(plugin.description.indexOf(".")-1);
							document.write('<div class="movieContainer">Sorry dude, but you need Flash Player version 6.0 r40 or higher to run the animation.<br>You\'ve got version ' + fv + '.</div>');
						}
					}else{
						flashVarsMovie();
					}
				}else{
					//for all other browsers, use FlashVars
					flashVarsMovie();
				}
			}else{
				var e = find_DOM('non_js');
				e.style.display = 'block';
			}
			-->
			</script>
			</div>
			<div class="commentary">
				<p>We've developed an animation tool so your coach can create customized plays. For the moment, you can, too. <b>CHECK IT OUT!</b></p>
				<p><b>FOR INSTRUCTIONS</b>, click <a href="#" onClick="openInfoA('playbook');">here</a>.</p>
				<p><b>TECHNICAL NOTE:</b> Certain browsers do not support the technology necessary for this animation to communicate with our server. For more information, click <a href="#" onClick="openInfoA('compatibility');">here</a>.</p>
			</div>
		</div>
		<!-- eof playbook -->
	</div>
	<!-- EOF BODY -->
