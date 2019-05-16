<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "";
	date_default_timezone_set("Asia/Manila");

	$username = $_SESSION['username'];

	$id = $_GET['quiz_id'];

	$sql = "SELECT subject.subject_id, subject.subject_code, subject.course_title, subject.course_description, subject.course_about, subject.teacher_id, quiz.quiz_title, quiz.date_posted, quiz.deadline_date, quiz.deadline_time, quiz.total_grade, quiz.time_limit  from subject INNER JOIN quiz on (quiz.quiz_id = $id and subject.subject_id = quiz.subject_id)";

	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_id = $row['subject_id'];
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$quiz_title = $row['quiz_title'];
	$deadline_date = $row['deadline_date'];
	$deadline_time = $row['deadline_time'];
	$date_posted = $row['date_posted'];
	$time_limit = $row['time_limit'];
	$score = $row['total_grade'];

	$combinedtime = date('Y-m-d H:i:s', strtotime("$deadline_date $deadline_time"));
	$xdate = new DateTime($combinedtime);
	$combinedtime = date_format($xdate, 'M d, Y - h:i A');

	$get_student = $dbconn->query("SELECT * from student where username = '$username';");
	$srow = mysqli_fetch_array($get_student);
	
	$s_id = $srow['student_id'];
	$s_username = $srow['username'];
	$s_firstname = $srow['first_name'];
	$s_lastname = $srow['last_name'];
	$image = $srow['image'];

	$dateToday = date('Y-m-d');

	$checkDiff = strtotime($dateToday) - strtotime($deadline_date);
	$today = false;
	if ($checkDiff == 0) {
		$today = true;
	}
	// echo $today;
	$strTime = strtotime($deadline_time);

	$getIdentification = $dbconn->query("SELECT * from identification_quiz where quiz_id = '$id' ");
	$getIdenSize = mysqli_num_rows($getIdentification);

	$getMultipleChoice = $dbconn->query("SELECT * from multiplechoice_quiz where quiz_id = '$id' ");
	$getMulChoSize = mysqli_num_rows($getMultipleChoice);

	$getMultipleAnswer = $dbconn->query("SELECT * from multipleanswer_quiz where quiz_id = '$id' ");
	$getMulAnsSize = mysqli_num_rows($getMultipleAnswer);

	$getEssay = $dbconn->query("SELECT * from essay_quiz where quiz_id = '$id' ");
	$getEssaySize = mysqli_num_rows($getEssay);

	$getQuizAnswer = $dbconn->query("SELECT * from answer_quiz where student_id = '$s_id' and quiz_id = '$id' ");
	$hasAnswer = false;

	if (mysqli_num_rows($getQuizAnswer) != 0) {
		$hasAnswer = true;
	}

	if(isset($_POST['submit_answer'])) {
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

			header("Location:checkQuiz.php?aid=".$answer_id);
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 4 meta tags *Must* come first in the head; any other head content must come *after* these tags -->

	<!-- Title -->
	<title>Online Classroom | Quiz</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/expand.css">
	<link rel="stylesheet" href="css/bootstrap-toggle.min.css">
	<!-- <script src="js/getdate.js"></script> -->


	<!-- https://stephanwagner.me/auto-resizing-textarea -->
	<style>
		@font-face{
			font-family: 'digital-clock-font';
			src: url('fonts/digital-7.ttf');
		}

		#answerDiv {
			display: none;
		}

		#updateDiv {
			display: none;
		}

		#timerDiv {
			font-family: 'digital-clock-font';
			border: 1px black solid; 
			z-index: 3; 
			width: 270px; 
			height: 100px; 
			position: fixed; 
			top: 80px; 
			right: 0; 
			background-color: white;
			font-size: 70px; 
			text-align: center; 
			color: red;
			/*font-weight: bold;*/
			display: none;
		}
	</style>
	<script>
		function checkAnswer() {
			var check = confirm("Do you want to answer quiz?\nNote: If you click 'OK', you can't go back.");
			var secs = <?php echo $time_limit; ?>;
			var sid = <?php echo $s_id; ?>;
			var qid = <?php echo $id; ?>;
			var timerDiv = document.getElementById("timerDiv");
			console.log(secs);

				if (check == true) {
					show_hide();
					document.getElementById("answerBut").disabled = true;
					timerDiv.style.display = "block";
					countDownTimer(secs, timerDiv);
					var dataString = 'sid=' + sid + '&qid=' + qid;
					$.ajax({
						type: "POST",
						url: "postId.php",
						data: dataString,
						success: function(result) {
							$("#answerId").val(result); 
						}
					});
					return false;
				}
		}
		function show_hide() {
			var x = document.getElementById("answerDiv");
			if (x.style.display === "block") {
				x.style.display = "none";
			} else {
				x.style.display = "block";
				x.scrollIntoView();
			} 
		}

		function countDownTimer(secs, div) {
			var timerDiv = document.getElementById("timerDiv");
			var today = <?php echo $today; ?>;
			console.log("today" + today);
			var hour, min, sec, isDeadline;

			var tempSec = parseInt(secs);
			var quizAnswerForm = document.getElementById("quizAnswerForm");
			var but = document.getElementById("submit_answer");

			if (today) {
				isDeadline = checkTime();
				console.log(1);
			}

			if (tempSec < 1 || isDeadline) {
				clearTimeout(timer);
				timerDiv.innerHTML = 'TIME\'S UP!!';

				setTimeout(function () {
					alert("SUBMITTING QUIZ.....");
					but.click();
				}, 1000);
			} else {
				hour = parseInt(tempSec/3600);
				tempSec = tempSec%3600;
				min = parseInt(tempSec/60);
				sec = tempSec%60;
				var fnH = ("0" + hour).slice(-2);
				var fnM = ("0" + min).slice(-2);
				var fnS = ("0" + sec).slice(-2);
				timerDiv.innerHTML = fnH + ":" + fnM + ":" + fnS;

				secs--;
				var timer = setTimeout('countDownTimer('+secs+',"'+timerDiv+'")',1000); 
			}
		}

		function checkTime() {
			var now = new Date();
			var hour, mins, sec;
			hour = now.getHours();
			min = now.getMinutes();

			// var div = document.getElementById("timeHere");

			if (hour > 12) {
				hour = hour - 12;
			}
			// var time = hour + ':' + min;
			var time = now.getTime();
			var nTime = time/1000;

			var dlTime = <?php echo $strTime; ?>;

			if (nTime >= dlTime) {
				// div.innerHTML = nTime + "\n";
				// div.innerHTML += dlTime + "\n";
				// div.innerHTML += "time's up";
				return true;
			} else {
				// div.innerHTML = nTime + "\n";
				// div.innerHTML += dlTime + "\n";
				// div.innerHTML += "ongoing";
				return false;
			}

			var cd = setTimeout('checkTime()', 1000);

		}
	</script>
</head>

<body onload="checkTime()">
	<!-- Preloader -->
	<div id="preloader">
		<div class="spinner"></div>
	</div>

	<!-- ##### Header Area Start ##### -->
	<header class="header-area">


		<!-- Navbar Area -->
		<div class="clever-main-menu">
			<div class="classy-nav-container breakpoint-off">
				<!-- Menu -->
				<nav class="classy-navbar justify-content-between" id="cleverNav">

					<!-- Logo -->
					<a class="nav-brand" href="index.php"><img src="img/core-img/logo.png" alt=""></a>

					<!-- Navbar Toggler -->
					<div class="classy-navbar-toggler">
						<span class="navbarToggler"><span></span><span></span><span></span></span>
					</div>

					<!-- Menu -->
					<div class="classy-menu">

						<!-- Close Button -->
						<div class="classycloseIcon">
							<div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
						</div>

						<!-- Nav Start -->
						<div class="classynav">
							<!-- <ul>
								<li><a href="teacher_home.php">Home</a></li>
							</ul> -->

							<!-- Register / Login -->
							<div class="login-state d-flex align-items-center">
								<div class="user-name mr-30">
									<div class="dropdown">
										<a class="dropdown-toggle" href="#" role="button" id="userName" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $s_firstname." ".$s_lastname; ?></a>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userName">
											<?php 
												echo "<a href=student_home.php class='dropdown-item'>Home</a>";
												echo "<a href=s_profile.php class='dropdown-item'>Profile</a>";
												echo "<a href=logout.php class='dropdown-item'>Logout</a>";
											?>
										</div>
									</div>
								</div>
								<div class="userthumb">
									<?php 
										echo "<a href=s_profile.php><img src=img/stu-img/",urlencode($image)," style='border-radius: 50%; height: 40px; width: 40px'></a>" 
									?>
								</div>
							</div>
						</div>
						<!-- Nav End -->
					</div>
				</nav>
			</div>
		</div>
	</header>
	<!-- ##### Header Area End ##### -->

	<!-- ##### Single Course Intro Start ##### -->
   <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(img/bg-img/bg1.jpg);">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-12">
					<!-- Hero Content -->
					<div class="hero-content text-center">
						<h2><?php echo $course_description;?></h2>
						<h3><?php echo $course_title;?></h3>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- ##### Single Course Intro End ##### -->

	<div class="student-quiz-content" style="margin-top: 50px">
		<div class="container">
			<div class="row">
				<div style="margin-bottom: 12px">
					<?php 
						echo "<a href=student_course.php?subject_id=",urlencode($subject_id)," class='btn clever-btn'>Back</a>";
					?>
				</div>
				<div class="col-12 col-lg-12 border rounded">
					<div style="padding: 20px 12px 50px 12px;">
						<h5><?php echo $quiz_title;?></h5>
						<br>
						<h6>Total Points: <?php echo $score ?></h6>
						<?php
							$hr = intdiv($time_limit, 3600);
							$time_limit = $time_limit%3600;
							$min = intdiv($time_limit,60);
							$sec = $time_limit%60;

							if ($hr != 0) {
								if ($hr == 1) {
									if ($min <= 1) {
										echo "<h6>Time Limit: ".$hr."hr, ".$min."min, ".$sec."secs</h6>";
									} else {
										echo "<h6>Time Limit: ".$hr."hr, ".$min."mins, ".$sec."secs</h6>";
									}
								} else {
									echo "<h6>Time Limit: ".$hr."hrs, ".$min."mins, ".$sec."secs</h6>";
								}
							} else if ($hr == 0 && $min != 0) {
								if ($min == 1) {
									echo "<h6>Time Limit: ".$min."min, ".$sec."secs</h6>";
								} else {
									echo "<h6>Time Limit: ".$min."mins, ".$sec."secs</h6>";
								}
							} else {
								echo "<h6>Time Limit: ".$sec."secs</h6>";
							}
						?>
						<!-- <div id="timeHere"></div> -->
						<h6>Deadline: <?php echo $combinedtime ?></h6>
						<br>
						<p>
							<?php 
								$xdate = new DateTime($date_posted);
								// $x = DateTime::createFromFromat('M d, Y', $xdate);
								$y = date_format($xdate, 'M d, Y - h:i A');
								echo $y;

								$date = date('Y-m-d H:i:s');
								$first_time = date('Y-m-d H:i:s', strtotime("$deadline_date $deadline_time"));
							?>
						</p>

					<?php
						if ($hasAnswer) {
					?>
						<br><br>
						<h2 style="text-align: center;" class="text-danger">QUIZ SUBMITTED!!</h2>
					<?php
						} else {
							if (strtotime($date) > strtotime($first_time)){
					?>
								<h2 style="text-align: center;" class="text-danger">QUIZ DONE!!</h2>

					<?php
							} else {		
					?>
								<button class='btn btn-primary clever-btn pull-right' id="answerBut" onclick='checkAnswer()'>Answer</button>
					<?php
							}
						}
					?>
					</div>
				</div>
			</div>

			<div id="timerDiv">
				00:00:00
			</div>

			<div class="row" style="margin-top:20px" id="answerDiv" name="answerDiv">
				<div class="col-12 col-lg-12 border rounded" style="padding-top: 20px; padding-bottom: 70px">
					<form method="POST" id="quizAnswerForm">
						<div id="quizDiv" style="margin-left: 40px; padding-right: 50px">
							<?php
								if ($getIdenSize != 0) {
									echo "<h5>Identification</h5>";
									for ($i=1; $i<=$getIdenSize; $i++) {
										$getIden = $dbconn->query("SELECT * from identification_quiz where quiz_id = '$id' and question_number = '$i' ");
										$iden = mysqli_fetch_array($getIden);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$iden['question']." (".$iden['grade']."pts)</h6>";
							?>

										<textarea data-autoresize rows="1" cols="50" class="form-control expand_this" id="iden_quiz_answer[]" name="iden_quiz_answer[]"></textarea>
										<br>
							<?php
									} 
								}

								if ($getMulChoSize != 0) {
									echo "<br>";
									echo "<h5>Multiple Choice</h5>";
									for ($i=1; $i<=$getMulChoSize; $i++) {
										$getMC = $dbconn->query("SELECT * from multiplechoice_quiz where quiz_id = '$id' and question_number = '$i' ");
										$mc = mysqli_fetch_array($getMC);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$mc['question']." (".$mc['grade']."pts)</h6>";

										$getMCchoices = $dbconn->query("SELECT * from multiplechoice_choices where quiz_id = '$id' and question_number = '$i' ");
										echo "<div style='margin-left: 20px'>";
										while ($choice = mysqli_fetch_array($getMCchoices)) {
											echo "<label>";
											echo "<input style='margin-left: 30px;' type='radio' name='mc_quiz_answer[".$i."]' id='mc_quiz_answer[".$i."]' value=".$choice['option'].">&nbsp;".$choice['option'];
											echo "</label>";
										}
										echo "</div>";

										echo "<br>";
									} 	
								}

								if ($getMulAnsSize != 0) {
									echo "<h5>Multiple Answers</h5>";
									for ($i=1; $i<=$getMulAnsSize; $i++) {
										$getMA = $dbconn->query("SELECT * from multipleanswer_quiz where quiz_id = '$id' and question_number = '$i' ");
										$ma = mysqli_fetch_array($getMA);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$ma['question']." (".$ma['grade']."pts)</h6>";

										$getMAchoices = $dbconn->query("SELECT * from multipleanswer_choices where quiz_id = '$id' and question_number = '$i' ");
										echo "<div style='margin-left: 20px'>";
											// echo "<input value=".$i.">";
										while ($choice = mysqli_fetch_array($getMAchoices)) {
											echo "<label>";
											echo "<input style='margin-left: 30px;' type='checkbox' name='ma_quiz_answer[".($i-1)."][]' id='ma_quiz_answer[".($i-1)."][]' value=".$choice['option'].">&nbsp;".$choice['option'];
											echo "</label>";
										}
										echo "</div>";
										echo "<br>";
									} 	
								}

								if ($getEssaySize != 0) {
									echo "<h5>Essay</h5>";
									for ($i=1; $i<=$getEssaySize; $i++) {
										$getEssay = $dbconn->query("SELECT * from essay_quiz where quiz_id = '$id' and question_number = '$i' ");
										$essay = mysqli_fetch_array($getEssay);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$essay['question']." (".$essay['grade']."pts)</h6>";
							?>

										<textarea data-autoresize rows="1" cols="50" class="form-control expand_this" id="essay_quiz_answer[]" name="essay_quiz_answer[]"></textarea>
										<br>
							<?php
									}
								}
							?>
						</div>
						<br>

						<input name="answerId" id="answerId" hidden>
						<button class="btn btn-success pull-right" id="submit_answer" name="submit_answer">Submit Answer</button>
					</form>
				</div>
			</div>

			
		</div>
	</div>

	<?php include "footer.php"; ?>

	<!-- ##### All Javascript Script ##### -->
	<!-- jQuery-2.2.4 js -->
	<script src="js/jquery/jquery-2.2.4.min.js"></script>
	<!-- Popper js -->
	<script src="js/bootstrap/popper.min.js"></script>
	<!-- Bootstrap js -->
	<script src="js/bootstrap/bootstrap.min.js"></script>
	<!-- All Plugins js -->
	<script src="js/plugins/plugins.js"></script>
	<!-- Active js -->
	<script src="js/active.js"></script>
	<!-- Toggle -->
	<script src="js/bootstrap-toggle.min.js"></script>
	<script src="js/expand.js"></script>
</body>

</html>