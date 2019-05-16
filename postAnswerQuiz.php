<?php
	require "db_connection.php";
	
	// if(isset($_POST['submit_answer'])) {
		$answer_id = $_POST['answerId'];
		$total_grade = 0;

		if (!empty($answer_id)) {
			if($getIdenSize != 0) {
				$idenAnswer = $_POST['iden_quiz_answer'];
			}
			if($getMulChoSize != 0) {
				$mcAnswer = $_POST['mc_quiz_answer'];
			}
			if($getMulAnsSize != 0) {
				$maAnswer = $_POST['ma_quiz_answer'];
			}
			if($getEssaySize != 0) {
				$essayAnswer = $_POST['essay_quiz_answer'];
			}

			if(!empty($idenAnswer)) {
				$count = 1;
				foreach($idenAnswer as $key => $n ) {
					$insertIdenAnswer = $dbconn->query("INSERT into answer_iden_quiz(answer_id, question_number, answer, grade) values('$answer_id', '$count', '$n', -1) ");
					$count++;
				}
			}

			if(!empty($mcAnswer)) {
				$count = 1;
				foreach($mcAnswer as $key => $n) {
					$insertMCAnswer = $dbconn->query("INSERT into answer_mc_quiz(answer_id, question_number, answer, grade) values('$answer_id', '$count', '$n', -1) ");
					$count++;
				}
			}

			if(!empty($maAnswer)) {
				$keys = array_keys($maAnswer);
				for($i = 0; $i < count($maAnswer); $i++) {
					foreach($maAnswer[$keys[$i]] as $key => $value) {
						$count = $i + 1;
						$insertMAAnswer = $dbconn->query("INSERT into answer_ma_quiz(answer_id, question_number, answer, grade) values('$answer_id', '$count', '$value', -1) ");
					}
				}
			}
			
			if(!empty($essayAnswer)) {
				$count = 1;
				foreach($essayAnswer as $key => $n ) {
					$insertEssayAnswer = $dbconn->query("INSERT into answer_essay_quiz(answer_id, question_number, answer, grade) values('$answer_id', '$count', '$n', -1) ");
					$count++;
				}
			}
		}
	// }
?>