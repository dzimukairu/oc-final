<?php
	include('db_connection.php');
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "<br>";

	$username = $_SESSION['username'];
	$sql = $dbconn->query("SELECT * from student where username = '$username'");
	
	$srow = mysqli_fetch_array($sql);

	$id = $srow['student_id'];
	$s_username = $srow['username'];
	$s_firstname = $srow['first_name'];
	$s_lastname = $srow['last_name'];
	$s_password = $srow['password'];
	$image = $srow['image'];

	if(isset($_POST['updateImage'])) {
		$profileName = $s_username.'-'.$_FILES['profileImage']['name'];
		$target = 'img/stu-img/' . $profileName;

		if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target)) {
			$updatePhoto = $dbconn->query("UPDATE student set image = '$profileName' where username = '$s_username' ");

			if ($updatePhoto) {
				$message = "Image updated!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				header("Refresh:0");
			} else {
				$message = "Error!";
				echo "<script type='text/javascript'>alert('$message');</script>";
				header("Refresh:0");
			}
		}
	}

	if(isset($_POST['updatePassword'])) {
		$oldPass = $_POST['oldPass'];
		$newPass = $_POST['newPass'];

		if ($oldPass == $s_password) {
			$updatePass_query = $dbconn->query("UPDATE student set password = '$newPass' where student_id = '$id' ");
			
			if ($updatePass_query) {
				echo "<script type='text/javascript'>alert('Password updated!.');</script>";
				header("Refresh:0");
			}
		} else {
			echo "<script type='text/javascript'>alert('Old password is incorrect.');</script>";
		}
	}

	if(isset($_POST['updateName'])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];

		$updateName_query = $dbconn->query("UPDATE student set first_name = '$fname', last_name = '$lname' where student_id = '$id' ");

		if($updateName_query) {
			echo "<script type='text/javascript'>alert('Name updated!.');</script>";
			header("Refresh:0");
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

	<style>
		#updateImage {
			display: none;
		}

		#passwordDiv {
			display: none;
		}

		#nameDiv {
			display: none;
		}
	</style>

	<script>
		function triggerClick() {
			document.querySelector('#profileImage').click();
		}

		function displayImage(e) {
			if (e.files[0]) {
				var reader = new FileReader();

				reader.onload = function(e) {
					document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
				}
				reader.readAsDataURL(e.files[0]);
				document.querySelector('#updateImage').style.display = "block";
			}
		}

		function togglePassDiv() {
			var x = document.getElementById("passwordDiv");
			if (x.style.display === "block") {
				x.style.display = "none";
			} else {
				x.style.display = "block";
			} 
		}

		function toggleNameDiv() {
			var x = document.getElementById("nameDiv");
			if (x.style.display === "block") {
				x.style.display = "none";
			} else {
				x.style.display = "block";
			} 
		}

		function showPass() {
  		var x = document.getElementById("oldPass");
  		var y = document.getElementById("newPass");
  		if (x.type === "password") {
				x.type = "text";
				y.type = "text";
  		} else {
				x.type = "password";
				y.type = "password";
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
												echo "<a href=profile.php class='dropdown-item'>Profile</a>";
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
			<br>
			<div style="margin-left: 15%">
					<?php 
					echo "<a href=student_home.php class='btn clever-btn'>Go To Home</a>";
				?>
			</div>
			<br>
			<div class="row justify-content-center">
				<div class="col-md-8 border rounded" style="padding: 20px 20px">
					<div class="row justify-content-center" style="padding: 30px 12px">
						<div class="col-md-6">
							<div class="container" id="imgContainer">
								<form method="post" enctype="multipart/form-data">
									<div class="form-group text-center">
										<?php 
											echo "<img id='profileDisplay' style='border-radius: 50%; height: 300px; width: 300px; cursor: pointer;' src=img/stu-img/",urlencode($image)," onclick='triggerClick()' rel='tooltip' title='Click to change photo.'>" 
										?>
										<br><br>
										<label for="profileImage"><h5><b>Profile Image</b></h5></label>
										<br>
										<i>(Note: Click image to change it.)</i>
										<input type="file" name="profileImage" onchange="displayImage(this)" id="profileImage" style="display: none;" accept="image/*">
									</div>
									<button type="submit" name="updateImage" id="updateImage" class="btn btn-info btn-block">Update Image</button>
								</form>
							</div>
						</div>
					</div>
					<div class="row justify-content-center" style="padding-bottom: 12px" >
						<div class="col-md-6" id="previewDiv">
							<div style="display: block; vertical-align: middle">
								<h6 style="display: inline-block; margin-top: .5rem;">Name: <?php echo $s_firstname." ".$s_lastname; ?></h6> 
								<button class="btn btn-sm btn-outline-info pull-right" style="display: inline-block;" onclick="toggleNameDiv()">Edit</button>
							</div>

							<div style="margin-top: 10px" id="nameDiv">
								<i>Note: Names must start with capital letter.</i>
								<form method="POST">
									<div class="input-group" style="margin-bottom: 5px;">
										<div class="input-group-prepend">
											<div class="input-group-text">First Name: </div>
										</div>
										<input id="fname" required name="fname" class="form-control" pattern="([A-Z]{1}[a-z]*(\s)?)+$" value="<?php echo $s_firstname; ?>" placeholder="<?php echo $s_firstname; ?>">
									</div>
									<div class="input-group" style="margin-bottom: 5px;">
										<div class="input-group-prepend">
											<div class="input-group-text">Last Name: </div>
										</div>
										<input id="lname" required name="lname" class="form-control" pattern="([A-Z]{1}[a-z]*(\s)?)+$" value="<?php echo $s_lastname; ?>" placeholder="<?php echo $s_lastname; ?>">
									</div>
									<button class="btn btn-success" type="submit" name="updateName" style="display: block; margin: 0 auto; margin-top: 15px">Update Name</button>
								</form>
							</div>

							<hr>
							<h6>Username: <?php echo $s_username; ?></h6>
						</div>
					</div>

					<button class="btn clever-btn" style="display: block; margin: 0 auto" onclick="togglePassDiv()">Change Password</button>

					<div id="passwordDiv" style="width: 50%; margin-left: 25%; margin-top: 25px">
						<i>Note: Password must be atleast 8 of length with 1 number.</i>
						<form method="POST">
							<div class="input-group" style="margin-bottom: 5px;">
								<div class="input-group-prepend">
									<div class="input-group-text">Old Password: </div>
								</div>
								<input type="password" id="oldPass" required name="oldPass" class="form-control" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false">
							</div>
							<div class="input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">New Password: </div>
								</div>
								<input type="password" id="newPass" required name="newPass" class="form-control" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" pattern="(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]*).{8,}$">
							</div>

							<div>
								<label><input type="checkbox" onclick="showPass()"> Show Password</label>
							</div>
							<button class="btn btn-success" type="submit" name="updatePassword" style="display: block; margin: 0 auto">Update Password</button>
						</form>
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
	<script src="js/expand.js"></script>

	<script src="js/code.js"></script>
</body>

</html>

