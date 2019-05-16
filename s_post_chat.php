<?php
	include("db_connection.php");

	$sender = $_POST['sender'];
	$receiver = $_POST['receiver'];
	$message = $_POST['message'];
	$subject_id = $_POST['subject_id'];

	$post_chat_query = $dbconn->query("INSERT into chat(sender, receiver, message, date_posted, subject_id, opened) VALUES('$sender', '$receiver', '$message', NOW(), '$subject_id', 'false')");

?>