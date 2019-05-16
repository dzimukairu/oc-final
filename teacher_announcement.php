<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$id = $_GET['subject_id'];
	$error = '';
	$studentId = array();
	date_default_timezone_set("Asia/Manila");

	$sql = "SELECT subject_code, course_title, course_description, course_about, teacher_id from subject where subject_id = $id";

	$getStudents = $dbconn->query("SELECT * from enrolls where subject_id = '$id'");
	$test = mysqli_num_rows($getStudents);
	if (mysqli_num_rows($getStudents) != 0) {
		while ($studentData = mysqli_fetch_array($getStudents)) {
			$studentId[] = $studentData['student_id'];
		}
		//echo "<script>alert('$studentId[6]')</script>";
	}
	
	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$get_teacher = $dbconn->query("SELECT * from teacher where teacher_id = '$teacher_id';");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];

	if(isset($_POST['add_announcement'])) {
		$id = $_GET['subject_id'];
		$announcement_title = $_POST['announcement_title'];
		$announcement_content = $_POST['announcement_content'];

		if (empty($announcement_title) && empty($announcement_content)) {
			$error = 'Please input title and content.';
		} else if (empty($announcement_title)) {
			$error = 'Please input title.';
		} else if (empty($announcement_content)) {
			$error = 'Please input content.';
		} else {
			$query = $dbconn->query("INSERT into announcement(subject_id, date_posted, title, content) VALUES('$id', NOW(), '$announcement_title', '$announcement_content')");
	
			if ($query) {
				//$lastId = 0;
				$getLastId = $dbconn->query("SELECT MAX(announcement_id) from announcement where subject_id = '$id'");
				//$test = mysqli_num_rows($getLastId);
				if (mysqli_num_rows($getLastId)!= 0) {
					while ($announcementData = mysqli_fetch_array($getLastId)) {
						$lastId = $announcementData[0];
					}
					// echo "<script>alert('$test')</script>";
				}
				echo "<script>alert('$test')</script>";
				foreach ($studentId as $indivId) {
					$insertToDb = $dbconn->query("INSERT into see_announcement(announcement_id, subject_id, student_id, opened) VALUES('$lastId', '$id' , '$indivId', 'false')");
				}
				header("Location: teacher_course.php?subject_id=".$id);
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
						<?php
							$id = $_GET['subject_id'];
							$sql = "SELECT subject_code, course_title, course_description, course_about from subject where subject_id = $id";

							$result = mysqli_query($dbconn, $sql);
							$row = mysqli_fetch_array($result);
							
							$subject_code = $row['subject_code']; 
							$course_title = $row['course_title'];
							$course_description = $row['course_description'];
							$course_about = $row['course_about'];
					   
						?>
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
						<h3>Create New Announcement</h3>
					</div>        
			   </div>
			</div>
			<div class="row">
				<h7 class="text-danger"><?php echo $error ?></h7>
				
				<div class="col-12 col-lg-12 border rounded">
					<div style="padding: 20px 12px 50px 12px;">
						<form method="post" action="teacher_announcement.php?subject_id=<?php echo $id ?>">
							<div class="offset-md-2 col-md-8 input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Title:</div>
								</div>
								<!-- <input data-autoresize type="text" class="form-control expand_this" id="announcement_title" name="announcement_title"> -->
								<textarea data-autoresize rows="1" class="form-control expand_this" id="announcement_title" name="announcement_title"></textarea>
							</div>
							<br>

							<div class="offset-md-1 col-md-10 input-group">
								<div class="input-group row">
									<div class="input-group-prepend">
										<span class="input-group-text">Content:</span>
									</div>
									<textarea data-autoresize rows="2" class="form-control expand_this" id="announcement_content" name="announcement_content"></textarea>
								</div>
							</div>

							<input type="submit" class="btn btn-success pull-right" name="add_announcement" value="SUBMIT"/>
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
	<script src="js/expand.js"></script>
</body>

</html>