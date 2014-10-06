			<!-- bof contacts -->
			<div class="menu_category">Contact
<?php
$keys = array_keys($team->result['teamRef'], $teamRef);
if(isset($keys) && count($keys) > 0){
	for($i = 0; $i < count($keys); $i++){
		$e = $keys[$i];
		$staff_type = $team->result['type'][$e];
		$staff_name = $team->result['name'][$e];
		$staff_phone = $team->result['phone'][$e];
		$staff_extension = $team->result['phoneExt'][$e];
		$staff_phone2 = $team->result['phone2'][$e];
		$staff_email = $team->result['email'][$e];
		
		//process data
		$staff_phone = ($staff_extension != '' ? $staff_phone.' x'.$staff_extension : $staff_phone);
		$staff_phone = ($staff_phone == '' && $staff_phone2 != '' ? $staff_phone2 : $staff_phone);
		switch($staff_type){
			case 1:
				$title = 'Head Coach';
				break;
			case 6:
				$title = 'Booster Coordinator';
				break;
		}
		if($staff_name != ''){
?>
				<div class="menu_list" style="padding-top:10px; "><?php echo $staff_name.', '.$title; ?></div>
<?php
		}
		if($staff_phone != ''){
?>
				<div class="menu_list"><?php echo $staff_phone; ?></div>
<?php
		}
		if($staff_email != ''){
?>
				<div class="menu_list"><a href="mailto:<?php echo $staff_email; ?>"><u><?php echo $staff_email; ?></u></a></div>
<?php
		}
	}
}
?>
			</div>
			<!-- eof contacts -->
