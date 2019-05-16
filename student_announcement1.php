<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 4 meta tags *Must* come first in the head; any other head content must come *after* these tags -->

	<!-- Title -->
	<title>Online Classroom| Announcement</title>

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
				<li class="breadcrumb-item"><a href="student_announcement.php">Announcements</a></li>
			</ol>
		</nav>
	</div>
	<!-- ##### Breadcumb Area End ##### -->

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

	<!-- ##### Regular Page Area Start ##### -->
	<div class="announcement-page-area section-padding-100">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section-heading">
						<h3>Announcements</h3>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="page-content">
						<div class="date">
								<p><i>Date Posted</i></p>
						</div>
						<p>Sed elementum lacus a risus luctus suscipit. Aenean sollicitudin sapien neque, in fermentum lorem dignissim a. Nullam eu mattis quam. Donec porttitor nunc a diam molestie blandit. Maecenas quis ultrices ex. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nullam eget vehicula lorem, vitae porta nisi. Ut vel quam erat. Ut vitae erat tincidunt, tristique mi ac, pharetra dolor. In et suscipit ex. Pellentesque aliquet velit tortor, eget placerat mi scelerisque a. Aliquam eu dui efficitur purus posuere viverra. Proin ut elit mollis, euismod diam et, fermentum enim.</p>
						<div class="col-6">
							<div class="form-group">
								<div class="col-auto">
									<div class="input-group mb-1">
										<div class="input-group-prepend">
											<div class="input-group-text">username</div>
										</div>
										<input type="text" class="form-control" id="inlineFormInputGroup" placeholder="comment">
										<button class="btn btn-info w-3">Post</button>
									</div>
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