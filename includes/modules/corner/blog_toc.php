			<!-- bof toc -->
			<div class="menu_category">Things I Wrote
<?php
if(count($blogs->result['reference']) > 0){
	while(!$blogs->eof){
		$blog_ref = $blogs->field['reference'];
		$title = $blogs->field['title'];
?>
				<div class="menu_list"><a href="#<?php echo $blog_ref; ?>"><?php echo $title; ?></a></div>
<?php
		$blogs->move_next();
	}
}
?>
			</div>
			<!-- eof toc -->
