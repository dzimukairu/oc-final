<?php
	include("db_connection.php");

	$sender = $_GET['sender'];
	$s_id = $_GET['s_id'];
	$receiver = $_GET['receiver'];

	$getNotif = $dbconn->query("SELECT * from chat where sender = '$sender' and receiver = '$receiver' and subject_id = '$s_id' and opened = 'false' ");

	if (mysqli_num_rows($getNotif) != 0) {
		echo "Unread Message";
	} else {
		echo "hi";
	}
?>