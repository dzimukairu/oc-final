<?php
	require "db_connection.php";

	$subject_id = $_GET['subject_id'];
	$student_id = $_GET['student_id'];

	$sql = $dbconn->query("INSERT into enrolls(student_id, subject_id, status) VALUES('$student_id', '$subject_id', 'enrolled')");

	if ($sql) {
		header("Location: add_student.php?subject_id=".$subject_id);
	}
?>