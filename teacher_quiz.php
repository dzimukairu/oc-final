<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}
	
	$id = $_GET['subject_id'];
	$username = $_SESSION['username'];

	date_default_timezone_set("Asia/Manila");

	$sql = "SELECT subject_code, course_title, course_description, course_about, teacher_id from subject where subject_id = $id";

	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_code = $row['subject_code'];
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];


	$get_teacher = $dbconn->query("SELECT * from teacher where username = '$username';");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];

	$error1 = "";
	$error2 = "";
	$error3 = "";
	$noError = true;


	$identificationLength = 0;
	$multipleChoiceLength = 0;
	$multipleAnswerLength = 0;
	$essayLength = 0;

	if(isset($_POST['add_quiz'])) {
		$quiz_title = $_POST['quiz_title'];
		$deadline_date = $_POST['deadline_date'];
		$deadline_time = $_POST['deadline_time'];
		$time_limit = $_POST['time_limit'];

		$deadline = date('Y-m-d H:i:s', strtotime("$deadline_date $deadline_time"));
		$todayTime = date('Y-m-d H:i:s');

		$to_time = strtotime($deadline);
		$from_time = strtotime($todayTime);
		$timediff = ($to_time - $from_time)/3600;

		if ($timediff  < 0) {
			$error1 = 'Invalid date/time.';
			$noError = false;
		}

		if (empty($quiz_title)) {
			$error2 = 'Please input title.';
			$noError = false;
		}

		if ($time_limit == 0) {
			$error2 = 'Please input time limit.';
			$noError = false;
		} 

		$identificationLength = $_POST['identificationTable_length'];
		$multipleChoiceLength = $_POST['multipleChoiceTable_length'];
		$multipleAnswerLength = $_POST['multipleAnswerTable_length'];
		$essayLength = $_POST['essayTable_length'];

		if (($identificationLength == 0) && ($multipleChoiceLength == 0) && ($multipleAnswerLength == 0) && ($essayLength == 0)) {
			$error3 = "Empty Quiz.";
			$noError = false;
		}

		if ($noError) {
			$insertQuiz = $dbconn->query("INSERT into quiz(subject_id, quiz_title, date_posted, deadline_date, deadline_time, total_grade, time_limit) values('$id', '$quiz_title', NOW(), '$deadline_date', '$deadline_time', 0, '$time_limit')");

			$quiz_id = $dbconn->insert_id;
			$total_grade = 0;

			if ($insertQuiz) {
				if ($identificationLength != 0) {
					$question = $_POST['identification_question'];
					$answer = $_POST['identification_answer'];
					$point = $_POST['identification_point'];

					$count = 1;
					foreach($question as $key => $n ) {
						$insertQuestion = $dbconn->query("INSERT into identification_quiz(quiz_id, question_number, question, answer, grade) values('$quiz_id', '$count', '$n', 'h', 0) ");
						$count++;
					}

					$count = 1;
					foreach($answer as $key => $n ) {
						$insertAnswer = $dbconn->query("UPDATE identification_quiz set answer = '$n' where question_number = '$count' and quiz_id = '$quiz_id' ");
						$count++;
					}

					$count = 1;
					foreach($point as $key => $n ) {
						$total_grade = $total_grade + $n;
						$insertGrade = $dbconn->query("UPDATE identification_quiz set grade = '$n' where question_number = '$count' and quiz_id = '$quiz_id' ");
						$count++;
					}
				}
				if ($multipleChoiceLength != 0) {
					$question = $_POST['multipleChoice_question'];
					$choice = $_POST['multipleChoice_choices'];
					$answer = $_POST['multipleChoice_answer'];
					$point = $_POST['multipleChoice_point'];

					$count = 1;
					foreach($question as $key => $n ) {
						$insertQuestion = $dbconn->query("INSERT into multiplechoice_quiz(quiz_id, question_number, question, answer, grade) values('$quiz_id', '$count', '$n', '', 0) ");
						$count++;
					}

					$count = 1;
					foreach($choice as $key => $n ) {
						$choices = explode(";", $n);

						foreach($choices as $choice) {
							$insertChoice = $dbconn->query("INSERT into multiplechoice_choices(quiz_id, question_number, option) values('$quiz_id', '$count', '$choice') ");
						}
						$count++;
					}

					$count = 1;
					foreach($answer as $key => $n ) {
						$insertAnswer = $dbconn->query("UPDATE multiplechoice_quiz set answer = '$n' where question_number = '$count' and quiz_id = '$quiz_id' ");
						$count++;
					}

					$count = 1;
					foreach($point as $key => $n ) {
						$total_grade = $total_grade + $n;
						$insertGrade = $dbconn->query("UPDATE multiplechoice_quiz set grade = '$n' where question_number = '$count' and quiz_id = '$quiz_id' ");
						$count++;
					}
				} 
				if ($multipleAnswerLength != 0) {
					$question = $_POST['multipleAnswer_question'];
					$choice = $_POST['multipleAnswer_choices'];
					$answer = $_POST['multipleAnswer_answer'];
					$point = $_POST['multipleAnswer_point'];

					$count = 1;
					foreach($question as $key => $n ) {
						$insertQuestion = $dbconn->query("INSERT into multipleanswer_quiz(quiz_id, question_number, question, grade) values('$quiz_id', '$count', '$n', 0) ");
						$count++;
					}

					$count = 1;
					foreach($choice as $key => $n ) {
						$choices = explode(";", $n);

						foreach($choices as $choice) {
							$insertChoice = $dbconn->query("INSERT into multipleanswer_choices(quiz_id, question_number, option) values('$quiz_id', '$count', '$choice') ");
						}
						$count++;
					}

					$count = 1;
					foreach($answer as $key => $n ) {
						$answers = explode(";", $n);

						foreach($answers as $answer) {
							$insertAnswer = $dbconn->query("INSERT into multipleanswer_answers(quiz_id, question_number, answer) values('$quiz_id', '$count', '$answer') ");
						}
						$count++;
					}

					$count = 1;
					foreach($point as $key => $n ) {
						$total_grade = $total_grade + $n;
						$insertGrade = $dbconn->query("UPDATE multipleanswer_quiz set grade = '$n' where question_number = '$count' and quiz_id = '$quiz_id' ");
						$count++;
					}
				} 
				if ($essayLength != 0) {
					$question = $_POST['essay_question'];
					$point = $_POST['essay_point'];

					$count = 1;
					foreach($question as $key => $n ) {
						$insertQuestion = $dbconn->query("INSERT into essay_quiz(quiz_id, question_number, question, grade) values('$quiz_id', '$count', '$n', 0) ");
						$count++;
					}

					$count = 1;
					foreach($point as $key => $n ) {
						$total_grade = $total_grade + $n;
						$insertGrade = $dbconn->query("UPDATE essay_quiz set grade = '$n' where question_number = '$count' and quiz_id = '$quiz_id' ");
						$count++;
					}
				}

				$updateGrade = $dbconn->query("UPDATE quiz set total_grade = '$total_grade' where quiz_id = '$quiz_id' and subject_id = '$id' ");

				if ($updateGrade) {
					header("Location: teacher_course.php?subject_id=".$id);
				}
			}
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

	<style>
		.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
		.toggle.ios .toggle-handle { border-radius: 20px; }

		.table td {
			padding: 3px;
		}
	</style>

	<script>
		function findTotal() {
			var arr = document.getElementsByClassName('points');
			var tot=0;
			for(var i=0;i<arr.length;i++){
				if(parseInt(arr[i].value)) {
					tot += parseInt(arr[i].value);
				}
			}
			document.getElementById('total_grade').value = tot;
		}

		function convertTime() {
			var tempSec = document.getElementById("time_limit").value;
			hour = parseInt(tempSec/3600);
			tempSec = tempSec%3600;
			min = parseInt(tempSec/60);
			sec = tempSec%60;
			var fnH = ("0" + hour).slice(-2);
			var fnM = ("0" + min).slice(-2);
			var fnS = ("0" + sec).slice(-2);
			document.getElementById("timeConvert").innerHTML = fnH + "h:" + fnM + "m:" + fnS + "s";
		}
	</script>
</head>

<body>
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

							<!-- Register / Login -->
							<div class="login-state d-flex align-items-center">
								<div class="user-name mr-30">
									<div class="dropdown">
										<a class="dropdown-toggle" href="#" role="button" id="userName" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $t_firstname." ".$t_lastname; ?></a>
										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userName">
											<?php 
												echo "<a href=teacher_home.php class='dropdown-item'>Home</a>"; 
												echo "<a href=profile.php class='dropdown-item'>Profile</a>";
												echo "<a href=logout.php class='dropdown-item'>Logout</a>";
											?>
										</div>
									</div>
								</div>
								<div class="userthumb">
									<!-- <img src="img/bg-img/t1.png" alt=""> -->
									<?php 
										echo "<a href=profile.php><img src=img/tea-img/",urlencode($image)," style='border-radius: 50%; height: 40px; width: 40px'></a>" 
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

	<div class="student-quiz-content section-padding-100">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-12">
					<div class="section-heading">
						<h3>Create New Quiz</h3>
					</div>        
			   </div>
			</div>
			<div class="row">
				<h7 class="text-danger"><?php echo $error1; ?></h7>
				&nbsp;
				<h7 class="text-danger"><?php echo $error2; ?></h7>
				&nbsp;
				<h7 class="text-danger"><?php echo $error3; ?></h7>
				<div class="col-12 col-lg-12 border rounded">
					<div style="padding: 20px 12px 50px 12px;">
						<form method="POST">
							<div class="offset-md-2 col-8 input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Quiz Title:</div>
									<textarea data-autoresize rows="1" cols="80" class="form-control expand_this" id="quiz_title" name="quiz_title" required></textarea>
								</div>
							</div>
							<br>
							<div class="offset-md-3 col-6 input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Deadline:</div>
								</div>
								<?php
									$startTime = date("Y-m-d H:i:s");
									$cenvertedTime = date('Y-m-d',strtotime('+1 hour',strtotime($startTime)));

								?>
								<input type="date" name="deadline_date" id="deadline_date" value="<?php echo $cenvertedTime; ?>" min="<?php echo $cenvertedTime; ?>" class="form-control">
								<input type="time" name="deadline_time" id="deadline_time" value="<?php echo date('H:i', time()+3600);?>" class="form-control">
							</div>
							<div class="offset-md-3 col-6">
								<p style="font-style: italic">Deadline time is set 1 hour after of current time. (You can change it)</p>
							</div>
							<div class="offset-md-4 col-5 input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Total Points:</div>
									<input class="form-control" readonly id="total_grade" name="total_grade" required value=0>
								</div>
							</div>
							<br>
							<div class="offset-md-3 col-6 input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Time Limit:</div>
									<input type="number" min="0" class="form-control" id="time_limit" name="time_limit" value=0 style="width: 150px;" onchange="convertTime()" onkeyup="convertTime()" required>
								</div>
								<div class="input-group-append">
									<span class="input-group-text" id="">secs</span>
								</div>
								<div class="d-inline" style="margin-left: 20px;">
									<h4 id="timeConvert" style="margin-bottom: 0; vertical-align: middle">00h:00m:00s</h4>
								</div>
							</div>
							<div class="offset-md-4 col-6">
								<p style="font-style: italic">Note: Input time in seconds.
									<a href="https://www.tools4noobs.com/online_tools/hh_mm_ss_to_seconds/" target="_blank">(Need help?)</a>
								</p>
							</div>
							<br><br><br>

							<div id="quiz_identification" class="form-group">
								<label style="font-weight: bold">
									<input id="toggle1" class="on_off" data-toggle="toggle" data-style="ios" data-on="Enabled" data-on-text="Enabled" data-off="Disabled" data-off-text="Disabled" type="checkbox" data-onstyle="primary" data-offstyle="danger">
									&nbsp;&nbsp;&nbsp;Identification
								</label>
								<div id="identification">
									<input type="button" value="Add Row" onclick="addRow('identificationTable')" class="btn btn-success"/>
									<input type="button" value="Delete Row" onclick="deleteRow('identificationTable')"  class="btn btn-danger"/>
									<br>
									<br>
									<table id="identificationTable" class="table table-hover">
										<tr>
											<td style="width: 10px"><input type="checkbox" class="form-check-input" name="chk"/></td>
											<td style="width: 20px"><p>1</p></td>

											<td><textarea data-autoresize rows="2" class="form-control expand_this" id="identification_question[]" name="identification_question[]" value="" placeholder="Question" ></textarea></td>

											<td><textarea data-autoresize rows="2" class="form-control expand_this" id="identification_answer[]" name="identification_answer[]" value="" placeholder="Answer" ></textarea></td>

											<td style="width:120px"><input type="number" class="form-control points" onchange="findTotal()" onkeyup="findTotal()" id="identification_point[]"name="identification_point[]" min="0" placeholder="Points" ></td>
										</tr>
									</table>
									<input type="hidden" id="identificationTable_length" name="identificationTable_length" value=0/>
								</div>
							</div>
							<div id="quiz_multipleChoice" class="form-group">
								<label style="font-weight: bold">
									<input id="toggle2" class="on_off" data-toggle="toggle" data-style="ios" data-on="Enabled" data-off="Disabled" type="checkbox" data-onstyle="primary" data-offstyle="danger">
									&nbsp;&nbsp;&nbsp;Multiple Choice
								</label>
								<div id="multipleChoice">
									<input type="button" value="Add Row" onclick="addRow('multipleChoiceTable')"  class="btn btn-success"/>
									<input type="button" value="Delete Row" onclick="deleteRow('multipleChoiceTable')"  class="btn btn-danger"/>
									<br>
									<br>

									<table id="multipleChoiceTable" class="table table-hover">
										<tr>
											<td style="width: 10px"><input type="checkbox" class="form-check-input" name="chk"/></td>
											<td><p>1</p></td>

											<td><textarea data-autoresize rows="2" class="form-control expand_this" id="multipleChoice_question[]" name="multipleChoice_question[]" value="" placeholder="Question" ></textarea></td>

											<td> <textarea data-autoresize rows="2" class="form-control expand_this" id="multipleChoice_choices[]" name="multipleChoice_choices[]" value="" placeholder="Choices (separated by semicolon ';')" ></textarea></td>

											<td><textarea data-autoresize rows="2" class="form-control expand_this" id="multipleChoice_answer[]" name="multipleChoice_answer[]" value="" placeholder="Answer" ></textarea></td>

											<td style="width:120px"><input type="number" class="form-control points" onchange="findTotal()" onkeyup="findTotal()" id="multipleChoice_point[]"name="multipleChoice_point[]" min="0" placeholder="Points" ></td>
										</tr>
									</table>
									<input type="hidden" id="multipleChoiceTable_length" name="multipleChoiceTable_length" value=0/>
								</div>
							</div>
							<div id="quiz_multipleAnswer" class="form-group">
								<label style="font-weight: bold">
									<input id="toggle3" class="on_off" data-toggle="toggle" data-style="ios" data-on="Enabled" data-off="Disabled" type="checkbox" data-onstyle="primary" data-offstyle="danger">
									&nbsp;&nbsp;&nbsp;Multiple Answers
								</label>
								<div id="multipleAnswer">
									<input type="button" value="Add Row" onclick="addRow('multipleAnswerTable')"  class="btn btn-success"/>
									<input type="button" value="Delete Row" onclick="deleteRow('multipleAnswerTable')"  class="btn btn-danger"/>
									<br>
									<br>
									
									<table id="multipleAnswerTable" class="table table-hover">
										<tr>
											<td style="width: 10px"><input type="checkbox" class="form-check-input" name="chk"/></td>
											<td style="width: 20px"><p>1</p></td>

											<td><textarea data-autoresize rows="2" class="form-control expand_this" id="multipleAnswer_question[]" name="multipleAnswer_question[]" value="" placeholder="Question" ></textarea></td>        

											<td><textarea data-autoresize rows="2" class="form-control expand_this" id="multipleAnswer_choices[]" name="multipleAnswer_choices[]" value="" placeholder="Choices (separated by semicolon ';')" ></textarea></td>

											<td><textarea data-autoresize rows="2" class="form-control expand_this" id="multipleAnswer_answer[]" name="multipleAnswer_answer[]" value="" placeholder="Answer/s (separated by semicolon ';')" ></textarea></td>

											<td style="width:120px"><input type="number" class="form-control points" onchange="findTotal()" onkeyup="findTotal()" id="multipleAnswer_point[]"name="multipleAnswer_point[]" min="0" placeholder="Points" ></td>
										</tr>
									</table>
									<input type="hidden" id="multipleAnswerTable_length" name="multipleAnswerTable_length" value=0/>
								</div>
							</div>
							<div id="quiz_essay" class="form-group">
								<label style="font-weight: bold">
									<input id="toggle4" class="on_off" data-toggle="toggle" data-style="ios" data-on="Enabled" data-off="Disabled" type="checkbox" data-onstyle="primary" data-offstyle="danger">
									&nbsp;&nbsp;&nbsp;Essay
								</label>
								<div id="essay">
									<input type="button" value="Add Row" onclick="addRow('essayTable')"  class="btn btn-success"/>
									<input type="button" value="Delete Row" onclick="deleteRow('essayTable')"  class="btn btn-danger"/>
									<br>
									<br>

									<table id="essayTable" class="table table-hover">
										<tr>
											<td style="width: 10px"><input type="checkbox" class="form-check-input" name="chk"/></td>
											<td style="width: 20px"><p>1</p></td>

											<td><textarea data-autoresize rows="2" class="form-control expand_this" id="essay_question[]" name="essay_question[]" value="" placeholder="Question" ></textarea></td>

											<td style="width:120px"><input type="number" class="form-control points" onchange="findTotal()" onkeyup="findTotal()" id="essay_point[]"name="essay_point[]" min="0" placeholder="Points" ></td>
										</tr>
									</table>
									<input type="hidden" id="essayTable_length" name="essayTable_length" value=0/>
								</div>
							</div>

							<input type="submit" class="btn btn-success pull-right" name="add_quiz" value="ADD QUIZ"/>
						</form>
					</div>
				</div>

				<div style="margin-top:12px;">
					<?php 
						echo "<a href=teacher_course.php?subject_id=",urlencode($id)," class='btn clever-btn'>Back</a>";
					?>
				</div>
			</div>
		</div>
	</div>

	<?php include("footer.php"); ?>

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
	<script src="js/quiz2.js"></script>
	<script src="js/expand.js"></script>
	<script src="js/createQuiz.js"></script>
</body>

</html>