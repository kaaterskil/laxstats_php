<?php
$sql = 'SELECT t.teamRef, t.season, tm.gender,
			IF(t.name!=\'\', CONCAT_WS( \' \', t.town, t.name), t.town) AS team_name,
			o.type, o.name, o.phone, o.phoneExt, o.phone2, o.email
		FROM officials o
		INNER JOIN teams t
			USING(teamRef)
		INNER JOIN teamsMaster tm
			USING(teamMasterRef)
		WHERE tm.teamMasterRef='.$teamMasterRef.'
			AND (o.type=1 OR o.type=6)
		ORDER BY t.season DESC';
$team = $db->db_query($sql);
$teamRef	= $team->field['teamRef'];
$season		= $team->field['season'];
$gender		= $team->field['gender'];
$team_name	= strtoupper($team->field['team_name']);

switch($page_ref){
	case 'c1':
		$page_title = ' COACH\'S CORNER';
		break;
	case 'c2':
		$page_title = ' BLOG POST';
		break;
	case 'c3':
		$page_title = ' PLAYBOOK';
		break;
	case 'c4':
		$page_title = ' PLAYBOOK';
		break;
}
?>
	<!-- BOF HEADER -->
	<div id="pageTitle">
		<div class="header"><?php echo $team_name, $page_title; ?></div>
<?php
if($page_ref == 'c4'){
?>
		<div style=" padding-right:240px; text-align:right; float:right; "><?php echo draw_image('images/iconprinter.gif'); ?> <a href="javaScript:window.print();">Print</a></div>
<?php
}
?>
		<div class="subheader">Hear all there is to say.</div>
	</div>
	<!-- EOF HEADER -->

