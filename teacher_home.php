<?php
	require "db_connection.php";

	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$username = $_SESSION['username'];

	$get_teacher = $dbconn->query("SELECT * from teacher where username = '$username' ");
	$trow = mysqli_fetch_array($get_teacher);
	$id = $trow['teacher_id'];

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];

	echo("<script>console.log('PHP: ".$username."');</script>");
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
	<link rel="stylesheet" href="css/notification.css">

</head>
<!-- ; setTimeout('location.reload(true);', 5000) -->
<body onload="getSeenChat('<?php echo $username; ?>')">
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
							<div class="search-area">
								<form action="teacher_search.php" method="get">
									<input type="search" name="search" id="search" placeholder="Search">
									<button type="submit" name="find_subject"><i class="fa fa-search" aria-hidden="true"></i></button>
								</form>
							</div>
							<div class="login-state d-flex align-items-center">
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
	
	<section>
		<div class="container">
			<?php 
				echo "<a href=create_subject.php?teacher_id=",urlencode($id)," class='btn btn-primary clever-btn'>Create Subject</a>";
			?>

			<div class="free-space">
				<br/>
			</div>
			<div class="row">

				<?php 
					$subject_list_query= $dbconn->query("SELECT * FROM `subject` WHERE teacher_id = '$id'");
					$affected = mysqli_num_rows($subject_list_query);
							
					if ($affected != 0) {
						// $_SESSION['subject'] = array();
						while ($row = mysqli_fetch_array($subject_list_query)) {
					?>
							<div class="col-12 col-md-6 col-lg-4">
								<?php echo "<a href='teacher_course.php?subject_id=".$row['subject_id']."'>"; ?>
								<div class="single-student-subject mb-50 wow fadeInUp" data-wow-delay="250ms">
									<!-- <form method="post"> -->
									   <img src="img/bg-img/c1.jpg" alt="">
									<!-- Course Content -->
										<div class="course-content">
											<?php
												echo "<h4>".$row['course_title']."</h4>";
											?>
											<div class="meta d-flex align-items-center">
												<h7><b><?php echo $row['course_description']; ?></b></h7>
											</div>
										</div> 
									<!-- </form> -->
								</div>
							<?php echo "</a>"; ?>
							</div>
						<?php } ?>
					<?php } else {
						echo "<h4>No subjects found.</h4>";

					}?>
			</div>
		</div>
	</section>

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
	<!-- <script src="js/custom.js"></script> -->
	<script src="js/notif.js"></script>
</body>

</html>