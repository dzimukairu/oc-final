<?php
	require "db_connection.php";

	$a_id = $_GET['aid'];

	// echo $answer_id;

	$getInfo = $dbconn->query("SELECT * from answer_quiz where answer_id = '$a_id' ");
	$getAns = mysqli_fetch_array($getInfo);
	$quiz_id = $getAns['quiz_id'];
	$student_id = $getAns['student_id'];

	$total_grade = 0;

	$getIden_query = $dbconn->query("SELECT * from identification_quiz where quiz_id = '$quiz_id' ");
	$idenSize = mysqli_num_rows($getIden_query);
	if ($idenSize != 0) {
		for ($i = 1; $i <= $idenSize; $i++) {
			$getQIden = $dbconn->query("SELECT * from identification_quiz where quiz_id = '$quiz_id' and question_number = '$i' ");
			$q_iden = mysqli_fetch_array($getQIden);
			$q_iden_answer = $q_iden['answer'];
			$q_iden_score = $q_iden['grade'];

			$getAIden = $dbconn->query("SELECT * from answer_iden_quiz where answer_id = '$a_id' and question_number = '$i' ");
			$a_iden = mysqli_fetch_array($getAIden);
			$a_iden_answer = $a_iden['answer'];

			if (strcasecmp($q_iden_answer, $a_iden_answer) == 0) {
				// echo $q_iden_answer." - ".$a_iden_answer." -> Correct<br>";
				$updateScore = $dbconn->query("UPDATE answer_iden_quiz set grade = '$q_iden_score' where answer_id = '$a_id' and question_number = '$i' ");
				$total_grade += $q_iden_score;
			} else {
				// echo $q_iden_answer." - ".$a_iden_answer." -> Wrong<br>";
				$updateScore = $dbconn->query("UPDATE answer_iden_quiz set grade = 0 where answer_id = '$a_id' and question_number = '$i' ");
			}
		}
		// echo $total_grade;
	}

	$getMC_query = $dbconn->query("SELECT * from multiplechoice_quiz where quiz_id = '$quiz_id' ");
	$mcSize = mysqli_num_rows($getMC_query);
	if ($mcSize != 0) {
		for ($i = 1; $i <= $mcSize; $i++) {
			$getQMc = $dbconn->query("SELECT * from multiplechoice_quiz where quiz_id = '$quiz_id' and question_number = '$i' ");
			$q_mc = mysqli_fetch_array($getQMc);
			$q_mc_answer = $q_mc['answer'];
			$q_mc_score = $q_mc['grade'];

			$getAMc = $dbconn->query("SELECT * from answer_mc_quiz where answer_id = '$a_id' and question_number = '$i' ");
			$a_mc = mysqli_fetch_array($getAMc);
			$a_mc_answer = $a_mc['answer'];

			if (strcasecmp($q_mc_answer, $a_mc_answer) == 0) {
				// echo "<br>";
				// echo $q_mc_answer." - ".$a_mc_answer." -> Correct<br>";
				$updateScore = $dbconn->query("UPDATE answer_mc_quiz set grade = '$q_mc_score' where answer_id = '$a_id' and question_number = '$i' ");
				$total_grade += $q_mc_score;
			} else {
				// echo "<br>";
				// echo $q_mc_answer." - ".$a_mc_answer." -> Wrong<br>";
				$updateScore = $dbconn->query("UPDATE answer_mc_quiz set grade = 0 where answer_id = '$a_id' and question_number = '$i' ");
			}
		}
		// echo $total_grade;
	}

	$getMa_query = $dbconn->query("SELECT * from multipleanswer_quiz where quiz_id = '$quiz_id' ");
	$maSize = mysqli_num_rows($getMa_query);
	if ($maSize != 0) {
		for ($i = 1; $i <= $maSize; $i++) {
			$getScore_query = $dbconn->query("SELECT * from multipleanswer_quiz where quiz_id = '$quiz_id'and question_number = '$i' ");
			$ma = mysqli_fetch_array($getScore_query);
			$q_ma_score = $ma['grade'];

			$getQMa = $dbconn->query("SELECT * from multipleanswer_answers where quiz_id = '$quiz_id' and question_number = '$i' ");
			$q_answers = array();
			$q_ma_size = mysqli_num_rows($getQMa);

			if ($q_ma_size != 0) {
				while ($q_ma = mysqli_fetch_array($getQMa)){
					$q_answers[] = $q_ma['answer'];
				}
			}
			// echo "<br>";
			// print_r($q_answers);

			$getAMa = $dbconn->query("SELECT * from answer_ma_quiz where answer_id = '$a_id' and question_number = '$i' ");
			$a_answers = array();
			$a_ma_size = mysqli_num_rows($getAMa);

			if($a_ma_size != 0) {
				while ($a_ma = mysqli_fetch_array($getAMa)) {
					$a_answers[] = $a_ma['answer'];
				}
			}
			// echo "<br>";
			// print_r($a_answers);

			$partial_points = $q_ma_score/$q_ma_size;

			if ($q_ma_size == $a_ma_size) {
				if (array_intersect($q_answers, $a_answers) == $q_answers) {
					$updateScore = $dbconn->query("UPDATE answer_ma_quiz set grade = '$partial_points' where answer_id = '$a_id' and question_number = '$i' ");
					$total_grade += $q_ma_score;
				} else {
					$updateScore = $dbconn->query("UPDATE answer_ma_quiz set grade = 0 where answer_id = '$a_id' and question_number = '$i' ");
				}
				
			} else {
				$updateScore = $dbconn->query("UPDATE answer_ma_quiz set grade = 0 where answer_id = '$a_id' and question_number = '$i' ");
			}
		}
		// echo $total_grade;
	}

	$updateTotalGrade = $dbconn->query("UPDATE answer_quiz set total_grade = '$total_grade' where answer_id = '$a_id' ");

	$getSubject = $dbconn->query("SELECT * from quiz where quiz_id = '$quiz_id' ");
	$quiz = mysqli_fetch_array($getSubject);
	$subject_id = $quiz['subject_id'];

	if ($updateTotalGrade) {
		header("Location:student_course.php?subject_id=".$subject_id);
	}
?>