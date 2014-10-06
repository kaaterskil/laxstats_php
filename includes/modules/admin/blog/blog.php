<?php
include(FILENAME_ADMIN_PAGE_HEADER);
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="500">
		<tr><td colspan="11" class="buttonText"><?php echo draw_button('new', 'Create Letter', 'onClick="open_blog(\''.$href_new.'\');"'); ?></td></tr>
		<tr>
			<td colspan="11" class="chartTitleC">
				<span class="information"><a href="#" onClick="openInfo('blog1');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
				<span>BLOG POSTINGS</span>
			</td>
		</tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="28" class="chartHeaderC"></td>
			<td width="1" class="divider"></td>
			<td width="73" class="chartHeaderC">Date</td>
			<td width="1" class="divider"></td>
			<td width="49" class="chartHeaderL">Type</td>
			<td width="1" class="divider"></td>
			<td width="242" class="chartHeaderL">Title</td>
			<td width="1" class="divider"></td>
			<td width="73" class="chartHeaderC">Modified</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
if(isset($blogs)){
	$row = 0;
	while(!$blogs->eof){
		//get data
		$blog_ref = $blogs->field['reference'];
		$type = $blogs->field['type'];
		$date = $blogs->field['date'];
		$title = $blogs->field['title'];
		$modified_date = $blogs->field['modified'];
		//process data
		$date = date('m/d/Y', strtotime($date));
		$modified_date = date('m/d/Y', strtotime($modified_date));
		switch($type){
			case 'E':
				$type = 'Email';
				break;
			case 'B':
				$type = 'Blog';
				break;
		}
		$background = set_background($row);
		//set links
		$params = get_all_get_params(array('p', 'br', 'a')).'&br='.$blog_ref.'&a=d';
		$href_delete = set_href(FILENAME_ADMIN_BLOG, $params);
		$params = get_all_get_params(array('p', 'br', 'a')).'&br='.$blog_ref.'&nmh=1';
		$href_edit = set_href(FILENAME_ADMIN_BLOG_NEW, $params);
?>
		<tr class="<?php echo $background; ?>">
			<td width="1" class="divider"></td>
			<td width="28" class="chartC">
				<a href="#" onClick="confirm_delete('<?php echo $href_delete; ?>')"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a>
				<a href="#" onClick="open_blog('<?php echo $href_edit; ?>');"><?php echo draw_image('images/b_edit.png', 10, 10); ?></a>
			</td>
			<td width="1" class="divider"></td>
			<td width="73" class="chartC"><?php echo $date; ?></td>
			<td width="1" class="divider"></td>
			<td width="49" class="chartL"><?php echo $type; ?></td>
			<td width="1" class="divider"></td>
			<td width="242" class="chartL"><?php echo $title; ?></td>
			<td width="1" class="divider"></td>
			<td width="73" class="chartC"><?php echo $modified_date; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		$row++;
		$blogs->move_next();
	}
}else{
?>
		<tr>
			<td width="1" class="divider"></td>
			<td colspan="9" class="chartL3">No letters have been created yet.</td>
			<td width="1" class="divider"></td>
		</tr>
<?php
}
?>
		</table>
	</div>
	<!-- EOF BODY -->
