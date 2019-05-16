<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 4 meta tags *Must* come first in the head; any other head content must come *after* these tags -->

	<!-- Title -->
	<title>Online Classroom | Assiggnment</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">

</head>

<body>
	<!-- Preloader -->
	<div id="preloader">
		<div class="spinner"></div>
	</div>

	<!-- ##### Header Area Start ##### -->
	<header class="header-area">

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
							<ul>
								<li><a href="student_course.php">About</a></li>
								<li><a href="#">To-do</a>
									<ul class="dropdown">
										<li><a href="student_quiz.php">Quizzes</a></li>
										<li><a href="student_assignment.php">Assignments</a></li>
									</ul>
								</li>
								<li><a href="student_announcement.php">Announcements</a></li>
							</ul>
								<div class="login-state d-flex align-items-center">
									<div class="user-name mr-30">
										<div class="dropdown">
											<a class="dropdown-toggle" href="#" role="button" id="userName" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Username</a>
											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userName">
												<a class="dropdown-item" href="student_home.php">Home</a>
												<a class="dropdown-item" href="#">Profile</a>
												<a class="dropdown-item" href="index.php">Logout</a>
											</div>
										</div>
									</div>
									<div class="userthumb">
										<img src="img/bg-img/t1.png" alt="">
									</div>
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
	<div class="breadcumb-area">
		<!-- Breadcumb -->
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="student_home.php">Home</a></li>
				<li class="breadcrumb-item"><a href="student_course.php">Course</a></li>
				<li class="breadcrumb-item"><a href="student_assignment.php">Assignments</a></li>
			</ol>
		</nav>
	</div>
	<!-- ##### Breadcumb Area End ##### -->

	<!-- ##### Hero Area Start ##### -->
	<section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(img/bg-img/bg1.jpg);">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-12">
					<!-- Hero Content -->
					<div class="hero-content text-center">
						<!-- ##### Example: Management System ##### -->
						<h2>Course Description</h2>
						<!-- ##### Example: CMSC 152 ##### -->
						<h3>Course Title</h3>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<section class="best-tutors-area section-padding-100">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-heading">
						<h3>Assignments</h3>
					</div>

			<div class="row">
				<div class="col-12 col-md-6 col-lg-4">
					<div class="single-learning-materials mb-50 wow fadeInUp" data-wow-delay="250ms">
						<!-- Events Thumb -->
						<div class="events-thumb">
							<img src="img/document.png" alt="">
							<h6 class="lecture-number">Assignment 1</h6>
							<h4 class="lecture-title">Assignment No.1 Title</h4>
						</div>
						<!-- Date & Fee -->
						<div class="open-save d-flex justify-content-between">
							<div class="extra-space">
								<span></span>
							</div>
							<div class="save-btn">
								<a href="#" class="free" data-toggle="modal" data-target="#quiz-modal-id">Open</a>
								<a href="#">Save</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-4">
					<div class="single-learning-materials mb-50 wow fadeInUp" data-wow-delay="500ms">
						<!-- Events Thumb -->
						<div class="events-thumb">
							<img src="img/document.png" alt="">
							<h6 class="lecture-number">Assignment 2</h6>
							<h4 class="lecture-title">Assignment No.2 Title</h4>
						</div>
						<!-- Date & Fee -->
						<div class="open-save d-flex justify-content-between">
							<div class="extra-space">
								<span></span>
							</div>
							<div class="save-btn">
								<a href="#" class="free" data-toggle="modal" data-target="#quiz-modal-id">Open</a>
								<a href="#">Save</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-4">
					<div class="single-learning-materials mb-50 wow fadeInUp" data-wow-delay="750ms">
						<!-- Events Thumb -->
						<div class="events-thumb">
							<img src="img/document.png" alt="">
							<h6 class="lecture-number">Assignment 3</h6>
							<h4 class="lecture-title">Assignment No.3 Title</h4>
						</div>
						<!-- Date & Fee -->
						<div class="open-save d-flex justify-content-between">
							<div class="extra-space">
								<span></span>
							</div>
							<div class="save-btn">
								<a href="#" class="free" data-toggle="modal" data-target="#quiz-modal-id">Open</a>
								<a href="#">Save</a>
							</div>
						</div>
					</div>
					<div id="quiz-modal-id" class="modal fade" role="dialog">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<h4 class="modal-title pull-left">Assignment Number</h4>
								</div>
								<div class="modal-body">
									<h6>Assignment instructions the teacher has set</h6>
									<form action="post">
										<input type="file"/>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-info" data-dismiss="modal">Submit</button>
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>

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
</body>

</html>