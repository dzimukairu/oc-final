<?php
	require "dbconn.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<!-- Stylesheet -->
		<link rel="stylesheet" href="../style.css">
		<link rel="stylesheet" href="../css/expand.css">
		<link rel="stylesheet" href="../css/bootstrap-toggle.min.css">

		<style>
			.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
			.toggle.ios .toggle-handle { border-radius: 20px; }
		</style>

		
	</head>
	<body>
		<div class="row">
			<div style=" width: 92%; margin-left: 4%; margin-top: 10px">
				<?php
					$quiz_id = $_GET['quiz_id'];
					$getQuiz = $dbconn->query("SELECT * from quiz where quiz_id = '$quiz_id' ");
					$quiz = mysqli_fetch_array($getQuiz);
					$quizName = $quiz['name'];
					echo "<h4>".$quizName."</h4>";

					$getSize = $dbconn->query("SELECT * from question where quiz_id = '$quiz_id' ");
					$size = mysqli_num_rows($getSize);

					if($size > 0) {
						echo "<div style='margin-bottom: 20px; border: 1px black solid;'>";
						for ($i=1; $i<=$size; $i++) {
							$getQuestion = $dbconn->query("SELECT * from question where quiz_id = '$quiz_id' and question_id = '$i' ");
							$question = mysqli_fetch_array($getQuestion);
							echo "<div style='padding-bottom: 20px; padding-left: 10px;'>";
							echo "<h5 style='margin-bottom: 0;'>".$i.". <strong>".$question['question']."</strong></h5>";

							echo "<div style='margin-left: 20px; margin-top:5px;'>";
							echo "<h6 style='margin: 0;'>Choices:</h6>";
							echo "<div style='margin-left: 15px;'>";
							$getChoices = $dbconn->query("SELECT * from choice where quiz_id = '$quiz_id' and question_id = '$i' ");

							while ($choice = mysqli_fetch_array($getChoices)) {
								$n = $choice['choice'];
								echo "<input type='checkbox' name=".$n." value=".$n.">".$i."  ".$n;
								echo "<br>";
							}
							echo "</div>";
							echo "</div>";

							echo "<div style='margin-left: 20px; margin-top:5px;'>";
							echo "<h6 style='margin: 0;'>Answer/s:</h6>";
							echo "<div style='margin-left: 15px;'>";
							$getAnswer = $dbconn->query("SELECT * from answer where quiz_id = '$quiz_id' and question_id = '$i' ");

							while ($answer = mysqli_fetch_array($getAnswer)) {
								$n = $answer['answer'];
								echo $n;;
								echo "<br>";
							}
							echo "</div>";
							echo "</div>";
							echo "</div>";

						}
						echo "</div>";
					}

					if($size > 0) {
						echo "<div style='margin-bottom: 20px; border: 1px black solid;'>";
						for ($i=1; $i<=$size; $i++) {
							$getQuestion = $dbconn->query("SELECT * from question where quiz_id = '$quiz_id' and question_id = '$i' ");
							$question = mysqli_fetch_array($getQuestion);
							echo "<div style='padding-bottom: 20px; padding-left: 10px;'>";
							echo "<h5 style='margin-bottom: 0;'>".$i.". <strong>".$question['question']."</strong></h5>";

							echo "<div style='margin-left: 20px; margin-top:5px;'>";
							echo "<h6 style='margin: 0;'>Choices:</h6>";
							echo "<div style='margin-left: 15px;'>";
							$getChoices = $dbconn->query("SELECT * from choice where quiz_id = '$quiz_id' and question_id = '$i' ");

							while ($choice = mysqli_fetch_array($getChoices)) {
								$n = $choice['choice'];
								echo "<input type='radio' name=".$i." value=".$n.">".$i."  ".$n;
								echo "<br>";
							}
							echo "</div>";
							echo "</div>";

							echo "<div style='margin-left: 20px; margin-top:5px;'>";
							echo "<h6 style='margin: 0;'>Answer/s:</h6>";
							echo "<div style='margin-left: 15px;'>";
							$getAnswer = $dbconn->query("SELECT * from answer where quiz_id = '$quiz_id' and question_id = '$i' ");

							while ($answer = mysqli_fetch_array($getAnswer)) {
								$n = $answer['answer'];
								echo $n;;
								echo "<br>";
							}
							echo "</div>";
							echo "</div>";
							echo "</div>";

						}
						echo "</div>";
					}
				?>
			</div>
		</div>

		<script src="../js/jquery/jquery-2.2.4.min.js"></script>
		<!-- Popper js -->
		<script src="../js/bootstrap/popper.min.js"></script>
		<!-- Bootstrap js -->
		<script src="../js/bootstrap/bootstrap.min.js"></script>
		<!-- All Plugins js -->
		<script src="../js/plugins/plugins.js"></script>
		<!-- Active js -->
		<script src="../js/active.js"></script>
		<!-- Toggle -->
		<script src="../js/bootstrap-toggle.min.js"></script>
		<script src="../js/expand.js"></script>
		<script src="quiz.js"></script>
	</body>
</html>