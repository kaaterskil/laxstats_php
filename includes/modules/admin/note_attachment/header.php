<?php
//test privileges
test_privileges(1);
define('PAGE_TITLE', 'Note Attachment');

$sql = 'SELECT attachment
		FROM contactNotes
		WHERE reference='.$recordID;
$note = $db->db_query($sql);
$string = $note->field['attachment'];
?>