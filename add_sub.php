<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}
	$username = $_SESSION['username'];

	$subject_id = $_GET['subject_id'];
	$student_id = $_GET['student_id'];

	$sql = $dbconn->query("INSERT into enrolls(student_id, subject_id, status) VALUES('$student_id', '$subject_id', 'pending')");

	if ($sql) {
		header("Location: student_home.php");
	}
?>