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

	$graded = 0;

	if(isset($_POST['update_assignment'])){
		$new_title = ($_POST['new_title']);
		$new_instruction = ($_POST['new_instruction']);
		$new_ddate = $_POST['new_ddate'];
		$new_dtime = $_POST['new_dtime'];

		$update_query = $dbconn->query("UPDATE assignment SET title = '$new_title', instruction = '$new_instruction', deadline_date = '$new_ddate', deadline_time = '$new_dtime' WHERE assignment_id = '$id'");

		if($_FILES['sent_file']['size'] != 0) {
			$target_dir = "uploads/";
			$ufileName = basename($_FILES["sent_file"]["name"]);
			$target_files = $target_dir . $ufileName;
			$fileType = pathinfo($target_files,PATHINFO_EXTENSION);

			if (move_uploaded_file($_FILES["sent_file"]["tmp_name"], $target_files)) {
				if ($isFileEmpty) {
					$insert_file_query = $dbconn->query("INSERT into uploaded_files(filename, date_posted) values ('".$ufileName."', NOW())");

					$file_id = $dbconn->insert_id;

					$Xquery = $dbconn->query("UPDATE assignment set file_id = '$file_id' where assignment_id = '$id'");
				} else {
					$insert_file_query = $dbconn->query("UPDATE uploaded_files set filename = '$ufileName' where file_id = '$file_id' ");
				}
			}
		}
		
		header("Location: assignment.php?assignment_id=".$id);
	}

	if(isset($_POST['pass_grade'])) {
		$assign_id = $_POST['assignment_id'];
		$numberOfGroup = $_POST['group_number'];
		$grade = $_POST['grade'];

		$submit_grade = $dbconn->query("UPDATE answer_group_assignment set grade = '$grade' where assignment_id = '$assign_id' AND group_number = '$numberOfGroup' ");

		if ($submit_grade) {
			$update_table = $dbconn->query("UPDATE graded_assignment set graded = 'true' where assignment_id = '$assign_id' and group_number = '$numberOfGroup' ");
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
	<script src="js/getdate.js"></script>

	<style type="text/css">
		#wrapper {
			position: absolute;
			float: right;
			display: table;
			text-align: center;
			width: 25%;
			z-index: 1;
			top: 640px;
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

	<!-- ##### Breadcumb Area Start ##### -->
	<!-- <div class="breadcumb-area">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="teacher_home.php">Home</a></li>
				<li class="breadcrumb-item"><a href="teacher_course.php">Courses</a></li>
			</ol>
		</nav>
	</div> -->
	<!-- ##### Breadcumb Area End ##### -->

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
				<div style="margin-bottom:12px;">
					<?php 
						echo "<a href=teacher_course.php?subject_id=",urlencode($subject_id)," class='btn clever-btn'>Back</a>";
					?>
				</div>
				<div class="col-12 col-lg-12 border rounded">
					<div id="clonedDiv">
					</div>
					<div style="padding: 20px 12px 50px 12px;">
					<!-- <?php echo $id; ?> -->
						<h5><?php echo $assignment_title;?></h5>
						<br>
						<h6><?php echo $assignment_instruction;?></h6>
						<h6>Total Points: <?php echo $score ?></h6>
						<br>
						<h6>Type: Group Assignment</h6>
						<h6>File:
							<?php
								if ($isFileEmpty == false) {
									echo $fileName;
									echo "&nbsp&nbsp";
									?> 
									<a href='uploads/<?php echo $fileName ?>'>(<i class='fa fa-download'></i> Download)</a>
									<?php
								} else {
									echo "No Uploaded File";
								}
							?>
						</h6>
						<br>
						<h6>Deadline: <?php echo $combinedtime ?></h6>
						<br>
						<p><?php 
							$xdate = new DateTime($date_posted);
							// $x = DateTime::createFromFromat('M d, Y', $xdate);
							$y = date_format($xdate, 'M d, Y - h:i A');
							echo $y;
						?></p>
											
						<button class="btn btn-success" onclick="show_hide()">View All Submissions</button>
						<button class="btn btn-info" data-toggle="modal" data-target="#update-assignment-modal">Update</button>
						<!-- <button class="btn btn-danger" onclick="deleteFunction(<?php echo $id;?>)">Delete</button> -->

						<script>
							function deleteFunction(id) {
								var del = confirm("Do you really want to delete this assignment?");

								if (del == true) {
									document.location.href = 'assignment_delete.php?id='+id;
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

							$number = 0;
							$noAnswer = " ";
							$hasFile = false;

							$getTotal = "SELECT * from assignment WHERE assignment_id = $id";
							$getTotal_connect = mysqli_query($dbconn, $getTotal);
							while ($assignment_points = mysqli_fetch_array($getTotal_connect)) {
								$max_score = $assignment_points['score'];
							}

							$getNumGroup = "SELECT MAX(group_number) from group_assignment WHERE assignment_id = '$id'";
							$getNumGroup_connect = mysqli_query($dbconn,$getNumGroup);
							while ($group_row = mysqli_fetch_array($getNumGroup_connect)) {
								$max_result = $group_row[0];
							}
									//echo "<script>alert('$max_result')</script>";
								for ($i=0; $i < $max_result ; $i++) { 
									$number = $i + 1;
									echo "<div class='col-lg-4 border rounded'>";
									echo "<div style='padding: 20px 5px 10px'>";
										echo "<h5>Group"." ".$number."</h5>";
									$new_query = "SELECT * from answer_group_assignment WHERE assignment_id = $id AND group_number = $number AND content <> '0' ORDER BY date_posted DESC LIMIT 1";
									$query_connect2 = mysqli_query($dbconn, $new_query);
									if (mysqli_num_rows($query_connect2) != 0) {
										while ($row3 = mysqli_fetch_array($query_connect2)) {
											$answer_content = $row3['content'];
											$grade = $row3['grade'];
											$student_number = $row3['student_id'];
											$answer_file_id = $row3['file_id'];
											$groupNum = $row3['group_number'];
											$answer_posted = $row3['date_posted'];

										}

										if ($answer_file_id != NULL) {
											$get_file = $dbconn->query("SELECT * from uploaded_files where file_id = '$answer_file_id' ");
											$frow = mysqli_fetch_array($get_file);
											$fileName = $frow['filename'];
											$hasFile = true;
										}
										if ($grade != NULL) {
										$graded = $graded + 1;
										}

										$getStudentName = "SELECT * from student WHERE student_id = $student_number";
										$getStudentName_connect = mysqli_query($dbconn, $getStudentName);
										if (mysqli_num_rows($getStudentName_connect)!=0) {
											while ($getLN = mysqli_fetch_array($getStudentName_connect)) {
												$sln = $getLN['last_name'];
											}
										}
										echo "<h6>Last Sender: ".$sln."</h6>";
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
										echo "<br>"; 

										if (strtotime($answer_posted) > strtotime("$deadline_date $deadline_time")) {
												//$doneLate++;
												echo "<strong class='text-danger'>Done Late.</strong>";
											}

										?>

										<br><br><br><br>
											<i>Maximum Score: <?php echo "<b>".$max_score."</b>"; ?></i>
											<form method="post">
												<input name="student_id" value="<?php echo $student_number; ?>" type="hidden">
												<input name="group_number" value="<?php echo $groupNum; ?>" type="hidden">
												<input name="assignment_id" value="<?php echo $id; ?>" type="hidden">
												<div class="input-group mb-3">
													<?php
														if($grade == '-1'){
															echo "<input type='number' class='form-control' name='grade' placeholder='Input Grade' max='".$max_score."'>";
														}
														else{
													 ?>
				  										<input type="number" class="form-control" name="grade" placeholder="Input Grade"value="<?php echo $grade; ?>" max="<?php echo $max_score;?>">
				  										<?php } ?>
				  									<div class="input-group-append">
				  										<span>&nbsp;</span>
				    									<button class="btn btn-success" name="pass_grade"><i class='fa fa-check'></i></button>
				  									</div>
												</div>
											</form>
											<i class="text-danger"><?php echo $error; ?></i>


					<?php				}
									else{
										echo "<h7>No Answers Yet.</h7>";
									}
											
										?>
											
									</div>
								</div>
					<?php
							}
							echo "</div>";
						echo "</div>";
					/*else {
						echo "<h4>No Answers found.</h4";
					}*/
				?>
				</div>
			</div>
		</div>
	</div>


	<!-- Update assignment Modal -->
	<div id="update-assignment-modal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="max-width: 80% !important;">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title pull-left">Update Assignment</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action="assignment.php?assignment_id=<?php echo $id?>" enctype="multipart/form-data">
						<div class="offset-md-2 col-8 input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">Title:</div>
								<textarea data-autoresize rows="1" cols="80" class="form-control expand_this" id="new_title" name="new_title"><?php echo $assignment_title ?></textarea>
							</div>
						</div>

						<br>

						<div class="offset-md-3 col-6 input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">Deadline:</div>
							</div>

							<?php
								$month = date('m');
								$day = date('d');
								$year = date('Y');
								$today_date = $year . '-' . $month . '-' . $day;
							?>

							<input type="date" name="new_ddate" id="new_ddate" value="<?php echo $today_date; ?>" min="2019-01-01" class="form-control">
							<input type="time" name="new_dtime" id="new_dtime" value="<?php echo date('H:i', time()+3600);?>" class="form-control">
						</div>
			
						<div class="offset-md-3 col-6">
							<p style="font-style: italic">Deadline time is set on <span style="font-weight: bold;"><?php echo $combinedtime ?></span>.</p>
						</div>
						<br><br>

						<div class="form-group offset-md-1 col-10">
							<label style="font-weight: bold">Instruction:</label>
							<textarea data-autoresize rows="2" class="form-control expand_this" id="new_instruction" name="new_instruction"><?php echo $assignment_instruction ?></textarea>

							<input type="file" name="sent_file" id="sent_file">
						</div>
						<br/>  
						<div class="pull-right">
							<button  class="btn btn-primary" name="update_assignment">Update</button>
							<button  class="btn btn-danger" data-dismiss="modal">Cancel</button> 
						</div>
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