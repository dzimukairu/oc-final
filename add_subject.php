<?php
	include('db_connection.php');
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "<br>";

	$username = $_SESSION['username'];

	$get_student = $dbconn->query("SELECT * from student where username = '$username';");
	$srow = mysqli_fetch_array($get_student);

	$student_id = $srow['student_id'];
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
	<title>Online Classroom | Home</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/expand.css">

	<!-- <script type="text/javascript">
		$(document).ready(function() {
			$("#find_subject").click(function() {
				$.ajax({
					type: "GET",
					url: "s_show_subject.php",
					dataType: "html",
					success: function(response){
						$("#subject-list").html(response);
					}
				});
			});
		});
	</script> -->

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
					<h3>ADD SUBJECT</h3>
				</div>
			</div>
			<div class="page-content">
				<h7 class="text text-danger"><?php echo $error;?></h7>
				<form method="GET">
					<div class="input-group mb-3">
						<input value="<?php echo $student_id ?>" name="student_id" hidden>
  						<input type="text" name="search" class="form-control" placeholder="Input Subject Code/Title">
  						<div class="input-group-append">
  							<span>&nbsp;</span>
  							<input type="reset" class="btn" value="X">
  							<span>&nbsp;</span>
    						<button  type="submit" class="btn btn-success" name="find_subject"><i class="fa fa-search"></i> Find</button>
  						</div>
					</div>
				</form>

				<div id="subject-list">
					<?php
						if (isset($_GET['find_subject'])) {
							$student_id = $_GET['student_id'];
							$search = $_GET['search'];

							$check_sub = $dbconn->query("SELECT * from subject where (subject_code = '$search') or (course_title like '%$search%')");
							$result = mysqli_num_rows($check_sub);

							if ($result == 0) {
								echo "No subjects found.";
							} else {

								$check = $dbconn->query("SELECT * from enrolls where student_id = '$student_id'");

								$all_enrolled_subjects = array();

								while ($sub = mysqli_fetch_array($check)) {
									$all_enrolled_subjects[] = $sub['subject_id'];
								}
					?>
								<table class="table">
									<tr>
										<th>Subject Code</th>
										<th>Subject Title</th>
										<th>Subject Description</th>
										<th>Teacher</th>
										<th>Status</th>
									</tr>
									<?php 
										while($row = mysqli_fetch_array($check_sub)) { 
											$teacher_id = $row['teacher_id'];
											$subject_id = $row['subject_id'];

											$get_teacher = $dbconn->query("SELECT * from teacher where teacher_id = '$teacher_id' ");
											$trow = mysqli_fetch_array($get_teacher);

											$t_username = $trow['username'];
											$t_firstname = $trow['first_name'];
											$t_lastname = $trow['last_name'];
									?>
									<tr>
										<td><?php echo $row['subject_code']; ?></td>
										<td><?php echo $row['course_title']; ?></td>
										<td><?php echo $row['course_description']; ?></td>
										<td><?php echo $t_firstname." ".$t_lastname; ?></td>
										<td>
											<?php 
												$get_status = $dbconn->query("SELECT * from enrolls where subject_id = $subject_id and student_id = '$student_id' ");
												$hasEnrolled = false;
												if (mysqli_num_rows($get_status) != 0) {
													$sta = mysqli_fetch_array($get_status);
													$status = $sta['status'];
													$hasEnrolled = true;
												} 

												if (in_array($subject_id, $all_enrolled_subjects) && $status == 'enrolled') {
													echo "<i>Enrolled</i>";
												} else if (in_array($subject_id, $all_enrolled_subjects) && $status == 'pending') {
													echo "<i>Pending</i>";
												} else {
											?>
											<button class="btn" onclick='addSubject("<?php echo $subject_id; ?>", "<?php echo $student_id; ?>", "<?php echo $row['course_title'];?>")'><i class="fa fa-plus"></i></button>
										<?php } ?>
										</td>

										<script>
											function addSubject(subject_id, student_id, name) {
												var add = confirm("Do you want to add "+ name +"?");

												if (add == true) {
													document.location.href = 'add_sub.php?subject_id='+subject_id+'&student_id='+student_id;
												}
											}
										</script>
									</tr>
								<?php } ?>
								</table>

								<?php
							}
						}
						
					?>
				</div>
			</div>
			<br>
			<?php 
				echo "<a href=student_home.php class='btn clever-btn'>Back</a>";
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

