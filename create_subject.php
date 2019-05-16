<?php
	include('db_connection.php');
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "<br>";

	$id = $_GET['teacher_id'];

	$get_teacher = $dbconn->query("SELECT * from teacher where teacher_id = '$id';");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];

	if(isset($_POST['add_subject']) ) {
		$subject_title= ($_POST['subject_title']);
		$subject_code = ($_POST['subject_code']);
		$subject_description= ($_POST['subject_description']);
		$subject_about= ($_POST['subject_about']);

		
		if (empty($subject_title)|empty($subject_description)|empty($subject_about)) {
			$error= 'Please fillup all the fields below.';
		}
		elseif(empty($subject_code)) {
			$error= 'Please generate the code.';
		}

		else{
			$query = $dbconn->query("INSERT into subject(subject_code, course_title, course_description, course_about, teacher_id) VALUES('$subject_code','$subject_title','$subject_description', '$subject_about', '$id')");
			
			if($query) {
				$last_id = $dbconn->insert_id;
				header("Location: teacher_course.php?subject_id=".$last_id);
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
	<title>Online Classroom | Home</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/expand.css">

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

						</div>
						<!-- Nav End -->
					</div>
				</nav>
			</div>
		</div>
	</header>
	<!-- ##### Header Area End ##### -->

	<!-- ##### List of Subjects ##### -->
	
	<div class="announcement-page-area" style="padding-bottom: 20px">
		<div class="container">
			<div class="col-12">
				<div class="section-heading">
					<h3>CREATE SUBJECT</h3>
				</div>
			</div>
			<div class="page-content">
				<h7 class="text text-danger"><?php echo $error;?></h7>
				<form method="POST">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1">Subject Title</span>
						</div>
						<input type="text" name="subject_title" class="form-control" placeholder="E.g CMSC 56" aria-label="Username" aria-describedby="basic-addon1">
					</div>

					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1">Subject Code</span>
						</div>
						<input type="text" name="subject_code" id="subject_code" class="form-control" placeholder="Press the Button" aria-label="subject_code" aria-describedby="basic-addon1" readonly="readonly">
						<input type="button" class="btn btn-default" value="Generate Code" id="genCode" name="genCode"/>
					</div>

					<div class="input-group mb-3">
						<div class="input-group-append">
							<span class="input-group-text" id="basic-addon2">Subject Description</span>
						</div>
						<input type="text" name="subject_description" class="form-control" placeholder="Discrete Mathematics" aria-label="Recipient's username" aria-describedby="basic-addon2">
					</div>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">About</span>
						</div>
						<textarea name="subject_about" class="form-control expand_this" data-autoresize aria-label="With textarea"></textarea>
					</div>
					<br/>
					<button name="add_subject" class="btn btn-success pull-right">Add Subject</button> 
					<br>
			   </form>
			</div>
			<br>
			<?php 
				echo "<a href=teacher_home.php?teacher_id=",urlencode($id)," class='btn clever-btn'>Back</a>";
			?> 
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
	<script src="js/expand.js"></script>

	<script src="js/code.js"></script>
</body>

</html>

