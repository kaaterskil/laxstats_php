<?php
include(FILENAME_ADMIN_PAGE_HEADER);
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<!-- bof display -->
		<div class="left_container">
			<!-- bof photo list -->
			<table border="0" cellspacing="0" cellpadding="0" width="340">
			<tr><td colspan="3" class="chartTitleC">IMAGE LIST</td></tr>
<?php
if(isset($photo_list)){
	$row = 0;
	while(!$photo_list->eof){
		//get data
		$gameRef = $photo_list->field['gameRef'];
		$opponent = $photo_list->field['opponent'];
		$photo_date = $photo_list->field['photoDate'];
		//process data
		$date = date('m/d/Y', strtotime($photo_date));
		$game_string = ($gameRef > 0 ? ' game against '.$opponent : '');
		$background = set_background($row);
		//set links
		if($gameRef > 0){
			$params = get_all_get_params(array('p', 'gr', 'se', 'a')).'&gr='.$gameRef;
		}else{
			$params = get_all_get_params(array('p', 'gr', 'se', 'a')).'&se='.$photo_date;
		}
		$href = set_href(FILENAME_ADMIN_PHOTOS, $params); 
?>
			<tr class="<?php echo $background; ?>">
				<td width="1" class="divider"></td>
				<td class="chartL"><a href="<?php echo $href; ?>"><?php echo $date; ?></a><?php echo $game_string; ?></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
		$row++;
		$photo_list->move_next();
	}
}
?>
			<tr><td colspan="3" height="20" class="divider2"></td></tr>
			</table>
			<!-- eof photo list -->
			
			<!-- bof thumbnails -->
			<table border="0" cellspacing="0" cellpadding="0" width="340">
			<tr><td colspan="7" class="chartTitleC">IMAGES</td></tr>
<?php
if(isset($photos)){
	while(!$photos->eof){
		//get data
		$recordID = $photos->field['imageRef'];
		$title = $photos->field['title'];
		$size = number_format($photos->field['size'] / 1024, 1);
		$note = $photos->field['note'];
		$photographer = $photos->field['photographer'];
		$game_date = $photos->field['date'];
		$opponent = $photos->field['opponent'];
		//set links
		$params = get_all_get_params(array('p', 'gr', 'se', 'a')).'&se='.$recordID.'&a=d';
		$href_delete = set_href(FILENAME_ADMIN_PHOTOS, $params);
?>
			<tr>
				<td width="1" class="divider"></td>
				<td width="27" class="chartC" style=" vertical-align:top;"><a href="#" onMouseUp="confirm_delete('<?php echo $href_delete; ?>');"><?php echo draw_image('images/b_drop.png', 10, 10); ?></a></td>
				<td width="1" class="divider"></td>
				<td>
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td width="40" height="10" class="chartL">Title:</td>
						<td class="chartL"><?php echo $title; ?></td>
					</tr>
					<tr valign="top">
						<td width="40" height="10" class="chartL"></td>
						<td class="chartL"><?php echo $photographer; ?></td>
					</tr>
					<tr>
						<td width="40" height="10" class="chartL">Size:</td>
						<td class="chartL"><?php echo $size; ?> KB</td>
					</tr>
					<tr valign="top">
						<td width="40" height="25" class="chartL">Note:</td>
						<td class="chartL"><?php echo $note; ?></td>
					</tr>
					</table>
				</td>
				<td width="1" class="divider"></td>
				<td width="77" class="chartC"><a href="#" onClick=""><img style="border:1px solid #006600;" src="" border="0"></a></td>
				<td width="1" class="divider"></td>
			</tr>
<?php
		$photos->move_next();
	}
}
?>
			</table>
			<!-- eof thumbnails -->
		</div>
		<!-- eof display -->
		
		<!-- bof data entry -->
		<div class="right_container">
			<form name="photo" method="post" enctype="multipart/form-data" onSubmit="return validate_photo(this);" action="<?php echo $href_action; ?>">
			<table border="0" cellpadding="0" cellspacing="0" width="340">
			<tr>
				<td colspan="2" class="chartTitleC">
					<span class="information"><a href="#" onClick="openInfo('photos');"><?php echo draw_image('images/b_info1.png'); ?></a></span>
					<span>IMAGE UPLOAD</span>
				</td>
			</tr>
			<tr>
				<td class="form_label2">Title:<span class="required">*</span></td>
				<td class="form_text2"><?php echo draw_text_input_element('title', '', 30, 25, $edit_title, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Photo Date:<span class="required">*</span></td>
				<td class="form_text2"><?php echo draw_text_input_element('photo_date', '', 13, 10, $edit_date, 'validate_date(this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Game:</td>
				<td class="form_text2"><?php echo draw_game_select('gameRef', $teamRef, $gameRef, 'set_date(this.options[this.selectedIndex].value);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Photographer:</td>
				<td class="form_text2"><?php echo draw_text_input_element('photographer', '', 25, 20, $edit_photographer, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Note:</td>
				<td class="form_text2"><?php echo draw_textarea_element('notes', '', 30, 3, $edit_notes, 'validate_string(\'text\', this);'); ?></td>
			</tr>
			<tr>
				<td class="form_label2">Image:</td>
				<td class="form_text2"><?php echo draw_upload_input_element('photo', 33, 120,  'photo'); ?></td>
			</tr>
			<tr>
				<td class="required">*Required</td>
				<td class="buttonText"><?php echo draw_hidden_input_element('recordID', $recordID), draw_reset_button('reset', 'Reset').'&nbsp;&nbsp;'.draw_submit_button('save', 'Save'); ?></td>
			</tr>
			<tr><td colspan="2" class="error"><?php echo $message; ?></td></tr>
			</table>
			</form>
		</div>
		<!-- eof data entry -->
	</div>
	<!-- EOF BODY -->
