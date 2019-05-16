<?php
	include("db_connection.php");
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "";
	date_default_timezone_set("Asia/Manila");

	$id = $_GET['subject_id'];
	$username = $_SESSION['username'];

	$sql = "SELECT subject_code, course_title, course_description, course_about from subject where subject_id = $id";
	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];

	$get_student = $dbconn->query("SELECT * from student where username = '$username';");
	$srow = mysqli_fetch_array($get_student);
	
	$s_id = $srow['student_id'];
	$s_username = $srow['username'];
	$s_firstname = $srow['first_name'];
	$s_lastname = $srow['last_name'];
	$image = $srow['image'];
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
	<title>Online Classroom | Course</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/notification.css">

	<style type="text/css">
		#chatDiv {
			display: none;
			box-shadow: 0 3px #ccc;
			position: fixed; 
			z-index: 3; 
			bottom: 0; 
			height: 350px; 
			width: 350px; 
			background-color: #E0E0E0;
			border-top-left-radius: 5%;  
			border-top-right-radius: 5%;
		}

		#chatBody {
			background: #eee;
			padding: 10px;
			width: 100%;
			overflow-x: hidden;
			overflow-y: scroll;
		}

		.chat {
			display: flex;
			flex-flow: row wrap;
			align-items: flex-start;
			width: 80%;
			padding: 5px 15px;
			margin-bottom: 15px;
			border-radius: 10px;
		}

		.chat p {
			color: #fff;
			display: block;
			width: 100%;
		}

		.chat .chat-message {
			margin-bottom: 5px;
		}

		.chat .date-posted {
			font-size: 12px;
			padding-left: 38%;
			margin-bottom: 0;
		}

		.friend {
			background: #1adda4;
		}

		.self {
			background: #1ddced;
			margin-left: 20%;
		}

		#chatEnd textarea {
			resize: none;
			color: #333;
			border-radius: 3px;
		}
	</style>

</head>

<body onload="updateChat('<?php echo $s_username; ?>', '<?php echo $id; ?>')">
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
								<div class="notificationIcons" style="margin-right: 20px">
									<div id="bellIcon" class="notification">
										<a data-toggle="dropdown" href="#">
											<i class="fa fa-bell fa-2x" aria-hidden="true"></i>
											<span class="badge" id="checkTask"></span>
										</a>
											<div class="dropdown-menu dropdown-menu-right" id="newTask" style="width: max-content; padding: 10px;">
											</div>
									</div>
								</div>
								<div id="notificationIcons" style="margin-right: 20px">
									<div id="messageIcon" class="notification">
										<a data-toggle="dropdown" href="#">
											<i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
											<span class="badge" id="checkMes"></span>
										</a>
											<div class="dropdown-menu dropdown-menu-right" id="newMessages" style="width: max-content; padding: 10px;">
												
											</div>
									</div>
								</div>
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

	<!-- ##### Courses Content Start ##### -->
	<div class="single-course-content section-padding-100">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-8">
					<div class="course--content">
						<div class="clever-tabs-content">
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="tab--1" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-selected="false">Main</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab--2" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2" aria-selected="true">Announcement</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab--3" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3" aria-selected="true">Assignment</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="tab--5" data-toggle="tab" href="#tab5" role="tab" aria-controls="tab5" aria-selected="true">Quiz</a>
								</li>   
								<li class="nav-item">
									<a class="nav-link" id="tab--4" data-toggle="tab" href="#tab4" role="tab" aria-controls="tab4" aria-selected="true">Members</a>
								</li>
							</ul>

							<div class="tab-content" id="myTabContent">
								<!-- Tab Text About Class-->
								<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
									<div class="clever-description">

										<!-- About Course -->
										<div class="about-course mb-30">
											<?php
												echo "<h5>Subject Code: ".$subject_code."</h5>";
												echo "<br>";
											?>
											<h6>Course About:</h6>
											<p style="margin-left: 30px;"><?php echo $course_about; ?></p>
										</div>

										<!-- All Learning Materials -->
										<button type="button" class="btn clever-btn mb-30" data-toggle="modal" data-target="#upload-modal" hidden>Add Learning Materials</button>

										<div class="all-instructors mb-30">
											<div style="margin-bottom: 25px;">
												<h4 class="d-inline">Learning Materials</h4>

												<?php
													$get_lecture_query = $dbconn->query("SELECT * from learning_materials where subject_id = '$id' group by title order by date_posted");
													$hasLM = false;

													if (mysqli_num_rows($get_lecture_query) == 0) {
														$hasLM = true;
													}
												?>
											</div>

											<div class="row">
												<div class="col-lg-12">
													<?php
														if ($hasLM) {
															echo "<h5>No Uploaded File/s.</h5>";
														} else {
															while ($row = mysqli_fetch_array($get_lecture_query)) {
																$f_title = $row['title'];

																echo "<div>";
																echo "<h6 style='margin-bottom: 0px; width: 100%' class='d-inline'>".$f_title."</h6>";

																$get_file_id = $dbconn->query("SELECT * from learning_materials where title = '$f_title' and subject_id = '$id' ");
																echo "<div style='margin-bottom: 5px;'>";
																while ($fileX = mysqli_fetch_array($get_file_id)) {
																	$f_id = $fileX['file_id'];
																	// echo $f_id;

																	$get_file = $dbconn->query("SELECT * from uploaded_files where file_id = '$f_id'");
																	$frow = mysqli_fetch_array($get_file);
																	$f_name = $frow['filename'];
													?>

																	<p style="margin: 0; margin-left: 15px;">
																		<?php echo $f_name; ?>
																		<a href='uploads/<?php echo $f_name ?>' target="_blank">(<i class='fa fa-download'></i> Download)</a>
																	</p>
													<?php
																} 
																echo "</div>";
																echo "</div>";
															}
														}
													?>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Tab Text Announcements -->
								<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab--2">
									<div class="clever-curriculum">
										<?php
											echo "<a href=teacher_announcement.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30' hidden><i class='fa fa-bullhorn'></i> Add Announcement</a>";
									  
											$subject_announcement_query= "SELECT * FROM `announcement` WHERE subject_id = $id order by date_posted desc";
											$connect_to_db = mysqli_query($dbconn,$subject_announcement_query);
											$affected = mysqli_num_rows($connect_to_db);
																									
											if ($affected != 0) {
												while ($row = mysqli_fetch_row($connect_to_db)) {

												$a_id = $row[0];
												echo "<a href=s_announcement.php?announcement_id=",urlencode($a_id),">";
													
										?>
														<div class="about-curriculum mb-30">
															<?php 
																echo "<h5>".$row[3]."</h5>";
																echo "<h7>".$row[4]."</h7>";

																$xdate = new DateTime($row[2]);
																$y = date_format($xdate, 'M d, Y - h:i A');
																echo "<br><br><br>";
																echo "<p>".$y."</p>";
															?>
														</div>
												<?php } ?>
											<?php } else {
												echo "<h4>No announcements found.</h4>";
											}?>
									</div>
								</div>


								<!-- Tab Text Assignments -->
								<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab--3">
									<div id="individual_part" class="clever-curriculum">
										<?php
											echo "<h3 class='text-info'>Individual Assignments</h3>";
											echo "<a href=teacher_assignment.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30' hidden>Add Assignment</a>";
											echo "<a href='#group_part'",urlencode($id)," class='btn btn-outline-secondary btn-sm'><i class='fa fa-tasks'></i>Go To Group Assignment</a>";
											echo "<br>";

											$subject_assignment_query= "SELECT * FROM `assignment` WHERE subject_id = $id AND assignment_type='individual' order by date_posted desc";
											$connect_to_db = mysqli_query($dbconn,$subject_assignment_query);
											$affected = mysqli_num_rows($connect_to_db);
																									
											if ($affected != 0) {
												while ($row = mysqli_fetch_row($connect_to_db)) {

												$a_id = $row[0];
												echo "<a href=s_assignment.php?assignment_id=",urlencode($a_id),">";
													
										?>
														<div class="about-curriculum mb-30">
															<?php 
																echo "<h5>".$row[5]."</h5>";
																echo "<h7>".$row[6]."</h7>";
																echo "<br>";
																echo "<br>";
																echo "<h7>Score: ".$row[7]."</h7>";
																echo "<br>";
																echo "<br>";

																$combinedtime = date('Y-m-d H:i:s', strtotime("$row[3] $row[4]"));
																$xdate = new DateTime($combinedtime);
																$combinedtime = date_format($xdate, 'M d, Y - h:i A');
																echo "<h7>Deadline: ".$combinedtime."</h7>";

																$xdate = new DateTime($row[2]);
																$y = date_format($xdate, 'M d, Y - h:i A');
																echo "<br><br><br>";
																echo "<p>".$y."</p>";
																
															?>
														</div>
												<?php } ?>
											<?php } else {
												echo "<h4>No Individual Assignment/s found.</h4>";
											} ?>
									</div>

									<div id="group_part" class="clever-curriculum">
										<?php
											echo "<br>";
											echo "<h3 class='text-info'>Group Assignments</h3>";
											echo "<a href='#individual_part'",urlencode($id)," class='btn btn-outline-secondary btn-sm'><i class='fa fa-tasks'></i>Go To Individual Assignment</a>";
											echo "<br>";
											

											$subject_assignment_query= "SELECT * FROM `assignment` WHERE subject_id = $id AND assignment_type='group' order by date_posted desc";
											$connect_to_db = mysqli_query($dbconn,$subject_assignment_query);
											$affected = mysqli_num_rows($connect_to_db);
																									
											if ($affected != 0) {
												while ($row = mysqli_fetch_row($connect_to_db)) {

												$a_id = $row[0];
												echo "<a href=sg_assignment.php?assignment_id=",urlencode($a_id),">";
													
										?>
														<div class="about-curriculum mb-30">
															<?php 
																echo "<h5>".$row[5]."</h5>";
																echo "<h7>".$row[6]."</h7>";
																echo "<br>";
																echo "<br>";
																echo "<h7>Score: ".$row[7]."</h7>";
																echo "<br>";
																echo "<br>";

																$combinedtime = date('Y-m-d H:i:s', strtotime("$row[3] $row[4]"));
																$xdate = new DateTime($combinedtime);
																$combinedtime = date_format($xdate, 'M d, Y - h:i A');
																echo "<h7>Deadline: ".$combinedtime."</h7>";

																$xdate = new DateTime($row[2]);
																$y = date_format($xdate, 'M d, Y - h:i A');
																echo "<br><br><br>";
																echo "<p>".$y."</p>";
																
															?>
														</div>
												<?php } ?>
											<?php } else {
												echo "<h4>No Group Assignment/s found.</h4>";
											} ?>
									</div>
								</div>

								<!-- Tab Text Students List -->
								<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab--4">
									<div class="clever-members">
										<?php
											echo "<a href=add_student.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30' hidden><i class='fa fa-user-plus'></i> Add Student</a>"; 
										?>

										<div class="all-instructors mb-30">
											<div class="row">
												<h6>Teacher</h6>
											</div>

											<?php
												$get_teacher_id_query = $dbconn->query("SELECT teacher_id from subject where subject_id = '$id' ");
												$row = mysqli_fetch_array($get_teacher_id_query);
												$teacher_id = $row['teacher_id'];

												$get_teacher_query = $dbconn->query("SELECT * from teacher where teacher_id = '$teacher_id' ");
												$teacher = mysqli_fetch_array($get_teacher_query);
												$username = $teacher['username'];
												$fn = $teacher['first_name'];
												$ln = $teacher['last_name'];
											?>

											<div class='row'>
												<div class="col-lg-offset-3 col-lg-6">
													<div class="single-instructor d-flex align-items-center mb-30">
														<div class="instructor-thumb">
															<?php 
																echo "<img id='profilePic' style='border-radius: 50%; height: 80px; width: 80px' src=img/tea-img/",urlencode($teacher['image']),">" 
															?>
														</div>
														<div class="instructor-info">
															<?php 
																echo "<h6>".$fn." ".$ln."</h6>";
															
															?>
															
															<button class="btn btn-info btn-xs">
																<a onclick="chat('<?php echo $username; ?>', '<?php echo $fn." ".$ln; ?>', '<?php echo $s_username; ?>', '<?php echo $id; ?>')"><i class="fa fa-comments-o"></i> Chat</a>
															</button>

														</div>
														<br>
													</div>
												</div>
											</div>

											<div class="row">
												<h6>Students List</h6>
											</div>

											<div class="row">
											<?php
												$get_student_id = $dbconn->query("SELECT student_id FROM enrolls WHERE subject_id = '$id' and status = 'enrolled' ");
												$affected = mysqli_num_rows($get_student_id);
																										
												if ($affected != 0) {
													$all_stu_id = array();
													while ($row = mysqli_fetch_array($get_student_id)) {
														$all_stu_id[] = $row['student_id'];
													}

													$all_lastname = array();
													foreach ($all_stu_id as $sid) {
														$get_lastname = $dbconn->query("SELECT * from student where student_id = '$sid' ");
														$ln = mysqli_fetch_array($get_lastname);
														$lastname = $ln['last_name'];
														$all_lastname[] = $lastname;
													}

													$sorted_ln = $all_lastname;
													sort($sorted_ln);

													foreach ($sorted_ln as $ln) {
														$get_student_query = $dbconn->query("SELECT * from student where last_name = '$ln'");

														$student = mysqli_fetch_array($get_student_query);
														$student_id = $student['student_id'];
														$username = $student['username'];
														$fn = $student['first_name'];
														$ln = $student['last_name'];
											?>
														<div class="col-lg-6">
															<div class="single-instructor d-flex align-items-center mb-30">
																<div class="instructor-thumb">
																	<?php 
																		echo "<img id='profilePic' style='border-radius: 50%; height: 80px; width: 80px' src=img/stu-img/",urlencode($student['image']),">" 
																	?>
																</div>
																<div class="instructor-info">
																	<?php 
																		echo "<h6>".$ln.", ".$fn."</h6>";

																		if ($student_id == $s_id) {
																			echo "<h7><i>(You)</i></h7>";
																		} else { ?>
																			<button class="btn btn-info btn-xs">
																				<a onclick="chat('<?php echo $username; ?>', '<?php echo $fn." ".$ln; ?>', '<?php echo $s_username; ?>', '<?php echo $id; ?>')"><i class="fa fa-comments-o"></i> Chat</a>
																			</button>
																		<?php }
																	?>
																</div>
															</div>
														</div>
												<?php }
												} ?>
											</div>
										</div>
									</div>
								</div>

								<!-- Tab Text Quizzes -->
								<div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab--5">
									<div class="clever-curriculum">
										<?php
											echo "<a href=teacher_quiz.php?subject_id=",urlencode($id)," class='btn clever-btn mb-30' hidden><i class='fa fa-file-text'></i> Add Quiz</a>";

											$subject_quiz_query = $dbconn->query("SELECT * FROM `quiz` WHERE subject_id = $id order by date_posted desc");
											$affected = mysqli_num_rows($subject_quiz_query);
																									
											if ($affected != 0) {
												while ($quiz = mysqli_fetch_array($subject_quiz_query)) {

												$q_id = $quiz['quiz_id'];
												echo "<a href=s_quiz.php?quiz_id=",urlencode($q_id),">";
													
										?>
														<div class="about-curriculum mb-30">
															<?php 
																echo "<h5>".$quiz['quiz_title']."</h5>";
																echo "<br>";
																echo "<h7>Score: ".$quiz['total_grade']."</h7>";
																echo "<br>";

																$time_limit = $quiz['time_limit'];
																$hr = intdiv($time_limit, 3600);
																$time_limit = $time_limit%3600;
																$min = intdiv($time_limit,60);
																$sec = $time_limit%60;

																if ($hr != 0) {
																	if ($hr == 1) {
																		if ($min <= 1) {
																			echo "<h7>Time Limit: ".$hr."hr, ".$min."min, ".$sec."secs</h7>";
																		} else {
																			echo "<h7>Time Limit: ".$hr."hr, ".$min."mins, ".$sec."secs</h7>";
																		}
																	} else {
																		echo "<h7>Time Limit: ".$hr."hrs, ".$min."mins, ".$sec."secs</h7>";
																	}
																} else if ($hr == 0 && $min != 0) {
																	if ($min == 1) {
																		echo "<h7>Time Limit: ".$min."min, ".$sec."secs</h7>";
																	} else {
																		echo "<h7>Time Limit: ".$min."mins, ".$sec."secs</h7>";
																	}
																} else {
																	echo "<h7>Time Limit: ".$sec."secs</h7>";
																}
																echo "<br>";

																$combinedtime = date('Y-m-d H:i:s', strtotime("$quiz[deadline_date] $quiz[deadline_time]"));
																$xdate = new DateTime($combinedtime);
																$combinedtime = date_format($xdate, 'M d, Y - h:i A');
																echo "<h7>Deadline: ".$combinedtime."</h7>";

																$xdate = new DateTime($row[2]);
																$y = date_format($xdate, 'M d, Y - h:i A');
																echo "<br><br><br>";
																echo "<p>".$y."</p>";
																
															?>
														</div>
												<?php  echo "</a>"; }  ?>
											<?php } else {
												echo "<h4>No quizzes found.</h4>";
											} ?>
									</div>
								</div>


							</div>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-4">
					<div class="course-sidebar">
						<?php 
							echo "<a href=s_classrecord.php?subject_id=",urlencode($id)," class='btn clever-btn w-100 mb-30'><i class='fa fa-table'></i> Your Grades</a>";
						?>

						<!-- Widget -->
						<div class="sidebar-widget">
							<h4>Submitted Works</h4>
							<ul class="features-list nav nav-tabs" style="border-bottom: 0px">
								<li style="width: 100%">
									<a id="tab--3" data-toggle="tab" href="#tab3" role="tab"><h6><i class="fa" aria-hidden="true"></i>Assignment</h6></a>
								</li>
								<li style="width: 100%">
									<a id="tab--5" data-toggle="tab" href="#tab5" role="tab"><h6><i class="fa" aria-hidden="true"></i>Quizzes</h6></a>
								</li>
							</ul>
						</div>

						<div id="chatDiv">
							<div id="chatHead" style="height: 10%;">
								<div class="pull-left" style="margin-left: 20px; margin-top: 8px">
									<b><span id="chatReceiver"></span></b>
									<input hidden id="chatUname">
									<input hidden id="chatName">
									<input hidden id="subId" value="<?php echo $id; ?>">
								</div>
								<div class="pull-right" style="margin-right: 15px; overflow: auto; margin-top: 2px">
									<a href="#" onclick="closeDiv()"><i class="fa fa-times fa-2x "></i></a>
								</div>
							</div>

							<div id="chatBody" style="height: 73%;">
							</div>

							<div id="chatEnd" style="height: 17%; margin: 2px;">
								<form id="chatForm">
									<div class="input-group">
											<input hidden id="sender" name="sender" value="<?php echo $s_username; ?>">
											<input hidden id="receiver" name="receiver" >
											<input hidden id="subject_id" name="subject_id" value="<?php echo $id; ?>" >
	  									<textarea rows="1" class="form-control" name="message" id="message" onfocus="stillChatting()" onclick="stillChatting()" autofocus></textarea>
	  									<div class="input-group-append">
	    									<button  class="btn btn-success" type="submit" onclick="return postChat()"><i class="fa fa-send"></i></button>
	  									</div>
									</div>
								</form>
							</div>
						</div>

						
					</div>
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

	<script src="js/s_chat.js"></script>
	<!-- <script src="js/custom.js"></script> -->
</body>

</html>