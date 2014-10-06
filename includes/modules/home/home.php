	<!-- BOF BODY -->
	<div class="body_container">
		<!-- bof text block -->
		<div class="right_column">
			<div class="header"><b>LAXSTATS NEWS</b></div>
			<div class="letterContainer">
				<p class="letterText"><span class="monthText">March 2007:</span> Here we are again at the beginning of another season. We re-coded the entire site to make it more responsive. In addition, we kept pace with changes over at Laxpower and added a few new newsfeeds at left. Please let us know if we missed something and it no longer works.</p>
				<p class="letterText"><span class="monthText">April 2006:</span> With lax season underway, we'd like to thank the coaches at <b>Medfield</b>, <b>Milton</b>, <b>Waltham</b> and <b>Walpole</b> for their support. Some of their games have already been posted and more will be coming as we get everyone up to speed. We've been busy in the meantime adding little bells and whistles here and there to help coaches out. Some of you may have noticed that we lost our link to <b>LaxPower</b> for several days but, thanks to their great team, we're back up and even more solid.</p>
				<p class="letterText"><span class="monthText">March 2006:</span> We've added <b>conference standings</b>: Conferences for Laxstats subscribers have complete game history going back a couple of years and will be updated regularly for the current season. You can find this trove of information from the Team Index. We've also added the <b>LaxCast newsfeed, the world's first lacrosse audio broadcast</b>. Check it out! And for <b>fans, parents, alumni and other boosters</b>, we've added the ability to register with Laxstats so coaches can update you directly with important or late-breaking information.</p>
				<p class="letterText"><span class="monthText">February 2006:</span> After speaking with several coaches, we've added a feature to <b>send email blasts</b> via the blog. This will help update interested people immediately about last-minute changes to practices, games, et cetera without worrying that everyone has checked the website. Also, we've heard that some people who use <b>Macintosh Safari browsers</b> are having trouble using links in some left-hand columns. We've found and fixed the bug on several pages. Please let us know of any other bugs or funky browser issues.</p>
				<p class="letterText"><span class="monthText">January 2006:</span> Happy New Year folks! Another lacrosse season is on it's way. Thanks to all those who've checked out the Laxstats website: Since our brochure mailing, we've earned interest from both private and public school teams in <b>Virginia, Maryland, New Jersey, Pennsylvania, New York, Connecticut, Massachusetts and New Hampshire</b>. We're glad that you share our view of the value of this site. Some of you are actively looking to subscribe and we hope that more will join up - the value of Laxstats just gets better the more teams, players, stats and activity we can post. We've added a <b>women's field layout</b> to the Chalkboard and are looking at other features to make the site more responsive and useful. By the way, links to find subscription information can be found at the upper left and at the bottom of this page.</p>
				<p class="letterText"><span class="monthText">November 2005:</span> As you can see, many changes have taken place, and hopefully all for the better. Check it out! First off, we have our very own lacrosse domain, <b>laxstats.net</b>, so please reset your bookmarks. Pages from the other website should redirect you for the time being.</p>
				<p class="letterText">Second, <b>all lax game results, statistics and team management data are now entered directly via the web</b> into a new database living somewhere out in the wilds of Santa Monica, California. This is a huge improvement in accuracy, speed and flexibility. You create and manage your own lacrosse data in the <b>Manager's Office</b>, which you can find from the above menu.</p>
				<p class="letterText">Third, you will notice a bunch of cool new features, statistics and graphics. (At least <i>we</i> think they're cool.) Navigating from one season, team or player to the next is a snap, so it's no sweat to get ready for 2006. The <b>Scoreboard</b> is a quick reference for you and the media to see game results, scoring highlights, and get to box score reports. And check out the <b>Schedule</b>, a new summary page that lists all games both forward and backward in time. This is a handy thing if you want to know about upcoming games, times and locations.</p>
				<p class="letterText">Fourth, there's a bunch of new team-specific pages, which you can find under the Team Index menu above. In addition to statistics, schedules and rosters, we've designed a <b>Coach's Corner</b> where coach can maintain a blog for notices, reports and other yadda yadda. You can post comments, too! And we've added the ability to save and display <b>photos</b>, hopefully without overloading our host.</p>
				<p class="letterText">By far the coolest new feature (and the one we're the most proud) is the <b>laxstats Chalkboard&copy;</b>, a unique, animated playbook where coach can post plays and drills. It works for both men's as well as women's lacrosse. Right now, anyone can use it to <b>create and save plays</b> and generally have a good time. Soon, though, we'll make it password protected so only coach can create and save plays and only team members can see them. So enjoy it while you can! You can find the Chalkboard in the Coach's Corner under <i>Cool Stuff</i>.</p>
				<p class="letterText">If you don't think there's enough content, we've included newsfeeds from <b>College Sports TV (CSTV)</b>, <b>MLL News</b>, the <b>Baltimore Sun</b> and <b>The Lacrosse Journal</b>, currently the only RSS content providers dedicated to lacrosse. Just click on a headline to see the story.</p>
				<p class="letterText">Please check out the site and send comments and advice to <a href="mailto:webmaster@laxstats.net">webmaster@laxstats.net</a>. This site is designed for everyone: coaches, athletes, parents, fans and the media. We can't think of everything, so if you've got an idea to improve it, please let us know!</p>
			</div>
		</div>
		<!-- eof text block -->
		
		<!-- bof rss block -->
		<div class="left_column">
			<div style="text-align:center; "><a href="index.php?p=h4"><img src="images/signUp.jpg" border="0" alt="Sign Up for Laxstats"></a></div>
<?php
for($i = 0; $i < 8; $i++){
	switch($i){
		case 0:
			$href = 'http://www.laxpower.com/laxnews/laxnewsrss.php';
			break;
		case 1:
			$href = 'http://www.cstv.com/sports/m-lacros/headline-m-lacros-rss.xml';
			break;
		case 2:
			$href = 'http://www.cstv.com/sports/w-lacros/headline-w-lacros-rss.xml';
			break;
		case 3:
			$href = 'http://insidelacrosse.com/rss/men.xml';
			break;
		case 4:
			$href = 'http://laxcast.com/laxa001.xml';
			break;
		case 5:
			$href = 'http://feeds.baltimoresun.com/baltimoresun/sports/college/lacrosse/rss2';
			break;
		case 6:
			$href = 'http://www.oursportscentral.com/feeds/l15.xml';
			break;
		case 7:
			$href = 'http://www.collegelax.us/phpnews/collegelax.rss';
			break;
	}
	$reader = new rss_reader($href, 6);
}
?>
		<!-- eof rss block -->
		</div>
	</div>
	<!-- EOF BODY -->
