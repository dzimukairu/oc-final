<!-- 
	multipleAnswer_question[]
	multipleAnswer_choices[]
	multipleAnswer_answer[]

	multipleAnswerTable_length

	1; asdasd; 123; aasd
-->

<?php
	require "dbconn.php";

	if(isset($_POST['add_quiz'])) {
		$quizName = $_POST['quiz_name'];
		$insertQuiz = $dbconn->query("INSERT into quiz(name) values('$quizName') ");
		$quiz_id = $dbconn->insert_id;

		$question = $_POST['multipleAnswer_question'];
		$choice = $_POST['multipleAnswer_choices'];
		$answer = $_POST['multipleAnswer_answer'];
		$MAlength = $_POST['multipleAnswerTable_length'];
		$toggle = $_POST['hidden_toggle'];
		echo $toggle;

		echo "Quiz Name: ".$quizName;
		echo "<br>";
		echo "Quiz Id: ".$quiz_id;
		echo "<br><br>";

		if($MAlength > 0) {
			echo 123;
			$count = 1;
			foreach($question as $key => $n ) {
				$inserQuestion = $dbconn->query("INSERT into question(quiz_id, question_id, question) values('$quiz_id', '$count', '$n') ");
				echo $n;
				echo "<br>";
				$count++;
			}
		} else {
			echo "NO QUESTIONS";
		}

		echo "<br>";

		$count = 1;
		foreach($choice as $key => $n ) {
			$choices = explode("; ", $n);

			foreach($choices as $choice) {
				echo $choice;
				echo "<br>";

				$insertChoice = $dbconn->query("INSERT into choice(quiz_id, question_id, choice) values('$quiz_id', '$count', '$choice') ");
			}
			$count++;
			echo "<br>";
		}

		$count = 1;
		foreach($answer as $key => $n ) {
			$answers = explode("; ", $n);

			foreach($answers as $answer) {
				echo $answer;
				echo "<br>";

				$insertAnswer = $dbconn->query("INSERT into answer(quiz_id, question_id, answer) values('$quiz_id', '$count', '$answer') ");
			}
			$count++;
			echo "<br>";
		}

		// header("Location: showQuiz.php?quiz_id=".$quiz_id);

	}

?>