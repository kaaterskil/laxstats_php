<?php
if($no_masthead == FALSE){
	$href_sitemap = set_href(FILENAME_SITEMAP);
	$href_terms = set_href(FILENAME_TERMS);
	$href_privacy = set_href(FILENAME_PRIVACY);
	$href_subscribe = set_href(FILENAME_SUBSCRIBE);
?>
<!-- BOF FOOTER -->
<div id="footer">
	<p class="subheader"><b><?php echo TEXT_WEBSITE_NAME; ?></b><br>
		<a href="<?php echo WEBSITE_CONTACT_LINK; ?>"><?php echo TEXT_FOOTER_CONTACT; ?></a> | 
		<a href="<?php echo $href_sitemap; ?>"><?php echo TEXT_FOOTER_SITEMAP; ?></a> | 
		<a href="<?php echo $href_terms; ?>"><?php echo TEXT_FOOTER_TERMS; ?></a> | 
		<a href="<?php echo $href_privacy; ?>"><?php echo TEXT_FOOTER_PRIVACY; ?></a> | 
		<a href="<?php echo $href_subscribe; ?>"><?php echo TEXT_FOOTER_SUBSCRIPTION; ?></a><br><?php echo TEXT_FOOTER_COPYRIGHT; ?></p>
</div>
<!-- EOF FOOTER -->
<?php
}
?>
</body>
</html>
