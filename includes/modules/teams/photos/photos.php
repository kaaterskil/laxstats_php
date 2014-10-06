<?php
require('includes/modules/teams/header.php');
?>
	<!-- BOF BODY -->
	<div class="body_container">
		<!-- bof photo list block -->
		<table border="0" cellpadding="0" cellspacing="0" width="400">
		<tr><td colspan="3" class="chartTitleL">IMAGE LIST</td></tr>
<?php
for($i = 0; $i < 2; $i++){
	if($i == 0){
		//loop through non-game photos
		$sql = 'SELECT DISTINCT photoDate
				FROM imageLibrary
 				WHERE teamRef = "' . $teamRef . '"
					AND (gameRef = 0 OR gameRef = NULL)
				ORDER BY photoDate DESC';
	}else{
		$sql = 'SELECT DISTINCT il.gameRef, il.photoDate, t.town AS opponent
				FROM teams t
				INNER JOIN games g
					ON t.teamRef = g.usTeamRef OR t.teamRef = g.themTeamRef
				INNER JOIN imageLibrary il
					USING (gameRef)
				WHERE il.teamRef = "' . $teamRef . '"
					AND il.gameRef > 0
					AND t.teamRef != "' . $teamRef . '"
				ORDER BY il.photoDate DESC';
	}
	$listing = $db->db_query($sql);
	while(!$listing->eof){
		$photoDate = $listing->field['photoDate'];
		$gameRef = $listing->field['gameRef'];
		$opponent = $listing->field['opponent'];
		
		$date = date('m/d/y',strtotime($photoDate));
		if($gameRef > 0){
			$anchor = $date.' game against '.$opponent;
			$params = '&tmr='.$teamMasterRef.'&tr='.$teamRef.'&s='.$season.'&se='.$gameRef;
		}else{
			$anchor = $date;
			$params = '&tmr='.$teamMasterRef.'&tr='.$teamRef.'&s='.$season.'&se='.$date;
		}
		$href = set_href(FILENAME_TEAM_PHOTOS, $params);
?>
		<tr>
			<td width="1" class="divider"></td>
			<td class="chartL"><a href="<?php echo $href; ?>"><?php echo $anchor; ?></a></td>
			<td width="1" class="divider"></td>
		</tr>
<?php
		$listing->move_next();
	}
}
?>
		<tr><td colspan="3" height="20" class="divider2"></td></tr>
		</table>
		<!-- eof photo list block -->
		
		<!-- bof tumbnail block -->
		<table border="0" cellpadding="0" cellspacing="0" width="700">
<?php
if($selection != 'A'){
	$table_cell = 0;
	$row = 0;
	$length = strlen($selection);
	if($length == 10){
		//for non-game photos
		$sql = 'SELECT imageRef, photoDate, photographer, title, note
				FROM imageLibrary
				WHERE teamRef = "' . $teamRef . '"
					AND photoDate = "' . $selection . '"
				ORDER BY imageRef';
	}else{
		//for game photos
		$sql = 'SELECT il.imageRef, il.photoDate, il.photographer, il.title, il.note,
					g.gameRef, t.town AS opponent
				FROM teams t
				INNER JOIN games g
					ON t.teamRef = g.usTeamRef OR t.teamRef = g.themTeamRef
				INNER JOIN imageLibrary il
					USING (gameRef)
				WHERE il.teamRef = "' . $teamRef . '"
					AND il.gameRef = "'.$selection . '"
					AND t.teamRef != "' . $teamRef . '"
				ORDER BY imageRef';
	}
	$thumbnails = $db->db_query($sql);
	while(!$thumbnails->eof){
		$imageRef		= $thumbnails->field['imageRef'];
		$photoDate		= $thumbnails->field['photoDate'];
		$photographer	= $thumbnails->field['photographer'];
		$title			= $thumbnails->field['title'];
		$note			= $thumbnails->field['note'];
		$gameRef		= $thumbnails->field['gameRef'];
		$opponent		= $thumbnails->field['opponent'];
		//print header
		if($row == 0){
			$date = date('m/d/y', strtotime($photoDate));
			if($gameRef > 0){
				$anchor = $date.' game against'.$opponent;
			}else{
				$anchor = $date;
			}
?>
		<tr><td colspan="5" class="chartTitleL"> <?php echo $anchor; ?></td></tr>
<?php
		}
		//start row
		if($table_cell == 0){
?>
		<tr>
<?php
		}
		//print thumbnail
		$table_cell++;
?>
			<td valign="top" align="center" width="140" class="chartL"><a href="#" onClick="openWindow(<?php echo $imageRef; ?>);"><img src="thumbnail.php?id=<?php echo $imageRef; ?>" border="1" alt="<?php //echo $title; ?>"></a><br><?php echo $title; ?><br><?php echo $note; ?></td>
<?php
		//end row
		if($table_cell == 5){
			$table_cell = 0;
?>
		</tr>
<?php
		}
		$row++;
		$thumbnails->move_next();
	}
	while($table_cell > 0 && $table_cell < 5){
		$table_cell++;
?>
			<td width="140" class="chartL"></td>
<?php
		if($table_cell == 5){
?>
		</tr>
<?php
		}
	}
}
?>
		</table>
		<!-- eof thumbnail block -->
	</div>
	<!-- EOF BODY -->
