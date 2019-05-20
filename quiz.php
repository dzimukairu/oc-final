<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "";
	date_default_timezone_set("Asia/Manila");

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

	$get_teacher = $dbconn->query("SELECT * from teacher where teacher_id = '$teacher_id';");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];

	$graded = 0;

	if(isset($_POST['pass_grade'])) {
		$answer_id = $_POST['answer_id'];
		$grade = $_POST['grade'];
		$essaySize = $_POST['essaySize'];
		$total_grade = $_POST['total_grade'];
		$xgrade = 0;

		for ($i = 1; $i <= $essaySize; $i++) {
			$index = ($i-1);
			$xgrade += $grade[$index];
			$updateEssayGrade = $dbconn->query("UPDATE answer_essay_quiz set grade = '$grade[$index]' where answer_id = '$answer_id' and question_number = '$i' ");
		}

		$total_grade += $xgrade;
		$updateGrade = $dbconn->query("UPDATE answer_quiz set total_grade = '$total_grade' where answer_id = '$answer_id' ");
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
	<script src="js/getdate.js"></script>

	<style type="text/css">
		#wrapper {
			position: absolute;
			float: right;
			display: table;
			text-align: center;
			width: 25%;
			z-index: 1;
			top: 590px;
			right: 100px;
		}

		#wrapper div {
			display: table-cell;
		}

		#wrapper div b {
			font-size: 50px;
		}

		#all_answer_div {
			display: none;
		}

		#quizDiv {
			display: none;
		}
	</style>

	<script type="text/javascript">
		function show_hide() {
			var x = document.getElementById("all_answer_div");
			if (x.style.display === "block") {
				x.style.display = "none";
			} else {
				x.style.display = "block";
				x.scrollIntoView();
			} 
		}

		function show_hide_quiz() {
			var x = document.getElementById("quizDiv");
			if (x.style.display === "block") {
				x.style.display = "none";
			} else {
				x.style.display = "block";
				x.scrollIntoView();
			} 
		}
	</script>
</head>

<body onload="show_status()">
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

	<div class="student-quiz-content" style="margin-top: 50px">
		<div class="container">
			<div class="row">
				<div style="margin-bottom:12px;">
					<?php 
						echo "<a href=teacher_course.php?subject_id=",urlencode($subject_id)," class='btn clever-btn'>Back</a>";
					?>
				</div>
				<div class="col-12 col-lg-12 border rounded">
					<!-- <div id="clonedDiv">
					</div> -->
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
						<h6>Deadline: <?php echo $combinedtime ?></h6>
						<br>
						<p>
							<?php 
								$xdate = new DateTime($date_posted);
								// $x = DateTime::createFromFromat('M d, Y', $xdate);
								$y = date_format($xdate, 'M d, Y - h:i A');
								echo $y;
							?>
						</p>

						
						<button class="btn btn-primary" onclick="show_hide_quiz()">Preview Quiz</button>
						<button class="btn btn-success" onclick="show_hide()">View All Answers</button>
						<!-- <button class="btn btn-danger" onclick="deleteFunction(<?php echo $id;?>)">Delete</button> -->

						<div id="quizDiv" style="margin-top: 30px;">
							<?php
								$getIdentification = $dbconn->query("SELECT * from identification_quiz where quiz_id = '$id' ");
								$getIdenSize = mysqli_num_rows($getIdentification);
								$getMultipleChoice = $dbconn->query("SELECT * from multiplechoice_quiz where quiz_id = '$id' ");
								$getMulChoSize = mysqli_num_rows($getMultipleChoice);
								$getMultipleAnswer = $dbconn->query("SELECT * from multipleanswer_quiz where quiz_id = '$id' ");
								$getMulAnsSize = mysqli_num_rows($getMultipleAnswer);
								$getEssay = $dbconn->query("SELECT * from essay_quiz where quiz_id = '$id' ");
								$getEssaySize = mysqli_num_rows($getEssay);

								if ($getIdenSize != 0) {
									echo "<h5>Identification</h5>";
									for ($i=1; $i<=$getIdenSize; $i++) {
										$getIden = $dbconn->query("SELECT * from identification_quiz where quiz_id = '$id' and question_number = '$i' ");
										$iden = mysqli_fetch_array($getIden);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$iden['question']." (".$iden['grade']."pts)</h6>";
										echo "<p style='font-style: italic; margin-left: 40px; margin-bottom: 2px'>Answer: ".$iden['answer']."</p>";
									} 
								}

								if ($getMulChoSize != 0) {
									echo "<h5>Multiple Choice</h5>";
									for ($i=1; $i<=$getMulChoSize; $i++) {
										$getMC = $dbconn->query("SELECT * from multiplechoice_quiz where quiz_id = '$id' and question_number = '$i' ");
										$mc = mysqli_fetch_array($getMC);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$mc['question']." (".$mc['grade']."pts)</h6>";

										$getMCchoices = $dbconn->query("SELECT * from multiplechoice_choices where quiz_id = '$id' and question_number = '$i' ");
										echo "<div style='margin-left: 20px'>";
										while ($choice = mysqli_fetch_array($getMCchoices)) {
											echo "<input style='margin-left: 30px;' type='radio' name=".$i." value=".$choice['option'].">&nbsp;".$choice['option'];
										}
										echo "</div>";
										echo "<p style='font-style: italic; margin-left: 40px; margin-bottom: 2px'>Answer: ".$mc['answer']."</p>";
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
										while ($choice = mysqli_fetch_array($getMAchoices)) {
											echo "<input style='margin-left: 30px;' type='checkbox' name=".$i." value=".$choice['option'].">&nbsp;".$choice['option'];
										}
										echo "</div>";
										
										$getMAanswers = $dbconn->query("SELECT * from multipleanswer_answers where quiz_id = '$id' and question_number = '$i' ");
										echo "<div style='margin-left: 20px'>";
										echo "<p style='font-style: italic; margin-left: 20px; margin-bottom: 2px; display: inline'>Answer/s: </p>";
										while ($answer = mysqli_fetch_array($getMAanswers)) {
											echo "<p style='font-style: italic; display: inline'>".$answer['answer'].",&nbsp&nbsp;</p>";
										}
										echo "</div>";
									} 	
								}

								if ($getEssaySize != 0) {
									echo "<h5>Essay</h5>";
									for ($i=1; $i<=$getEssaySize; $i++) {
										$getEssay = $dbconn->query("SELECT * from essay_quiz where quiz_id = '$id' and question_number = '$i' ");
										$essay = mysqli_fetch_array($getEssay);
										echo "<h6 style='font-weight: bold; margin-bottom: 0; margin-left: 20px;'>".$i.". ".$essay['question']." (".$essay['grade']."pts)</h6>";
									} 
								}
							?>
						</div>

						<script>
							function deleteFunction(id) {
								var del = confirm("Do you really want to delete this quiz?");

								if (del == true) {
									document.location.href = 'quiz_delete.php?id='+id;
								}
							}
						</script>
					</div>
				</div>
			</div>
		</div>

		<div id="all_answer_div" class="container" style="margin-top: 20px">
			<div class="row">
				<br><br>
				<div class="col-12 col-lg-12">
					<?php
					$get_student_id = $dbconn->query("SELECT * from enrolls INNER JOIN answer_quiz where enrolls.subject_id = '$subject_id' and answer_quiz.quiz_id = '$id' and enrolls.student_id = answer_quiz.student_id ");
					
					if (mysqli_num_rows($get_student_id) != 0) {
							$all_enrolled = array();
							while ($irow = mysqli_fetch_array($get_student_id)) {
								$all_enrolled[] = $irow['student_id'];
							}

							$all_lastname = array();
							foreach ($all_enrolled as $sid) {
								$get_lastname = $dbconn->query("SELECT * from student where student_id = '$sid' ");
								$ln = mysqli_fetch_array($get_lastname);
								$lastname = $ln['last_name'];
								$all_lastname[] = $lastname;
							}
							
							$sorted_ln = $all_lastname;
							sort($sorted_ln);
							
							echo "<div>";
							echo "<h4>Student Answers:</h4>";
							echo "<br>";
							echo "<div class='row'>";

							$doneLate = 0;

							foreach ($sorted_ln as $sln) {
								$get_student = $dbconn->query("SELECT * from student where last_name = '$sln' ");
								$srow = mysqli_fetch_array($get_student);
								$fname = $srow['first_name'];
								$student_id = $srow['student_id'];

								$get_answer_query = $dbconn->query("SELECT * from answer_quiz where student_id = '$student_id' and quiz_id = '$id' ");

								$hasFile = false;
								$grade = 0;
							
								if (mysqli_num_rows($get_answer_query) != 0 ) {
									$arow = mysqli_fetch_array($get_answer_query);
									$answer_id = $arow['answer_id'];
									$answer_posted = $arow['date_posted'];
									$grade = $arow['total_grade'];
								}

					?>		
								<div class="col-lg-4 border rounded">
									<div style="padding: 20px 5px 10px">
										<?php
											echo "<h5>".$sln.", ".$fname."</h5>";
											echo "<br>";

											$getEssay_answer = $dbconn->query("SELECT * from answer_essay_quiz where answer_id = '$answer_id' ");
											$essayGraded = 0;
											$essayAnswer = mysqli_num_rows($getEssay_answer);
											if ($essayAnswer != 0) {
												while($row = mysqli_fetch_array($getEssay_answer)) {
													if ($row['grade'] != -1) {
														$essayGraded += 1;
													}
												}
											}

											if ($getEssaySize != 0) {
												if ($essayGraded != $essayAnswer) {
													echo "<b>Partial Grade: ".$grade."</b>";
												} else {
													$graded += 1;
													echo "<b>Overall Grade: ".$grade."</b>";
												}
											} else {
												$graded += 1;
												echo "<b>Overall Grade: ".$grade."</b>";
											}
											echo "<br><br><br>";
											if ($getEssaySize != 0) {
												if($essayAnswer != 0) {
													for($i = 1; $i <= $getEssaySize; $i++) {
														$getQ = $dbconn->query("SELECT * from essay_quiz where quiz_id = '$id' and question_number = '$i' ");
														$q = mysqli_fetch_array($getQ);
														$e_question = $q['question'];
														$e_grade = $q['grade'];

														$getA = $dbconn->query("SELECT * from answer_essay_quiz where answer_id = '$answer_id' and question_number = '$i' ");
														$a = mysqli_fetch_array($getA);
														$e_answer = $a['answer'];
														$e_gradex = $a['grade'];

														if ($e_gradex == -1) {
															$e_gradex = 0;
														}

														echo "<b>".$i.". ".$e_question."</b>";
														echo "<br>";
														if ($e_answer == NULL) {
															echo "<i class='text-danger'>No answer.</i>";
														} else {
															echo "<i>".$e_answer."</i>";
														}
												?>
														<br>
														<form method="POST">
															<input name="answer_id" value="<?php echo $answer_id; ?>" hidden>
															<input name="essaySize" value="<?php echo $getEssaySize; ?>" hidden>
															<input name="total_grade" value="<?php echo $grade; ?>" hidden>
															<i>Max Grade: <b><?php echo $e_grade; ?></b></i>
															<div class="input-group mb-3">
							  									<input type="number" class="form-control" name="grade[]" placeholder="Input Grade" value="<?php echo $e_gradex; ?>" max="<?php echo $e_grade;?>" min=0>
															</div>

												<?php
														echo "<br>";
													}
												?>
														<button class="btn btn-success pull-right" name="pass_grade">Submit Grade</button>
													</form>
												<?php
												} else {
													echo "<b>No answer/s on essay part.</b>";
												}
											}
										?>
										<br><br>
									</div>
								</div>
					<?php
							}
							echo "</div>";
						echo "</div>";
					} else {
						echo "<h4>No Answers found.</h4";
					}
				?>
				</div>
			</div>
			<div id="wrapper">
				<div style="border-right: 2pt dashed;">
					<b>
					<?php
						$num_student = $dbconn->query("SELECT * from enrolls where subject_id = '$subject_id' ");
						echo (mysqli_num_rows($num_student) - mysqli_num_rows($get_student_id));
					?>
					</b>
					<br>
					<i>Remaining</i>
				</div>
				<div style="border-right: 2pt dashed;">
					<b>
						<?php 
							if (mysqli_num_rows($get_student_id) != 0) {
								echo (mysqli_num_rows($get_student_id) - $doneLate); 
							} else {
								echo 0;
							}
						?>
					</b>
					<br>
					<i>On Time</i>
				</div>
				<div style="border-right: 2pt dashed;">
					<b>
					<?php
						if (mysqli_num_rows($get_student_id) != 0) {
							echo $doneLate;
						} else {
							echo 0;
						}
					?>
					</b>
					<br>
					<i>Done Late</i>
				</div>
				<div>
					<b><?php echo $graded; ?></b>
					<br>
					<i>Graded</i>
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