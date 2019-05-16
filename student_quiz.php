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

</head>

<body>
	<!-- Preloader -->
	<div id="preloader">
		<div class="spinner"></div>
	</div>

	<!-- ##### Header Area Start ##### -->
	<header class="header-area">

		<!-- Top Header Area -->
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
				<li class="breadcrumb-item"><a href="student_quiz.php">Quizzes</a></li>
			</ol>
		</nav>
	</div>
	<!-- ##### Breadcumb Area End ##### -->

	<!-- ##### Single Course Intro Start ##### -->
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

	<div class="student-quiz-content section-padding-100">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-12">
					<div class="section-heading">
						<h3>Quizzes</h3>
					</div>                   
					<div class="student-quiz">
						 <div class="accordions" id="accordion" role="tablist" aria-multiselectable="true">

												<!-- Single Accordian Area -->
							<div class="panel single-accordion">
								<h6>
									<a role="button" class="collapsed" aria-expanded="true" aria-controls="collapseOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">First Quiz
									<span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
									<span class="accor-close"><i class="fa fa-minus" aria-hidden="true"></i></span>
									</a>
								</h6>
								<div id="collapseOne" class="accordion-content collapse">
									<form>
											<div class="col-auto">
												<label class="sr-only" for="inlineFormInputGroup">Username</label>
												<div class="input-group col-6">
													<div class="input-group-prepend">
														<div class="input-group-text">Quiz one question number 1?</div>
													</div>
													<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="answer">
												</div>
											</div>
											<a href="#"><span class="text-success">Submit</span></a>
									</form>
								</div>
							</div>


							<div class="panel single-accordion">
								<h6>
									<a role="button" class="collapsed" aria-expanded="true" aria-controls="collapseTwo" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">Second Quiz
									<span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
									<span class="accor-close"><i class="fa fa-minus" aria-hidden="true"></i></span>
									</a>
								</h6>
								<div id="collapseTwo" class="accordion-content collapse">
									<form>
											<div class="col-auto">
												<label class="sr-only" for="inlineFormInputGroup">Username</label>
												<div class="input-group col-6">
													<div class="input-group-prepend">
														<div class="input-group-text">Quiz two question number 1?</div>
													</div>
													<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="answer">
												</div>
											</div>
											<a href="#" ><span class="text-success">Submit</span></a>
									</form>
								</div>
							</div>

							<div class="panel single-accordion">
								<h6>
									<a role="button" aria-expanded="true" aria-controls="collapseThree" class="collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseThree">Third Quiz
									<span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
									<span class="accor-close"><i class="fa fa-minus" aria-hidden="true"></i></span>
								</a>
								</h6>
								<div id="collapseThree" class="accordion-content collapse">
									<form>
											<div class="col-auto">
												<label class="sr-only" for="inlineFormInputGroup">Username</label>
												<div class="input-group col-6">
													<div class="input-group-prepend">
														<div class="input-group-text">Quiz three question number 1?</div>
													</div>
													<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="answer">
												</div>
											</div>
											<a href="#" ><span class="text-success">Submit</span></a>
									</form>
								</div>
							</div>
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
</body>

</html>