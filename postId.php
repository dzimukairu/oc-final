<?php
	require "db_connection.php";

	$student_id = $_POST['sid'];
	$quiz_id = $_POST['qid'];
	
	$insertAnswer = $dbconn->query("INSERT into answer_quiz(date_posted, total_grade, student_id, quiz_id) values(NOW(), -1, '$student_id', '$quiz_id')" );

	$answer_id = $dbconn->insert_id;

	echo $answer_id;
?>