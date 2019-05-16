<?php
	include('db_connection.php');
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "<br>";

	$id = $_GET['subject_id'];
	$sql = "SELECT subject_code, course_title, course_description, course_about, teacher_id from subject where subject_id = '$id'";
	
	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	// $subject_code = $row['subject_code']; 
	// $course_title = $row['course_title'];
	// $course_description = $row['course_description'];
	// $course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$get_teacher = $dbconn->query("SELECT * from teacher where teacher_id = '$teacher_id';");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];
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
					<h3>ADD STUDENT</h3>
				</div>
			</div>
			<?php 
				echo "<a href=teacher_course.php?subject_id=",urlencode($id)," class='btn clever-btn'>Back</a>";
			?> 
			<div>
				<br>
			</div>
			<div class="page-content">
				<h7 class="text text-danger"><?php echo $error;?></h7>
				<form method="GET">
					<div class="input-group mb-3">
						<input value="<?php echo $id ?>" name="subject_id" hidden>
  						<input type="text" name="search" class="form-control" placeholder="Student Name/Username">
  						<div class="input-group-append">
  							<span>&nbsp;</span>
  							<input type="reset" class="btn" value="X">
  							<span>&nbsp;</span>
    						<button  type="submit" class="btn btn-success" name="find_student"><i class="fa fa-search"></i> Find</button>
  						</div>
					</div>
				</form>

				<div id="student-list">
					<?php
						if (isset($_GET['find_student'])) {
							$subject_id = $_GET['subject_id'];
							$search = $_GET['search'];

							$check_stu = $dbconn->query("SELECT * from student where (username = '$search') or (first_name like '%$search%') or (last_name like '%$search%')");
							$result = mysqli_num_rows($check_stu);

							if ($result == 0) {
								echo "No student/s found named <b>".$search."</b>.";
							} else {
					?>
								<table class="table" style="text-align: center;">
									<tr>
										<th>Image</th>
										<th>Name</th>
										<th>Action</th>
									</tr>
									<?php 
										$all_enrolled = array();
										while ($irow = mysqli_fetch_array($check_stu)) {
											$all_enrolled[] = $irow['student_id'];
										}

										$all_lastname = array();
										foreach ($all_enrolled as $sid) {
											$get_lastname = $dbconn->query("SELECT * from student where student_id = '$sid' ");
											$ln = mysqli_fetch_array($get_lastname);
											$lastname = $ln['last_name'];
											$all_lastname[] = $lastname;
										}
										
										$sorted_ln = $all_lastname;
										sort($sorted_ln);

										foreach ($sorted_ln as $sln) {
											$getStudent = $dbconn->query("SELECT * from student where last_name = '$sln' ");
											$row = mysqli_fetch_array($getStudent);
											$student_id = $row['student_id'];

											$check = $dbconn->query("SELECT subject_id from enrolls where student_id = '$student_id'");

											$all_enrolled_subjects = array();

											while ($sub = mysqli_fetch_array($check)) {
												$all_enrolled_subjects[] = $sub['subject_id'];
											}
									?>
									<tr>
										<td>
											<?php 
												echo "<img id='profilePic' style='border-radius: 50%; height: 50px; width: 50px' src=img/stu-img/",urlencode($row['image']),">" 
											?>
										</td>
										<td style="vertical-align: middle"><b><?php echo $row['last_name'].", ".$row['first_name']; ?></b></td>
										<td style="vertical-align: middle">
											<?php 
												if (in_array($subject_id, $all_enrolled_subjects)) {
													echo "Enrolled";
												} else {
											?>
											<button class="btn" onclick='addStudent("<?php echo $subject_id; ?>", "<?php echo $student_id; ?>", "<?php echo $row['first_name']." ".$row['last_name']?>")'><i class="fa fa-plus"></i></button>
										<?php } ?>
										</td>

										<script>
											function addStudent(subject_id, student_id, name) {
												var add = confirm("Do you want to add " + name + "?");

												if (add == true) {
													document.location.href = 'add_stu.php?subject_id='+subject_id+'&student_id='+student_id;
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

