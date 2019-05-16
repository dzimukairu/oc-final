<?php
	require "db_connection.php";

	$subject_id = $_GET['subject_id'];
	$student_id = $_GET['student_id'];

	$sql = $dbconn->query("UPDATE enrolls set status = 'enrolled' where student_id = '$student_id' and subject_id = '$subject_id' ");

	if ($sql) {
		header("Location: teacher_course.php?subject_id=".$subject_id);
	}
?>