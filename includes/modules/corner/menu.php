		<!-- bof menu -->
		<div class="left_container">
<?php
include('includes/modules/corner/links.php');
if($page_ref == FILENAME_CORNER_HOME){
	include('includes/modules/corner/contacts.php');
	include('includes/modules/corner/blog_toc.php');
}elseif($page_ref == FILENAME_CORNER_BLOG){
	include('includes/modules/corner/contacts.php');
}
?>
		</div>
		<!-- eof menu -->

