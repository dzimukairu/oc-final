<?php 
	require "db_connection.php";

	$title = $_GET['fTitle'];
	$subject_id = $_GET['subject_id'];

	$delLM = $dbconn->query("DELETE from learning_materials where title = '$title' ");

	if ($delLM) { 
		header("Location: teacher_course.php?subject_id=".$subject_id);
	}
?>