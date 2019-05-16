<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "";
	date_default_timezone_set("Asia/Manila");

	$id = $_GET['assignment_id'];

	$sql = "SELECT subject.subject_id, subject.subject_code, subject.course_title, subject.course_description, subject.course_about, subject.teacher_id, assignment.title, assignment.instruction, assignment.date_posted, assignment.deadline_date, assignment.deadline_time, assignment.score, assignment.file_id  from subject INNER JOIN assignment on (assignment.assignment_id = $id and subject.subject_id = assignment.subject_id)";

	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_id = $row['subject_id'];
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$assignment_title = $row['title'];
	$assignment_instruction = $row['instruction'];
	$deadline_date = $row['deadline_date'];
	$deadline_time = $row['deadline_time'];
	$date_posted = $row['date_posted'];
	$score = $row['score'];
	$file_id = $row['file_id'];

	$isFileEmpty = true;
	$fileName = "";
	if ($file_id != NULL) {
		$get_file_query = $dbconn->query("SELECT * from uploaded_files where file_id = '$file_id'");
		$frow = mysqli_fetch_array($get_file_query);

		$fileName = $frow['filename'];
		$isFileEmpty = false;
	}

	$combinedtime = date('Y-m-d H:i:s', strtotime("$deadline_date $deadline_time"));
	$xdate = new DateTime($combinedtime);
	$combinedtime = date_format($xdate, 'M d, Y - h:i A');

	$get_teacher = $dbconn->query("SELECT * from teacher where teacher_id = '$teacher_id';");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];

	if(isset($_POST['pass_grade'])) {
		$answer_id = $_POST['answer_id'];
		$grade = $_POST['grade'];

		$submit_grade = $dbconn->query("UPDATE answer_assignment set grade = '$grade' where id = '$answer_id' ");
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
			display: table;
			text-align: center;
			width: 25%;
			z-index: 1;
			top: 70px;
			right: 100px;
		}

		#wrapper div {
			display: table-cell;
		}

		#wrapper div b {
			font-size: 40px;
		}
	</style>


	<!-- https://stephanwagner.me/auto-resizing-textarea -->
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

	<div class="student-quiz-content">
		<div class="container">
			<div style='margin-left: 1px'>
			<?php
				$get_student_id = $dbconn->query("SELECT * from enrolls INNER JOIN answer_assignment where enrolls.subject_id = '$subject_id' and answer_assignment.assignment_id = '$id' and enrolls.student_id = answer_assignment.student_id ");
				
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
						echo "<br><br><br>";
						echo "<div class='row'>";

						$wasGraded = array();
						foreach ($sorted_ln as $sln) {
							$get_student = $dbconn->query("SELECT * from student where last_name = '$sln' ");
							$srow = mysqli_fetch_array($get_student);
							$fname = $srow['first_name'];
							$student_id = $srow['student_id'];

							$get_answer_query = $dbconn->query("SELECT * from answer_assignment where student_id = '$student_id' and assignment_id = '$id' ");

							$hasFile = false;
							$grade = 0;
						
							if (mysqli_num_rows($get_answer_query) != 0 ) {
								$arow = mysqli_fetch_array($get_answer_query);
								$answer_id = $arow['id'];
								$answer_content = $arow['content'];
								$answer_posted = $arow['date_posted'];
								$answer_file_id = $arow['file_id'];
								$grade = $arow['grade'];

								if ($answer_file_id != NULL) {
									$get_file = $dbconn->query("SELECT * from uploaded_files where file_id = '$answer_file_id' ");
									$frow = mysqli_fetch_array($get_file);
									$fileName = $frow['filename'];
									$hasFile = true;
								}

								if ($grade != NULL) {
									$wasGraded[] = $grade;
								}
							}

				?>		
						
							<div class="col-lg-4 border rounded">
								<div style="padding: 20px 5px 10px">
									<?php
										echo "<h5>".$sln.", ".$fname."</h5>";
										echo "<br>";
										echo "<h7>".$answer_content."</h7>";
										echo "<br><br>";
										echo "<h7>File: </h7>";
										if ($hasFile) {
											echo $fileName; ?>
											<a href='uploads/<?php echo $fileName ?>'>(<i class='fa fa-download'></i> Download)</a>
										<?php } else {
											echo "No uploaded file";
										}
										echo "<br><br>";
										echo "<b>Grade: ".$grade."</b>";

										echo "<br><br>";
										if (strtotime($answer_posted) > strtotime($xdate)) {
											echo "<strong class='text-danger'>Done Late.</strong>"
										}
									?>
										<br><br><br><br>
										<i>Maximum Score: <?php echo $score; ?></i>
										<form method="post">
											<input name="answer_id" value="<?php echo $answer_id; ?>" hidden>
											<div class="input-group mb-3">
			  									<input type="number" class="form-control" name="grade" placeholder="Input Grade"value="<?php echo $grade; ?>" max="<?php echo $score;?>">
			  									<div class="input-group-append">
			  										<span>&nbsp;</span>
			    									<button class="btn btn-success" name="pass_grade"><i class='fa fa-check'></i></button>
			  									</div>
											</div>
										</form>
										<i class="text-danger"><?php echo $error; ?></i>
								</div>
							</div>
				<?php
						}
					echo "</div>";
				?>
				<div id="wrapper">
					<div style="border-right: 2pt dashed;">
						<b><?php echo mysqli_num_rows($get_student_id); ?></b>
						<br>
						<i>Turned In</i>
					</div>
					<div style="border-right: 2pt dashed;">
						<b>
							<?php
								$num_student = $dbconn->query("SELECT * from enrolls where subject_id = '$subject_id' ");
								echo (mysqli_num_rows($num_student) - mysqli_num_rows($get_student_id));
							?>
						</b>
						<br>
						<i>Assigned</i>
					</div>
					<div>
						<b><?php echo sizeof($wasGraded); ?></b>
						<br>
						<i>Graded</i>
					</div>
				</div>

				<?php
				echo "</div>";
				} else {
					echo "<h4>No Student/s found.</h4";
				}
			?>
			</div>
			<br>
			<div style="margin-top:12px;">
				<?php 
					echo "<a href=assignment.php?assignment_id=",urlencode($id)," class='btn clever-btn'>Back</a>";
				?>
			</div>
			<br>
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
	<script src="js/expand.js"></script>
</body>

</html>