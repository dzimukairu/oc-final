<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}

	$error = "<br>";
	date_default_timezone_set("Asia/Manila");

	$id = $_GET['announcement_id'];

	$sql = "SELECT subject.subject_id, subject.subject_code, subject.course_title, subject.course_description, subject.course_about, subject.teacher_id, announcement.title, announcement.content, announcement.date_posted  from subject INNER JOIN announcement on (announcement.announcement_id = $id and subject.subject_id = announcement.subject_id)";

	$result = mysqli_query($dbconn, $sql);
	$row = mysqli_fetch_array($result);
							
	$subject_id = $row['subject_id'];
	$subject_code = $row['subject_code']; 
	$course_title = $row['course_title'];
	$course_description = $row['course_description'];
	$course_about = $row['course_about'];
	$teacher_id = $row['teacher_id'];

	$announcement_title = $row['title'];
	$announcement_content = $row['content'];
	$date_posted = $row['date_posted'];

	$get_teacher = $dbconn->query("SELECT * from teacher where teacher_id = '$teacher_id';");
	$trow = mysqli_fetch_array($get_teacher);

	$t_username = $trow['username'];
	$t_firstname = $trow['first_name'];
	$t_lastname = $trow['last_name'];
	$image = $trow['image'];

	if(isset($_POST['update_announcement'])){
		$new_title = ($_POST['new_title']);
		$new_content = ($_POST['new_content']);

		$update_query = "UPDATE announcement SET title = '$new_title', content = '$new_content' WHERE announcement_id = '$id'";
		if ($update_connect = mysqli_query($dbconn, $update_query)) {
			header("Location: announcement.php?announcement_id=".$id);
		}
	}

	if(isset($_POST['add_comment'])){
		$content = $_POST['tcomment'];
		$t_uname = $_POST['t_uname'];

		$add_comment_query = "INSERT into announcement_comment(announcement_id, username, content, date_posted) values('$id', '$t_uname', '$content', NOW())";
		if ($add_comment_connect = mysqli_query($dbconn, $add_comment_query)) {
			header("Location: announcement.php?announcement_id=".$id);
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

	<script>
		function getComment(announcement_id) {
			setInterval(function() {
				xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("commentDiv").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("GET", "getComment.php?a_id=" + announcement_id, true);
				xmlhttp.send();
			}, 1000);
		}
	</script>


	<!-- https://stephanwagner.me/auto-resizing-textarea -->
	<style>
		table {
			border-collapse: collapse;
		}
		tr td {
			padding: 0 !important; 
			margin: 0 !important;
		}
	</style>
</head>

<body onload="getComment('<?php echo $id;?>')">
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

	<!-- ##### Single Course Intro Start ##### -->
   <section class="hero-area bg-img bg-overlay-2by5" style="background-image: url(img/bg-img/bg1.jpg);">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-12">
					<!-- Hero Content -->
					<div class="hero-content text-center">
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
			<div style="margin-bottom:12px;">
				<?php 
					echo "<a href=teacher_course.php?subject_id=",urlencode($subject_id)," class='btn clever-btn'>Back</a>";
				?>
			</div>
			<div class="row">
				<div class="col-12 col-lg-12 border rounded">
					<div style="padding: 20px 12px 50px 12px;">
					<!-- <?php echo $id; ?> -->
						<h5><?php echo $announcement_title;?></h5>
						<br>
						<h6><?php echo $announcement_content;?></h6>
						<br>
						<p><?php 
							$xdate = new DateTime($date_posted);
							// $x = DateTime::createFromFromat('M d, Y', $xdate);
							$y = date_format($xdate, 'M d, Y - h:i A');
							echo $y;
						?></p>
											

						<button class="btn btn-info" data-toggle="modal" data-target="#update-announcement-modal">Update</button>
						<!-- <button class="btn btn-danger" onclick="javascript:location.href='announcement_delete.php?id=<?php echo $id;?>';">Delete</button> -->

						<button class="btn btn-danger" onclick="deleteFunction(<?php echo $id;?>)">Delete</button>

						<script>
							function deleteFunction(id) {
								var del = confirm("Do you really want to delete this announcement?");

								if (del == true) {
									document.location.href = 'announcement_delete.php?id='+id;
								}
							}
						</script>
					</div>
				</div>

				<div class="col-12 col-lg-12 border rounded" style="padding-top: 20px; padding-bottom: 20px;" id="announcement_comment" name="announcement_comment">
						<div>
							<table class="table table-borderless table-condensed" id="commentDiv" name="commentDiv">

							</table>
							<table class="table table-borderless">
								<tr>
									<th style='width: 15%;'><?php echo $t_firstname." ".$t_lastname?></th>
									<form method="POST" action="announcement.php?announcement_id=<?php echo $id?>">
										<input name="t_uname" id="t_uname" value="<?php echo $t_username; ?>" hidden>
										<td>
											<div class="input-group mb-3">
  												<textarea data-autoresize rows="1" class="form-control expand_this" name="tcomment" id="tcomment"></textarea>
  												<div class="input-group-append">
  													<span>&nbsp;</span>
  													<input type="reset" class="btn" value="X">
  													<span>&nbsp;</span>
    												<button  class="btn btn-success" id="add_comment" name="add_comment">Post</button>
  												</div>
											</div>
										</td>
									</form>
								</tr>
							</table>
						</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Update Announcement Modal -->
	<div id="update-announcement-modal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="max-width: 80% !important;">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title pull-left">Update Announcement</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action="announcement.php?announcement_id=<?php echo $id?>">
						<div class="offset-md-2 col-md-8 input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">Title:</div>
							</div>
								<!-- <input data-autoresize type="text" class="form-control expand_this" id="announcement_title" name="announcement_title"> -->
							<textarea class="form-control" id="new_title" name="new_title"><?php echo $announcement_title ?></textarea>
						</div>
						<br>
						<div class="offset-md-1 col-md-10 input-group">
							<div class="input-group row">
								<div class="input-group-prepend">
									<span class="input-group-text">Content:</span>
								</div>
								<textarea class="form-control" id="new_content" name="new_content"><?php echo $announcement_content?></textarea>
							</div>
						</div>
						<br/>  
						<div class="pull-right">
							<button  class="btn btn-primary" name="update_announcement">Update</button>
							<button  class="btn btn-danger" data-dismiss="modal">Cancel</button> 
						</div>
					</form>
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