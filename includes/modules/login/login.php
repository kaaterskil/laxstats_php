	<div class="body_container">
		<!-- bof text block -->
		<div class="right_column">
			<div class="header">MANAGER'S OFFICE</div>
			<div class="text_container">
				<p class="text">Let's face it, paperwork sucks. It's here in the Manager's Office where much of the grunt work happens when it's not happening on the field. Like keeping all the paperwork in order, entering game data, maintaining team and player information, writing letters, emails and notices, blah blah. C'mon, you know you hate it: it's a little like taking out the trash, but it has to be done. That's where we come in.</p>
				<p class="text">We've made this work as easy and straightforward as we know how, and we've made it so the amount of the data you track and the work you do is entirely up to you. So if you're a coach or a team manager or just the one keeping the scorebook, it doesn't matter whether you're a statistics nut or just a helping hand. Go ahead, pop the hood of this baby and poke around inside. Your team will be glad you did.</p>
				<p class="text">Just so no one comes around messing up your stuff, we've protected this area so you'll need a username and password to get into your private, team-specific office. If you haven't got one, get one and get cracking. Your team is waiting!</p>
				<p class="text">You don't need to be a Laxstats subscriber to visit the Manager's Office. Hit the "Register" button and fill out a short form to log on. Visit all you want, but remember you won't be able to save anything until you join up. When you're ready, click the link below for information on how to subscribe.</p>
			</div>
		</div>
		<!-- eof text block -->
		
		<!-- bof login entry -->
		<div class="left_column">
			<!-- bof returning user -->
			<div class="login_title">Log In</div>
			<div class="login_box">
				<form name="login" method="post" onSubmit="returning_user(this);" action="<?php echo $href_action; ?>">
				<div class="form_text"><b>Log in here.</b></div>
				<div class="form_text"><b>Enter your user name:</b><br>(Either your complete email address or the Login ID you created.)</div>
				<div class="form_text"><?php  echo draw_text_input_element('username', '', 30, 30, $username); ?></div>
				<div class="form_text"><b>Enter your password:</b></div>
				<div class="form_text"><?php echo draw_password_input_element('password', '', 30, 8, $password); ?></div>
				<div class="buttonText"><input type="submit" name="login" value="Log In"></div>
				<div class="error"><?php echo $message; ?></div>
				<div class="form_text"><b>Forgot your password?</b><br>
					Email us at <a href="mailto:questions@laxstats.net">questions@laxstats.net</a></div>
				</form>
			</div>
			<!-- eof returning user -->
			
			<!-- bof new user -->
			<div class="login_title">New User</div>
			<div class="login_box">
				<div class="form_text">Click below to start using <b>laxstats</b> to help manage your team.</div>
				<div class="buttonText"><input type="button" name="newUser" value="Register" onClick="new_user('<?php echo $href_new_user; ?>');";></div>
			</div>
			<!-- eof new user -->
		</div>
		<!-- eof login entry -->
	</div>
