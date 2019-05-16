<?php
	require "db_connection.php";

	session_start();
	if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$check_un = $dbconn->query("SELECT * from student where username = '$username' ");
		$check_stu = mysqli_num_rows($check_un);

		if ($check_stu == 1) {
			header("Location:student_home.php");
		} else {
			header("Location:teacher_home.php");
		}
	}

	$error = '';
	$error2 = '';
	$error3 = '';

	//for creating account
	if(isset($_POST['register']) ) {
		$first_name = ($_POST['first_name']);
		$last_name = ($_POST['last_name']);
		$username = ($_POST['username']);
		$email = ($_POST['email']);
		$pwd = ($_POST['pwd']);
		$retype_pwd = ($_POST['retype_pwd']);
		$user_type = ($_POST['user_type']);
		

		//checks if the input fields are empty
		if (empty($first_name)||empty($last_name)||empty($username)||
			empty($email)||empty($pwd)||empty($retype_pwd)||empty($user_type)) {
			$error2= 'Please fillup all the fields below.';
		} else if ($_POST['pwd']!=$_POST['retype_pwd']) {
			$error2= 'Password does not match';
		} else {
			$username_check = $dbconn->query("SELECT username from teacher, student where username = '$username'");
			$checknum = mysqli_num_rows($username_check);
			if ($checknum >= 1) {
				$error2 = 'Username exists, please input another username.';
			} else {
				if ($user_type === "teacher") {
					$input_teacher = $dbconn->query("INSERT INTO teacher(first_name, last_name, username, email_address, password, image) VALUES('$first_name', '$last_name', '$username', '$email', '$pwd', 'def.png');");
					if ($input_teacher) {
						$t_id = $row['teacher_id'];
						$_SESSION['username'] = $username;
						header("Location:teacher_home.php");
					}
				} else if ($user_type === "student") {
					$input_student = $dbconn->query("INSERT INTO student(first_name, last_name, username, email_address, password, image) VALUES('$first_name', '$last_name', '$username', '$email', '$pwd', 'def.png');");
					if ($input_student) {
						$s_id = $row['student_id'];
						$_SESSION['username'] = $username;
						header("Location:student_home.php");
					}
				}
			}
		}
	}
	//create account end


	//for login
	if(isset($_POST['login_form'])){
		$username_log = $_POST['username_log'];    
		$password_log = $_POST['password_log'];


		if((empty($username_log )) && (empty($password_log))){
			$error = 'Please enter your username and password.';
		} else if(empty($username_log )){
			$error = 'Please enter your username.';
		} else if(empty($password_log)){
			$error = 'Please enter your password.';
		} else {
			$teacher_query = "SELECT * FROM teacher WHERE username = '$username_log' and password = '$password_log'";

			$result = mysqli_query($dbconn, $teacher_query);
			$row = mysqli_fetch_array($result);

			$t_id = $row['teacher_id'];
		   
			if(mysqli_num_rows($result)) { 
				$_SESSION['username'] = $username_log;
				header("Location:teacher_home.php");
			} else {
				$student_query = "SELECT * FROM student WHERE username = '$username_log' and password = '$password_log'";

				$result = mysqli_query($dbconn, $student_query);
				$row = mysqli_fetch_array($result);

				$s_id = $row['student_id'];

				if(mysqli_num_rows($result)) { 
					$_SESSION['username'] = $username_log;
					header("Location:student_home.php");
				}
			}
			
			$error = 'NO ACCOUNT FOUND.';
		}
	}
	//login end
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
	<title>Online Classroom</title>

	<!-- Favicon -->
	<link rel="icon" href="img/core-img/favicon.ico">

	<!-- Stylesheet -->
	<link rel="stylesheet" href="style.css">

	<script>
		function showPass1() {
  			var x = document.getElementById("pwd");
  			var y = document.getElementById("retype_pwd")
  			if (x.type === "password" && y.type === "password") {
					x.type = "text";
					y.type = "text";
  			} else {
					x.type = "password";
					y.type = "password";
  			}
		}

		function showPass2() {
  			var x = document.getElementById("password_log");
  			if (x.type === "password") {
					x.type = "text";
  			} else {
					x.type = "password";
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
					<!-- Menu -->
					<div class="classy-menu">
						<!-- Close Button -->
						<div class="classycloseIcon">
							<div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
						</div>
					</div>
				</nav>
			</div>
		</div>
	</header>
	<!-- ##### Header Area End ##### -->

	<div id="forms" class="single-course-content" style="background-image: url(img/core-img/texture.png);">
		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-8"> 
					<div class="course--content">
						<div class="clever-tabs-content">
							<div class="tab-content" id="myTabContent">
								<!-- Tab Text -->
								<div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab--1">
									<div class="clever-description">
										<h7 class="text-danger"><?php echo $error2 ?></h7>
										<h7 class="text-success"><?php echo $error3 ?></h7>
										<br>

										<!-- About Course -->
										<div class="about-course mb-30">
											<h4>Create Account</h4>
											<form method="post" id="createAccountForm" name="createAccountForm">
												<div class="row">
													<div class="col-12 col-lg-6">
														<div class="form-group">
															<label for="first_name">First Name</label>
															<input type="text" class="form-control" name="first_name" id="first_name">
														</div>
														<span id="firstnameMsg" name="firstnameMsg">Status Message here</span>
													</div>
													<div class="col-12 col-lg-6">
														<div class="form-group">
															<label for="last_name">Last Name:</label>
															<input type="text" class="form-control" name="last_name" id="last_name">
														</div>
														<span id="lastnameMsg" name="lastnameMsg">Status Message here</span>
													</div>
												</div>
												<div class="row">
													<div class="col-12 col-lg-6">
														<div class="form-group">
															<label for="username">Username:</label>
															<input type="text" class="form-control" name="username" id="username" pattern="[a-zA-Z0-9]{6,}" title="Username must be 6 in length with no special characters.">
														</div>
														<span id="usernameMsg" name="usernameMsg"></span>
													</div>
													<div class="col-12 col-lg-6">
														<div class="form-group">
															<label for="email">Email Address:</label>
															<input type="email" class="form-control" name="email" id="email">
														</div>
														<span id="emailMsg" name="emailMsg">Status Message here</span>
													</div>
												</div>
												<div class="row">
													<div class="col-12 col-lg-6">
														<div class="form-group">
															<label for="pwd">Password:</label>
															<input type="password" class="form-control" name="pwd" id="pwd">
														</div>
														<span id="pwdMsg" name="pwdMsg">Status Message here</span>
													</div>
													<div class="col-12 col-lg-6">
														<div class="form-group">
															<label for="retype_pwd">Confirm Password:</label>
															<input type="password" class="form-control" name="retype_pwd" id="retype_pwd"  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false">
														</div>
														<span id="retype_pwdMsg" name="retype_pwdMsg">Status Message here</span>
													</div>
												</div>
												<div class="row form-group">
													<div class="col-12 col-lg-6">
														<label for="user_type">Register As:</label>
														<select name="user_type" id="user_type" class="form-control">
															<option value="teacher">Teacher</option>
															<option value="student">Student</option>
														</select>
													</div>
												</div>
												<div>
													<label><input type="checkbox" onclick="showPass1()"> Show Password</label>
												</div> 
												<br>
												<div class="col-12">
													<button class="btn clever-btn w-100" name="register">Create Account</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-12 col-lg-4">
					<h7 class="text-danger"><?php echo $error;?></h7>
					<br>
					<div class="course-sidebar">
						<div class="sidebar-widget">
							<h4>Login</h4>
							<form method="post">
								<div class="col-12 col-lg-12">
									<div class="form-group">
										<input type="text" class="form-control" id="username_log" placeholder="username" name="username_log">
									</div>
								</div>
								<div class="col-12 col-lg-12">
									<div class="form-group">
										<input type="password" class="form-control" id="password_log" placeholder="password" name="password_log" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false">
									</div>
								</div>
								<div class="col-12 col-lg-12">
									<label><input type="checkbox" onclick="showPass2()"> Show Password</label>
								</div> 
								<br>
								<div class="col-12">
									<button class="btn clever-btn w-100" name="login_form">Log In</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- ##### Footer Area Start ##### -->
	<footer class="footer-area" style="width: 100%; bottom: 0;">
		<!-- Top Footer Area -->
		<div class="top-footer-area">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- Footer Logo -->
						<!-- <div class="footer-logo">
							<a href="index.php"><img src="img/core-img/logo2.png" alt=""></a>
						</div> -->
						<!-- Copywrite -->
						<p>Created by | <a href="#" style="color: white">ALEGRO, ZARAH MAE</a> and <a href="#" style="color: white">PADASAS, JIM KYLE</a></p>
						<p><a href="#">
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							Copyright &copy; 2018 All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" style="color: white" target="_blank">Colorlib</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- ##### Footer Area End ##### -->

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
	<!-- Form validation -->
	<script src="js/index2.js"></script>
</body>

</html>