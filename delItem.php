<?php 
	require "db_connection.php";

	$file_id = $_GET['file_id'];
	$subject_id = $_GET['subject_id'];

	$delLM = $dbconn->query("DELETE from learning_materials where file_id = '$file_id' ");

	if ($delLM) { 
		$delItem = $dbconn->query("DELETE from uploaded_files where file_id = '$file_id' ");

		if ($delItem) {
			header("Location: teacher_course.php?subject_id=".$subject_id);
		}
	}
?>