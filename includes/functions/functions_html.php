<?php
/*----------------------------------------------------------------------
CREATE HTML TEXT INPUT FORM ELEMENT
----------------------------------------------------------------------*/
function draw_text_input_element($name, $class='', $size, $maxlength, $value, $onChange='', $params = ''){
	$r='<input name="'.$name.'" class="'.$class.'" type="text" size="'.$size.'" maxlength="'.$maxlength.'" value="'.$value.'" onChange="'.$onChange.'" '.$params.'>';
	return $r;
}
function draw_text_input_element2($name, $value, $params=''){
	$r='<input name="'.$name.'" type="text" value="'.$value.'" '.$params.'>';
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML PASSWORD INPUT FORM ELEMENT
----------------------------------------------------------------------*/
function draw_password_input_element($name, $class='', $size, $maxlength, $value = '', $onChange=''){
	$r='<input name="'.$name.'" class="'.$class.'" type="password" size="'.$size.'" maxlength="'.$maxlength.'" value="'.$value.'" onChange="'.$onChange.'">';
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML TEXTAREA INPUT FORM ELEMENT
----------------------------------------------------------------------*/
function draw_textarea_element($name, $class='', $cols = '80%', $rows, $value, $onChange=''){
	$r='<textarea name="'.$name.'" class="'.$class.'" cols="'.$cols.'" rows="'.$rows.'" wrap="soft" onChange="'.$onChange.'">'.$value.'</textarea>';
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML RADIO BUTTON FORM ELEMENT
----------------------------------------------------------------------*/
function draw_radio_input_element($name, $class, $label, $value, $selected_value, $params = ''){
	$r = '<input name="'.$name.'" class="'.$class.'" type="radio" value="'.$value.'"';
	if($params != ''){
		$r .= ' '.$params;
	}
	if($value == $selected_value){
		$r .= ' checked="checked"';
	}
	$r .= '>'.$label;
	return $r;
}
function draw_radio_input_element2($name, $label, $param){
	$r = '<input name="'.$name.'" type="radio" '.$param.'>'.$label;
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML CHECK BOX FORM ELEMENT
----------------------------------------------------------------------*/
function draw_checkbox_input_element($name, $class, $label, $value, $selected_value = '', $onChange = ''){
	$r = '<input type="checkbox" name="'.$name.'" class="'.$class.'" value="'.$value.'"';
	if($onChange != ''){
		$r .= ' onChange="'.$onChange.'"';
	}
	if($value == $selected_value){
		$r .= ' checked="checked"';
	}
	$r .= '>'.$label;
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML SELECT FORM ELEMENT
----------------------------------------------------------------------*/
function draw_select_element($name, $option_array, $selected_value = '', $onChange = '', $params = ''){
	$r = '<select name="'.$name.'" onChange="'.$onChange.'" '.$params.'>';
	for($i = 0; $i < count($option_array); $i++){
		$value = $option_array[$i]['value'];
		$label = $option_array[$i]['label'];
		$r .= "\n\t\t\t".'<option value="'.$value.'"';
		if($value == $selected_value){
			$r .= ' selected="selected"';
		}
		$r .= '>'.$label.'</option>';
	}
	$r .= "\n\t\t".'</select>';
	return $r;
}
function draw_select_element2($name, $option_array, $selected_value = '', $onChange = ''){
	$r = '<select name="'.$name.'" onChange="'.$onChange.'">'."\n";
	for($i=0; $i < count($option_array); $i++){
		$value = $option_array[$i]['value'];
		$label = $option_array[$i]['label'];
		$r .= "\t\t\t".'<option value="'.$value.'"';
		if($label == $selected_value){
			$r .= ' selected="selected"';
		}
		$r .= '>'.$label."</option>\n";
	}
	$r .= "\t\t</select>";
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML SELECT FORM ELEMENT WITH SINGLE-LEVEL GROUPING
-first version uses value to match to selected value
-second version uses label to match to selected value
-third version does NOT duplicate group element in option list
----------------------------------------------------------------------*/
function draw_select_element_group($name, $option_array, $selected_value, $onChange = '', $type = ''){
	if($type != ''){
		$r = '<select multiple name="'.$name.'" onChange="'.$onChange.'">'."\n";
	}else{
		$r = '<select name="'.$name.'" onChange="'.$onChange.'">'."\n";
	}
	$t = '';
	for($i=0; $i < count($option_array); $i++){
		$value = $option_array[$i]['value'];
		$label = $option_array[$i]['label'];
		$group = $option_array[$i]['group'];
		if($group != $t){
			if($t != ''){
				$r .= "\t\t\t</optgroup>\n";
			}
			$r .= "\t\t\t".'<optgroup label="'.$group.'">'."\n";
			$t = $group;
		}
		$r .= "\t\t\t\t".'<option value="'.$value.'"';
		if($value == $selected_value){
			$r .= ' selected="selected"';
		}
		$r .= '>'.$label."</option>\n";
	}
	$r .= "\t\t\t</optgroup>\n";
	$r .= "\t\t</select>\n";
	return $r;
}

function draw_select_element_group2($name, $option_array, $selected_value = 0, $onChange = ''){
	$t = '';
	$r = '<select name="'.$name.'" onChange="'.$onChange.'">'."\n";
	for($i=0; $i < count($option_array); $i++){
		$element = $option_array[$i];
		$value = $element['value'];
		$label = $element['label'];
		$group = $element['group'];
		
		if($group != $t){
			if($t != ''){
				$r .= "\t\t\t</optgroup>\n";
			}
			$r .= "\t\t\t".'<optgroup label="'.$group.'">'."\n";
			$t = $group;
		}
		$r .= "\t\t\t\t".'<option value="'.$value.'"';
		if($label == $selected_value){
			$r .= ' selected';
		}
		$r .= '>'.$label."</option>\n";
	}
	$r .= "\t\t\t</optgroup>\n";
	$r .= "\t\t</select>\n";
	return $r;
}

function draw_select_element_group3($name, $option_array, $selected_value = 0, $onChange = '', $type = ''){
	if($type == ''){
		$r = '<select name="'.$name.'" onChange="'.$onChange.'">'."\n";
	}else{
		$r = '<select multiple name="'.$name.'" onChange="'.$onChange.'">'."\n";
	}
	$t = '';
	for($i=0; $i < count($option_array['label']); $i++){
		$value = $option_array['value'][$i];
		$label = $option_array['label'][$i];
		$group = $option_array['group'][$i];
		if($group != $t){
			if($t != ''){
				$r .= "\t\t\t</optgroup>\n";
			}
			$r .= "\t\t\t".'<optgroup label="'.$group.'">'."\n";
			$t = $group;
		}else{
			$r .= "\t\t\t\t".'<option value="'.$value.'"';
			if($value == $selected_value){
				$r .= ' selected="selected"';
			}
			$r .= '>'.$label."</option>\n";
		}
	}
	$r .= "\t\t\t</optgroup>\n";
	$r .= "\t\t</select>\n";
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML FILE UPLOAD INPUT FORM ELEMENT
----------------------------------------------------------------------*/
function draw_upload_input_element($name, $size, $maxlength,  $id = ''){
	$r = '<input name="'.$name.'" type="file"';
	if($id != ''){
		$r .= ' id="'.$id.'" ';
	}
	$r .= ' size="'.$size.'" maxlength="'.$maxlength.'">';
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML HIDDEN FORM ELEMENT
----------------------------------------------------------------------*/
function draw_hidden_input_element($name, $value){
	$r = '<input name="'.$name.'" type="hidden" value="'.$value.'">';
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML SUBMIT BUTTON FORM ELEMENT
----------------------------------------------------------------------*/
function draw_submit_button($name, $value, $class = ''){
	$string_test = is_string($value);
	$r = '<input name="'.$name.'" type="submit" class="'.$class.'" value="'.$value.'">';
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML RESET BUTTON FORM ELEMENT
----------------------------------------------------------------------*/
function draw_reset_button($name, $value, $class = ''){
	$string_test = is_string($value);
	$r = '<input name="'.$name.'" type="reset" class="'.$class.'" value="'.$value.'">';
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML BUTTON FORM ELEMENT
----------------------------------------------------------------------*/
function draw_button($name, $value, $param = '', $class = ''){
	$r = '<input name="'.$name.'" class="'.$class.'" type="button" value="'.$value.'" '.$param.'>';
	return $r;
}

/*----------------------------------------------------------------------
CREATE HTML IMAGE
----------------------------------------------------------------------*/
function draw_image($src, $width = '', $height = '', $alt = '', $border = 0){
	$r = '<img src="'.$src.'" border="'.$border.'" height="'.$height.'" width="'.$width.'" alt="'.$alt.'">';
	return $r;
}
function draw_image2($src, $attr, $alt = ''){
	$r = '<img src="'.$src.'" border="0" '.$attr.' alt="'.$alt.'">';
	return $r;
}

/*----------------------------------------------------------------------
CREATE DEPTH CHART HTML	 - TEAM
----------------------------------------------------------------------*/
function draw_depth_string($player_array, $class_td = '', $class_div = ''){
	$r = "\n\t\t\t".'<td class="'.$class_td.'">';
	if(count($player_array) > 0){
		for($i = 0; $i < count($player_array); $i++){
			$playerMasterRef = $player_array[$i]['playerMasterRef'];
			$jerseyNo = $player_array[$i]['jerseyNo'];
			$player_name = $player_array[$i]['player_name'];
			$year = $player_array[$i]['class'];
			$href = $player_array[$i]['href'];
			
			$id = $playerMasterRef.'S';
			$r .= "\n\t\t\t\t".'<div class="'.$class_div.'">'.$jerseyNo.' <a href="'.$href.'" onMouseOver="show_stat(\''.$id.'\');" onMouseOut="hide_stat(\''.$id.'\');">'.$player_name.'</a> '.$year.'</div>';
		}
		$r .= "\n\t\t\t";
	}
	$r .= '</td>'."\n\t\t\t".'<td width="1" class="divider"></td>';
	echo $r;
}

/*----------------------------------------------------------------------
DRAW OFFENSIVE STAT BOX
----------------------------------------------------------------------*/
function draw_offensive_stat_box($result_array){
	$avg_goals = $result_array['avg_goals'];
	$goal_error = $result_array['goal_error'];
	$goal_range_low = $result_array['goal_range_low'];
	$goal_range_high = $result_array['goal_range_high'];
	$avg_shots = $result_array['avg_shots'];
	$shot_error = $result_array['shot_error'];
	$shot_range_low = $result_array['shot_range_low'];
	$shot_range_high = $result_array['shot_range_high'];
	$shot_pct = $result_array['shot_pct'];
	$games = $result_array['games'];
	$playerMasterRef = $result_array['playerMasterRef'];
	$id = $playerMasterRef.'S';
?>
		<div id="<?php echo $id; ?>" class="hiddenStat">
			<table border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="5" class="chartC">CAREER STATS</td></tr>
			<tr>
				<td class="chartL"></td>
				<td width="1" class="divider"></td>
				<td class="chartC">Mean&sup1;</td>
				<td width="1" class="divider"></td>
				<td class="chartC">Range</td>
			</tr>
			<tr>
				<td class="chartL">Goals per game</td>
				<td width="1" class="divider"></td>
				<td class="chartC"><?php echo $avg_goals.' &plusmn; '.$goal_error; ?></td>
				<td width="1" class="divider"></td>
				<td class="chartC"><?php echo $goal_range_low.' - '.$goal_range_high; ?></td>
			</tr>
			<tr>
				<td class="chartL">Shots per game</td>
				<td width="1" class="divider"></td>
				<td class="chartC"><?php echo $avg_shots.' &plusmn; '.$shot_error; ?></td>
				<td width="1" class="divider"></td>
				<td class="chartC"><?php echo $shot_range_low.' - '.$shot_range_high; ?></td>
			</tr>
			<tr>
				<td class="chartL">Shot pct</td>
				<td width="1" class="divider"></td>
				<td colspan="3" class="chartL"><?php echo $shot_pct; ?></td>
			</tr>
			<tr>
				<td class="chartL">Games played</td>
				<td width="1" class="divider"></td>
				<td colspan="3" class="chartL"><?php echo $games; ?></td>
			</tr>
			<tr><td colspan="5" class="chartL">&sup1;plus or minus margin of error</td></tr>
			</table>
		</div>
<?php
}

/*----------------------------------------------------------------------
DRAW DEFENSIVE STAT BOX
----------------------------------------------------------------------*/
function draw_defensive_stat_box($result_array){
	$avg_gb = $result_array['avg_gb'];
	$games = $result_array['games'];
	$playerMasterRef = $result_array['playerMasterRef'];
	$id = $playerMasterRef.'S';
?>
		<div id="<?php echo $id; ?>" class="hiddenStat">
			<table border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="3" class="chartC">CAREER STATS</td></tr>
			<tr>
				<td></td>
				<td width="1" class="divider"></td>
				<td class="chartC">Mean</td>
			</tr>
			<tr>
				<td class="chartL">Ground balls</td>
				<td width="1" class="divider"></td>
				<td class="chartC"><?php echo $avg_gb; ?></td>
			</tr>
			<tr>
				<td class="chartL">Games played</td>
				<td width="1" class="divider"></td>
				<td class="chartC"><?php echo $games; ?></td>
			</tr>
			</table>
		</div>
<?php
}

/*----------------------------------------------------------------------
DRAW GOALIE STAT BOX
----------------------------------------------------------------------*/
function draw_goalie_stat_box($result_array){
	$avg_saves = $result_array['avg_saves'];
	$saves_error = $result_array['saves_error'];
	$avg_ga = $result_array['avg_ga'];
	$ga_error = $result_array['ga_error'];
	$games = $result_array['games'];
	$playerMasterRef = $result_array['playerMasterRef'];
	$id = $playerMasterRef.'S';
?>
		<div id="<?php echo $id; ?>" class="hiddenStat">
			<table border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="3" class="chartC">CAREER STATS</td></tr>
			<tr>
				<td></td>
				<td width="1" class="divider"></td>
				<td class="chartC">Mean</td>
			</tr>
			<tr>
				<td class="chartL">Saves</td>
				<td width="1" class="divider"></td>
				<td class="chartC"><?php echo $avg_saves.' &plusmn; '.$saves_error; ?></td>
			</tr>
			<tr>
				<td class="chartL">Goals allowed</td>
				<td width="1" class="divider"></td>
				<td class="chartC"><?php echo $avg_ga.' &plusmn; '.$ga_error; ?></td>
			</tr>
			<tr>
				<td class="chartL">Games played</td>
				<td width="1" class="divider"></td>
				<td class="chartC"><?php echo $games; ?></td>
			</tr>
			</table>
		</div>
<?php
}
?>