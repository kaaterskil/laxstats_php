<?php
require('includes/modules/teams/header.php');
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<table border="0" cellspacing="0" cellpadding="0" width="400">
<?php
for($i = 0; $i < 5; $i++){
	switch($i){
		case 0:
			$param = "position LIKE 'A%'";
			$label = 'Attacks'; break;
		case 1:
			$param = "(position LIKE 'M%' OR position='DM' OR position LIKE 'L%')";
			$label = 'Midfieldmen'; break;
		case 2:
			$param = "position='D'";
			$label = 'Defensemen'; break;
		case 3:
			$param = "position LIKE 'G%'";
			$label = 'Goalkeepers'; break;
		case 4:
			$param="(position='' OR position=NULL)";
			$label="Unknown position"; break;
	}
	$row = 0;
	$sql = 'SELECT reference, playerMasterRef, jerseyNo, LName, FName, captain, position, class, height, weight
			FROM players
			WHERE teamRef='.$teamRef.' 
				AND '.$param.'
			ORDER BY jerseyNo';
	$players = $db->db_query($sql);
	if(count($players->result) > 0){
?>
		<tr><td colspan="13" class="chartTitleL"><?php echo $label ?></td></tr>
		<tr>
			<td width="1" class="divider4"></td>
			<td width="33" class="chartHeaderC">##</td>
			<td width="1" class="divider"></td>
			<td width="182" class="chartHeaderL">Name</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Pos</td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartHeaderC">Class</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Ht</td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartHeaderC">Wt</td>
			<td width="1" class="divider4"></td>
		</tr>
<?php
	}
	while(!$players->eof){
		//get player data
		$playerRef = $players->field['reference'];
		$playerMasterRef = $players->field["playerMasterRef"];
		$jerseyNo = $players->field["jerseyNo"];
		$LName = $players->field["LName"];
		$FName = $players->field["FName"];
		$captain = $players->field["captain"];
		$position = $players->field["position"];
		$class = $players->field["class"];
		$height = $players->field["height"];
		$weight = $players->field["weight"];
		//process data
		$params = '&pmr='.$playerMasterRef;
		$href = set_href(FILENAME_PLAYER_SUMMARY, $params);
		$player_name = set_player_name($FName, $LName);
		$weight_str = ($weight > 0 ? $weight : '');
		$captain = ($captain == 'T' ? ' (captain)' : '');
		$background = set_background($row);
?>
		<tr class="<?php echo $background ?>">
			<td width="1" class="divider"></td>
			<td width="33"class="chartC"><?php echo $jerseyNo; ?></td>
			<td width="1" class="divider"></td>
			<td width="182"class="chartL"><a href="<?php echo $href; ?>"><?php echo $player_name; ?></a><?php echo $captain; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><?php echo $position; ?></td>
			<td width="1" class="divider"></td>
			<td width="43" class="chartC"><?php echo $class; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><?php echo $height; ?></td>
			<td width="1" class="divider"></td>
			<td width="33" class="chartC"><?php echo $weight_str; ?></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		$row++;
		$players->move_next();
	}
?>
		<tr><td height="10" colspan="13" class="divider2"></td></tr>
<?php
}
?>
		</table>
	</div>
	<!-- EOF BODY -->
