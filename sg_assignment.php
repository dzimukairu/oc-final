<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "";
	date_default_timezone_set("Asia/Manila");

	$id = $_GET['assignment_id'];
	//$type_a = $_POST['assignment_type'];
	$username = $_SESSION['username'];

	$date = date('Y-m-d H:i:s');

	$sql = "SELECT subject.subject_id, subject.subject_code, subject.course_title, subject.course_description, subject.course_about, subject.teacher_id, assignment.title, assignment.instruction, assignment.date_posted, assignment.deadline_date, assignment.deadline_time, assignment.score, assignment.file_id, assignment.assignment_type from subject INNER JOIN assignment on (assignment.assignment_id = $id and subject.subject_id = assignment.subject_id)";

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
	$assignment_type = $row['assignment_type'];

	//echo "<script> alert('$assignment_type'); </script>";



	$isFileEmpty = true;
	$fileName = "";
	if ($file_id != NULL) {
		$get_file_query = $dbconn->query("SELECT * from uploaded_files where file_id = '$file_id'");
		$frow = mysqli_fetch_array($get_file_query);

		$fileName = $frow['filename'];
		$isFileEmpty = false;
	}


	$first_time = date('Y-m-d H:i:s', strtotime("$deadline_date $deadline_time"));
	$xdate = new DateTime($first_time);
	$combinedtime = date_format($xdate, 'M d, Y - h:i A');

	$get_student = $dbconn->query("SELECT * from student where username = '$username';");
	$srow = mysqli_fetch_array($get_student);
	
	$s_id = $srow['student_id'];
	$s_username = $srow['username'];
	$s_firstname = $srow['first_name'];
	$s_lastname = $srow['last_name'];
	$image = $srow['image'];
	//echo "<script>alert('$s_id');</script>";

	$update_notif = "UPDATE group_assignment set opened = 'true' where assignment_id = $id and student_id = '$s_id'";
	$update_notif_connect = mysqli_query($dbconn,$update_notif);

	$get_group_query = "SELECT * from group_assignment where student_id = '$s_id' and assignment_id = '$id'";
	$get_group_connect = mysqli_query($dbconn, $get_group_query);

	if (mysqli_num_rows($get_group_connect) != 0) {
		$got_number = mysqli_fetch_array($get_group_connect);
		$group_num = $got_number['group_number'];
		//echo "<script>alert('$group_num');</script>";
	}

	
	
		$get_answer_query = "SELECT * from answer_group_assignment WHERE assignment_id = '$id' AND group_number = $group_num and content <> '0' ORDER BY date_posted DESC LIMIT 1";
		//echo "<script>alert('')</script>";
		$get_answer_connect = mysqli_query($dbconn, $get_answer_query);

		$haveAnswer = false;
		$grade = 0;

		
		if (mysqli_num_rows($get_answer_connect) != 0) {
			$a_row = mysqli_fetch_array($get_answer_connect);
			$answer_id = $a_row['id'];
			$content = $a_row['content'];
			// echo $content;
			$a_file_id = $a_row['file_id'];
			$grade = $a_row['grade'];
			$haveAnswer = true;

			$is_a_FileEmpty = true;
			//echo "<script>alert('$id')</script>";
			$a_fileName = "";
			if ($a_file_id != NULL) {
				$get_file_query = $dbconn->query("SELECT * from uploaded_files where file_id = '$a_file_id'");
				$frow = mysqli_fetch_array($get_file_query);

				$a_fileName = $frow['filename'];
				$is_a_FileEmpty = false;
			}

			echo "<script>
					var x = document.getElementById('answer_btn');
					x.style.display = 'none';
			</script>";
		}

		if (isset($_POST['pass_assignment'])) {
			$answer_content = $_POST['answer_content'];
			// $fileToUpload = $_POST['fileToUpload'];


			//echo "<script>alert('$answer_content')</script>";

			if($_FILES['fileToUpload']['size'] == 0) {
				echo "no file";
				$insert_query ="INSERT into answer_group_assignment(content, student_id, assignment_id, group_number) VALUES('$answer_content', '$s_id', '$id', '$group_num')";
				$insert_query_connect = mysqli_query($dbconn, $insert_query);

				
				if ($insert_query_connect) {
					header("Location: sg_assignment.php?assignment_id=".$id);
					//echo "<script>alert('ok')</script>";
				}
			} else {
				// echo "has file";
				
				$target_dir = "uploads/";
				$fileName = basename($_FILES["fileToUpload"]["name"]);
				$target_files = $target_dir . $fileName;
				$fileType = pathinfo($target_files,PATHINFO_EXTENSION);

				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_files)) {
					$insert_file_query = $dbconn->query("INSERT into uploaded_files(filename, date_posted) values ('".$fileName."', NOW())");
				}
				echo 1;
				if ($insert_file_query) {
					$file_id = $dbconn->insert_id;
					// echo $file_id;
					$query = $dbconn->query("INSERT into answer_group_assignment(content, date_posted, student_id, assignment_id, file_id, group_number) VALUES('$answer_content', NOW(), '$s_id', '$id', '$file_id', '$group_num')");
				
					if ($query) {
						header("Location: sg_assignment.php?assignment_id=".$id);
					}
				}
			}

			$getGroupmates = "SELECT * from group_assignment WHERE assignment_id = '$id' AND group_number = '$group_num'";
			$getGroupmates_connect = mysqli_query($dbconn, $getGroupmates);
			if(mysqli_num_rows($getGroupmates_connect) != 0){
				$allGroupmates = array(); 
				while ($groumates_id = mysqli_fetch_array($getGroupmates_connect)) {
					$allGroupmates[] = $groumates_id['student_id'];
				}

				foreach ($allGroupmates as $individual_ids) {
					if ($individual_ids != $s_id) {
						$insertOthers = "INSERT into answer_group_assignment(student_id, assignment_id, group_number) VALUES('$individual_ids' , $id, $group_num)";
						$insertOthers_connect = mysqli_query($dbconn,$insertOthers);
					}
					$graded_assignment ="INSERT into graded_assignment(assignment_id, subject_id, group_number, student_id) VALUES('$id', '$subject_id', '$group_num', '$individual_ids')";
					$graded_assignment_connect = mysqli_query($dbconn, $graded_assignment);
				}
			}
		}





	if (isset($_POST['update_assignment'])) {
		$new_answer_content = $_POST['new_answer_content'];
		$a_id = $_POST['a_id'];
		// $fileToUpdate = $_POST['fileToUpdate'];
		//echo "<script>alert('$id')</script>";

		if($_FILES['fileToUpdate']['size'] == 0) {
			$update_query = "UPDATE answer_group_assignment set content = '$new_answer_content', date_posted = NOW() where assignment_id = '$id' AND student_id = '$s_id'";
			$update_query_connect = mysqli_query($dbconn, $update_query);
			
			if ($update_query_connect) {
				header("Location: sg_assignment.php?assignment_id=".$id);
				//echo "<script>alert('ok')</script>";
			}
		} 

		else {
			$target_dir = "uploads/";
			$ufileName = basename($_FILES["fileToUpdate"]["name"]);
			$target_files = $target_dir . $ufileName;
			$fileType = pathinfo($target_files,PATHINFO_EXTENSION);

			if (move_uploaded_file($_FILES["fileToUpdate"]["tmp_name"], $target_files)) {
				$insert_file_query = $dbconn->query("UPDATE uploaded_files set filename = '$ufileName' where file_id = '$a_file_id' ");
			}

			if ($insert_file_query) {
				$file_id = $dbconn->insert_id;

				$query = $dbconn->query("UPDATE answer_group_assignment set content = '$new_answer_content', date_posted = NOW() where assignment_id = '$id' AND student_id = '$s_id'");
			
				if ($query) {
					header("Location: sg_assignment.php?assignment_id=".$id);
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
	<script src="js/getdate.js"></script>


	<!-- https://stephanwagner.me/auto-resizing-textarea -->
	<style>
		#answerDiv {
			display: none;
		}

		#updateDiv {
			display: none;
		}
	</style>
	<script>
		function show_hide() {
			var x = document.getElementById("answerDiv");
			if (x.style.display === "block") {
				x.style.display = "none";
			} else {
				x.style.display = "block";
			} 
		}

		function show_hide_update() {
			var x = document.getElementById("updateDiv");
			if (x.style.display === "block") {
				x.style.display = "none";
			} else {
				x.style.display = "block";
			} 
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

	<div class="student-quiz-content section-padding-100">
		<div class="container">
			<div class="row" style="margin-top:20px">
				<?php 
					echo "<a href=student_course.php?subject_id=",urlencode($subject_id)," class='btn clever-btn'>Back</a>";
				?>
			</div>
			<br>
			<br>
			<div class="row">
				<div class="col-12 col-lg-12 border rounded">
					<div style="padding: 20px 12px 60px 12px;">
						<h5><?php echo $assignment_title;?></h5>
						<br>
						<h6><?php echo $assignment_instruction;?></h6>
						<h6>Total Points: <?php echo $score ?></h6>
						<br>
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
						<p>
							<?php 
								$xdate = new DateTime($date_posted);
								$y = date_format($xdate, 'M d, Y - h:i A');
								echo $y;
							?>
						</p>
						<h6>Group Members:</h6>

						<?php

							$mymembers = array();
							$getMembers = "SELECT * from group_assignment WHERE assignment_id = $id AND group_number = $group_num";
							$getMembers_connect = mysqli_query($dbconn,$getMembers);
							while ($getMembers_row = mysqli_fetch_array($getMembers_connect)) {
								$mymembers[] = $getMembers_row['student_id'];
							}
							echo "<div style='margin-left: 40px'>";
							foreach ($mymembers as $membersID) {
								$getNames = "SELECT * from student WHERE student_id = '$membersID'";
								$getNames_connect = mysqli_query($dbconn, $getNames);
								while ($membersData = mysqli_fetch_array($getNames_connect)) {
									$mem_firstName = $membersData['first_name'];
									$mem_lastName = $membersData['last_name'];
									echo $mem_firstName." ".$mem_lastName."<br>";
								}
							}
							echo "</div>";
							echo "<br>";
							if (!$haveAnswer) {
								echo "<button id='answer_btn' class='btn btn-primary clever-btn pull-right' onclick='show_hide()'>Answer</button>";
							}
						?>
						
							
					</div>
				</div>

				<div class="col-12 col-lg-12 border rounded" style="padding-top: 20px; padding-bottom: 20px">
					<div style="padding-left: 80px; padding-right: 80px;">
						<h6>Your Group's Work:</h6>
						<div>
							<?php
								if ($haveAnswer) {
									echo "<p>".$content."</p>";
									if ($is_a_FileEmpty == false) {
										echo "File: ".$a_fileName;
										echo "&nbsp&nbsp";
										?> 
										<a href='uploads/<?php echo $a_fileName ?>'>(<i class='fa fa-download'></i> Download)</a>
										<?php
									} else {
										echo "File: <i>No submitted file.</i>";
									}
								} 

								else {
									echo "<i class='text-danger'>No submitted answer.</i>";
								}
							?>

							<br><br>
							<h7>Your Grade:
								<?php
									echo "<b>".$grade."/".$score."</b>";
								?>
							</h7>
						</div>
						<?php 
							if ($haveAnswer) { ?>
								<button class='btn btn-info pull-right' onclick='show_hide_update()'>Update</button>
							<?php
							}
						?>
					</div>
				</div>
			</div>

			<div class="row" style="margin-top:20px" id="answerDiv" name="answerDiv">
				<div class="col-12 col-lg-12 border rounded" style="padding-top: 20px; padding-bottom: 70px">
					<div style="padding-left: 80px; padding-right: 80px;">
						<h6>Your Group's Answer:</h6>

						<div>
							<form method="POST" enctype="multipart/form-data">
								<textarea data-autoresize rows="1" cols="80" class="form-control expand_this" id="answer_content" name="answer_content"></textarea>
								<input type="file" name="fileToUpload">

								<br><br>
								<input type="submit" class="btn btn-success pull-right" name="pass_assignment" value="SUBMIT"/>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="row" style="margin-top:20px" id="updateDiv" name="updateDiv">
				<div class="col-12 col-lg-12 border rounded" style="padding-top: 20px; padding-bottom: 70px">
					<div style="padding-left: 80px; padding-right: 80px;">
						<h6>Update Your Answer:</h6>

						<div>
							<form method="POST" enctype="multipart/form-data">
								<input type="text" value="<?php echo $answer_id; ?>" name="a_id" hidden>
								<input type="hidden" name="update_file_id" value="<?php echo $a_file_id ?>">
								<textarea data-autoresize rows="1" cols="80" class="form-control expand_this" id="new_answer_content" name="new_answer_content"><?php echo $content;?></textarea>
								<input type="file" name="fileToUpdate">

								<br><br>
								<input type="submit" class="btn btn-success pull-right" name="update_assignment" value="UPDATE"/>
							</form>
						</div>
					</div>
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
	<script src="js/expand.js"></script>
</body>

</html>