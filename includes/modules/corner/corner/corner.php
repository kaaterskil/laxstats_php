<?php
include('includes/modules/corner/header.php');
?>
	<!-- BOF BODY -->
	<div class="body_container">
<?php
include('includes/modules/corner/menu.php');
?>
		<!-- bof blog -->
		<div class="right_container">
<?php
if(count($blogs->result['reference']) > 0){
	$blogs->field = array();
	$blogs->move(0);
	while(!$blogs->eof){
		if(isset($blogs->field['reference'])){
			include('includes/modules/corner/blog_entry.php');
		}
		$blogs->move_next();
	}
}
?>
		</div>
		<!-- eof blog -->
	</div>
	<!-- EOF BODY -->
