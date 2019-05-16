<?php
	include("db_connection.php");
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$id = $_GET['subject_id'];
	$username = $_SESSION['username'];

	$sql = "SELECT subject_code, course_title, course_description, course_about, teacher_id from subject where subject_id = $id";
	
	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$get_student = $dbconn->query("SELECT * from student where username = '$username';");
	$srow = mysqli_fetch_array($get_student);
	
	$s_id = $srow['student_id'];
	$s_username = $srow['username'];
	$s_firstname = $srow['first_name'];
	$s_lastname = $srow['last_name'];
	$image = $srow['image'];

	$update_graded_assignment = $dbconn->query("UPDATE graded_assignment set opened = 'true' where subject_id = '$id' and student_id = '$s_id' and graded = 'true' ");
	
	//$update_graded_assignment_connect = mysqli_query($dbconn,$update_graded_assignment);

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
	<link rel="stylesheet" href="css/bootstrap-toggle.min.css">

	<style>
		.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
		.toggle.ios .toggle-handle { border-radius: 20px; }

		/*.modal{
			display: block !important;
		}*/
		.modal-dialog{
			overflow-x: initial !important;
			overflow-y: initial !important;
		}
		.modal-body{
			height: 400px;
			overflow-x: auto;
			overflow-y: auto;
		}
	</style>

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

	<div class="student-quiz-content">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-12">
					<div class="section-heading">
						<h3>Your Grades</h3>
					</div>        
			   </div>
			</div>
			<?php 
				echo "<a href=student_course.php?subject_id=",urlencode($id)," class='btn clever-btn'>Back</a>";
			?>
			<br>
			<div>
				<br>
			</div>

			<?php
				// GET ALL ASSIGNMENT
					$all_ass_id = array();
					$assignment_count = 0;
					$get_ass_id = $dbconn->query("SELECT * from assignment where subject_id = '$id' AND assignment_type= 'individual' ");
					while ($arow = mysqli_fetch_array($get_ass_id)) {
						$all_ass_id[] = $arow['assignment_id'];
					}
					$assignment_count = count($all_ass_id);
					$ass_colspan = 2;
					if ($assignment_count > 1) {
						$ass_colspan = $assignment_count+1;
					}
					// echo "assignment_count: ".$assignment_count;
					// echo "<br>";

					//GET ALL GROUP ASSIGNMENT
					$all_group_as = array();
					$group_assignment_count = 0;
					$all_group_as_score = array();
					$get_group = "SELECT * from assignment WHERE subject_id = '$id' AND assignment_type= 'group'";
					$get_group_connect = mysqli_query($dbconn, $get_group);
					//$numberOfRows = mysqli_num_rows($get_group_connect);
					if (mysqli_num_rows($get_group_connect)!=0) {
							while ($gRow = mysqli_fetch_array($get_group_connect)) {
							$all_group_as[] = $gRow['assignment_id'];
							$all_group_as_score[] = $gRow['score'];
						}
					}
					//echo "<script>alert('$numberOfRows')</script>";
					
					$group_assignment_count = count($all_group_as);
					$group_ass_colspan = 2;
					if ($group_assignment_count > 1) {
						$group_ass_colspan = $group_assignment_count + 1;
					}


					// GET ALL QUIZ
					$all_quiz_id = array();
					$quiz_count = 0;
					$get_quiz_id = $dbconn->query("SELECT * from quiz where subject_id = '$id' ");
					while ($arow = mysqli_fetch_array($get_quiz_id)) {
						$all_quiz_id[] = $arow['quiz_id'];
					}
					$quiz_count = count($all_quiz_id);
					$quiz_colspan = 2;
					if ($quiz_count > 1) {
						$quiz_colspan = $quiz_count+1;
					}
					// echo "quiz_count: ".$quiz_count;
			?>

			<div class="row">
				<div class="col-12 col-lg-12">
					<table class="table table-bordered">
						<tr style="text-align: center">
							<th rowspan="2" style="width: 25%; vertical-align: middle;">NAME</th>
							<th colspan="<?php echo $ass_colspan; ?>">ASSIGNMENTS</th>
							<th colspan="<?php echo $group_ass_colspan ?>">GROUP ASSIGNMENTS</th>
							<th colspan="<?php echo $quiz_colspan; ?>">QUIZZES</th>
							<!-- <th rowspan="2" style="width: 5%; vertical-align: middle;">PERCENTAGE</th> -->
						</tr>
						<?php
							$totalscore = 0;
									$group_totalscore = 0;
									$allscore = array();
									$allscore_group = array();

									//for individual assignments
									foreach ($all_ass_id as $ass_id) {
										$getass = $dbconn->query("SELECT * from assignment where assignment_id = '$ass_id' AND assignment_type = 'individual' ");
										$ass = mysqli_fetch_array($getass);
										$xscore = $ass['score'];
										$allscore[] = $xscore;
										$totalscore = $totalscore + $xscore;
									}
									echo "<tr style='text-align: center'>";
									if ($assignment_count != 0) {
										for($x = 0; $x < $assignment_count; $x++) {
											echo "<td style='vertical-align: middle'><a href='assignment.php?assignment_id=$all_ass_id[$x]'><b class='text-success'>".($x+1)."  (".$allscore[$x].")</b></a></td>";
										}
										echo "<td style='width: 180px'><b>Total Grades (".$totalscore.")</b></td>";
									} else {
										echo "<td colspan='2'><i>No assignment/s found.</i></td>";
									}

									//for group assignments

									foreach ($all_group_as_score as $group_key_score) {
										$group_totalscore = $group_totalscore + $group_key_score;
									}
									if ($group_assignment_count != 0) {
										for ($v=0; $v < $group_assignment_count ; $v++) { 
											echo "<td style='vertical-align: middle'><a href='g_assignment.php?assignment_id=$all_group_as[$v]'><b class='text-success'>".($v+1)."  (".$all_group_as_score[$v].")</b></a></td>";
										}
										echo "<td style='width: 180px'><b>Total Grades (".$group_totalscore.")</b></td>";
									}
									else{
										echo "<td colspan='2'><i>No group assignment/s found.</i></td>";
									}

									$q_totalscore = 0;
									$q_allscore = array();
									foreach ($all_quiz_id as $quiz_id) {
										$getQuiz = $dbconn->query("SELECT * from quiz where quiz_id = '$quiz_id' ");
										$quiz = mysqli_fetch_array($getQuiz);
										$xscore = $quiz['total_grade'];
										$q_allscore[] = $xscore;
										$q_totalscore = $q_totalscore + $xscore;
									}
									if ($quiz_count != 0) {
										for($x = 0; $x < $quiz_count; $x++) {
											echo "<td style='vertical-align: middle'><a href='quiz.php?quiz_id=$all_quiz_id[$x]'><b class='text-success'>".($x+1)."  (".$q_allscore[$x].")</b></a></td>";
										}
										echo "<td style='width: 180px'><b>Total Grades (".$q_totalscore.")</b></td>";
									} else {
										echo "<td colspan='2'><i>No quiz/es found.</i></td>";
									}
									echo "</tr>";

							echo "<th>".$s_lastname.", ".$s_firstname."</th>";
							$sid = $s_id;
							
							$totalgrade = 0;

										//for individual assignments
										foreach ($all_ass_id as $key) {
											$get_ans = $dbconn->query("SELECT * from answer_assignment where assignment_id = '$key' and student_id = '$sid' ");
											$hasAns = false;
											$grade = 0;
											if (mysqli_num_rows($get_ans) != 0) {
												$hasAns = true;
												$ansrow = mysqli_fetch_array($get_ans);
												$grade = $ansrow['grade'];

												$graded = true;
												if ($grade == -1) {
													$grade = 0;
													$graded = false;
												}
												$totalgrade = $totalgrade + $grade;
											}

											if ($hasAns) {
												if($graded) {
													echo "<td style='text-align: center'><b>".$grade."<b></td>";
												} else {
													echo "<td style='text-align: center'><b>-</b></td>";
												}
											} else {
												echo "<td style='text-align: center'><b>-</b></td>";
											}
										}
										
										if ($assignment_count != 0) {
											echo "<td style='text-align: center'><b>".$totalgrade."</b></td>";
										} else {
											echo "<td style='text-align: center' colspan='2'><b>X</b></td>";
										}

										//for group assignments

										$totalGroupGrade = 0;
										foreach ($all_group_as as $keyGroupAss) {
											$getScore = "SELECT * from answer_group_assignment WHERE assignment_id = '$keyGroupAss' and student_id = '$sid'";
											$getScore_connect = mysqli_query($dbconn, $getScore);
											$hasGroupAns = false;
											$groupGrade = 0;
											if (mysqli_num_rows($getScore_connect)!=0) {
												$hasGroupAns = true;
												$groupAns = mysqli_fetch_array($getScore_connect);
												$groupGrade = $groupAns['grade'];
												$totalGroupGrade = $totalGroupGrade + $groupGrade;
											}
											if ($hasGroupAns) {
												echo "<td style='text-align: center'><b>".$groupGrade."<b></td>";
											}
											else{
												echo "<td style='text-align: center'><b>-</b></td>";
											}

										}
										// echo "<td style='text-align: center'><b>".$totalGroupGrade."</b></td>";

										if ($group_assignment_count != 0) {
											echo "<td style='text-align: center'><b>".$totalGroupGrade."</b></td>";
										} else {
											echo "<td style='text-align: center' colspan='2'><b>X</b></td>";
										}

										foreach ($all_quiz_id as $key) {
											$get_ans = $dbconn->query("SELECT * from answer_quiz where quiz_id = '$key' and student_id = '$sid' ");
											$hasAns = false;
											$grade = 0;
											if (mysqli_num_rows($get_ans) != 0) {
												$hasAns = true;
												$ansrow = mysqli_fetch_array($get_ans);
												$grade = $ansrow['total_grade'];

												$graded = true;
												if ($grade == -1) {
													$graded = false;
													$grade = 0;
												}
												$totalgrade = $totalgrade + $grade;
											}

											if ($hasAns) {
												if($graded) {
													echo "<td style='text-align: center'><b>".$grade."<b></td>";
												} else {
													echo "<td style='text-align: center'><b>-</b></td>";
												}
											} else {
												echo "<td style='text-align: center'><b>-</b></td>";
											}
										}
										if ($quiz_count != 0) {
											echo "<td style='text-align: center'><b>".$totalgrade."</b></td>";
										} else {
											echo "<td style='text-align: center' colspan='2'><b>X</b></td>";
										}
										echo "</tr>";
						?>
					</table>
				</div>
			</div>
			<br>
		</div>
		<br><br>
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
	<script src="js/quiz.js"></script>
</body>

</html>
