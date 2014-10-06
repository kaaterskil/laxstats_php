<?php
$href_team_index = set_href(FILENAME_TEAM_INDEX);
$href_scoreboard = set_href(FILENAME_SCOREBOARD).'&s='.$current_year.'&m='.$current_month;
$href_schedule = set_href(FILENAME_SCHEDULE).'&s='.$current_year.'&m='.$current_month;
$href_leaderboard = set_href(FILENAME_LEADERBOARD).'&s='.$current_year;
$href_fields = set_href(FILENAME_FIELD).'&f=A';
$href_fans = set_href(FILENAME_FAN);
$href_login = set_href(FILENAME_LOGIN);
$href_sitemap = set_href(FILENAME_SITEMAP);
$href_privacy = set_href(FILENAME_PRIVACY);
$href_terms = set_href(FILENAME_TERMS);
$href_subscribe = set_href(FILENAME_SUBSCRIBE);
?>
	<!--BOF HEADER -->
	<div id="pageTitle">
		<div class="header">SITEMAP</div>
	</div>
	<!--EOF HEADER -->
	
	<!--BOF BODY -->
	<div class="sitemapContainer">
		<div class="sitemapCategory">Statistics</div>
		<div class="sitemap">
			<p><a href="<?php echo $href_team_index; ?>">Team Index</a><br>
			Select a team to find conference rankings, season statistics, game logs, schedules, box scores and photos.
			</p>
			<p>
			<a href="<?php echo $href_leaderboard; ?>">Player Leaderboard</a><br>
<br>
			Includes sortable rankings, individual cumulative and season statistics, individual game highs by season, game logs and split statitsics.
			</p>
		</div>
		
		<div class="sitemapCategory">Insider</div>
		<div class="sitemap">
			<a href="<?php echo $href_scoreboard; ?>">Scoreboard</a><br>
			<a href="<?php echo $href_schedule; ?>">Schedule</a><br>
			<a href="<?php echo $href_fields; ?>">Playing Field Directory</a><br>
			<a href="<?php echo $href_fans; ?>">Fan Registration</a><br><br>
		</div>
			
		<div class="sitemapCategory">Coach's Corner</div>
		<div class="sitemap">
			Coach's Corner<br>
			Blog<br>
			Playbook
			<p>Note: These pages are team-specific. To visit them, find your team <a href="<?php echo $href_team_index; ?>">here</a>.</p>
		</div>
		
		<div class="sitemapCategory">Manager's Office</div>
		<div class="sitemap">
			Game and Scoring Data Entry<br>
			Team and Season Maintenance<br>
			Coach's Blog<br>
			Player Profile<br>
			Playbook Maintenance<br>
			Photo Maintenance<br>
			Field Maintenance<br>
			Foul Maintenance
			<p>Note: This is a secure area. You must have data entry privileges. If you do, click <a href="<?php echo $href_login; ?>">here</a>.</p>
		</div>
		
		<div class="sitemapCategory">Help</div>
		<div class="sitemap">
			<a href="<?php echo $href_sitemap; ?>">Sitemap</a><br>
			<a href="<?php echo $href_terms; ?>">Terms of Use</a><br>
			<a href="<?php echo $href_privacy; ?>">Privacy Policy</a><br>
			<a href="<?php echo $href_subscribe; ?>">Subscription Information</a><br>
			<a href="mailto:questions@laxstats.net">Contact Us</a>
		</div>
	</div>
		<!--EOF BODY -->
