<?php
	require "db_connection.php";
	
	session_start();
	if (!isset($_SESSION['username'])) {
		header("Location:index.php");
	}
	
	$id = $_GET['subject_id'];
	//$username = $_SESSION['username'];
	$error = '';
	$error1 = '';
	$error2 = '';
	$errorcount = true;

	date_default_timezone_set("Asia/Manila");

	$sql = "SELECT subject_code, course_title, course_description, course_about, teacher_id from subject where subject_id = $id";

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

	$student_ids = array();
	$get_students = "SELECT * from enrolls WHERE subject_id = '$id' AND status = 'enrolled'";
	$get_students_connect = mysqli_query($dbconn, $get_students);
	while ($studentData = mysqli_fetch_array($get_students_connect)) {
		$student_ids[] = $studentData['student_id'];
	}

	if(isset($_POST['add_assignment'])) {
		$id = $_GET['subject_id'];
		$assignment_title = $_POST['assignment_title'];
		$assignment_instruction = $_POST['assignment_instruction'];
		$deadline_date = $_POST['deadline_date'];
		$deadline_time = $_POST['deadline_time'];
		$score = $_POST['score'];
		$assignment_type = $_POST['assignment_type'];

		$deadline = date('Y-m-d H:i:s', strtotime("$deadline_date $deadline_time"));
		$todayTime = date('Y-m-d H:i:s');

		$to_time = strtotime($deadline);
		$from_time = strtotime($todayTime);
		$timediff = ($to_time - $from_time)/3600;

		if ($timediff  < 0) {
			$error1 = 'Invalid date/time.';
			$errorcount = false;
		}

		if (empty($assignment_title) && empty($assignment_instruction)) {
			$error2 = 'Please input title and instruction.';
			$errorcount = false;
		} else if (empty($assignment_title)) {
			$error2 = 'Please input title.';
			$errorcount = false;
		} else if (empty($assignment_instruction)) {
			$error2 = 'Please input instruction.';
			$errorcount = false;
		}

		if ($errorcount > 2) {
			$error = $error1. ' '. $error2.' ';
		}

		if ($errorcount) {

			if($_FILES['fileToUpload']['size'] == 0) {
				$query = $dbconn->query("INSERT into assignment(subject_id, date_posted, deadline_date, deadline_time, title, instruction, score, assignment_type) VALUES('$id', NOW(), '$deadline_date', '$deadline_time', '$assignment_title', '$assignment_instruction', '$score', '$assignment_type')");
				
				if ($query) {
					header("Location: teacher_course.php?subject_id=".$id);
				}
			}
			else {
				$target_dir = "uploads/";
				$fileName = basename($_FILES["fileToUpload"]["name"]);
				$target_files = $target_dir . $fileName;
				$fileType = pathinfo($target_files,PATHINFO_EXTENSION);

				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_files)) {
						$insert_file_query = $dbconn->query("INSERT into uploaded_files(filename, date_posted) values ('".$fileName."', NOW())");
				}

				if ($insert_file_query) {
					$file_id = $dbconn->insert_id;

					$query = $dbconn->query("INSERT into assignment(subject_id, date_posted, deadline_date, deadline_time, title, instruction, score, file_id, assignment_type) VALUES('$id', NOW(), '$deadline_date', '$deadline_time', '$assignment_title', '$assignment_instruction', '$score', '$file_id', '$assignment_type')");
				
					if ($query) {
							header("Location: teacher_course.php?subject_id=".$id);
					}
				}
			}

			$getLastId = $dbconn->query("SELECT MAX(assignment_id) FROM assignment WHERE subject_id = $id AND assignment_type= 'individual'");
			$lastInsert = mysqli_fetch_array($getLastId);
			$lastID = $lastInsert[0];

			if ($assignment_type = 'group') {
				$indicator_query = "SELECT MAX(assignment_id) FROM assignment WHERE subject_id = $id AND assignment_type= 'group'";
				$indicator_connect = mysqli_query($dbconn, $indicator_query);
				while ($row2 = mysqli_fetch_array($indicator_connect)) {
					$max_result = $row2[0];
					//echo "<script>alert('$max_result');</script>";
					//$new_indicator = $max_result + 1;
				}

				$indicator_query2 = "SELECT MAX(indicator) FROM group_assignment WHERE subject_id = $id";
				$indicator_connect2 = mysqli_query($dbconn, $indicator_query2);
				while ($row3 = mysqli_fetch_array($indicator_connect2)) {
					$max_result2 = $row3[0];
					//echo "<script>alert('$max_result2');</script>";
					//$new_indicator = $max_result + 1;
				}



				$update_group_query = "UPDATE group_assignment SET assignment_id = '$max_result' WHERE indicator = $max_result2 ";
				$update_connect = mysqli_query($dbconn, $update_group_query);

			}
			$table_checker = $dbconn->query("SELECT * from individual_assignment WHERE assignment_id = '$lastID'");
			$existing_assignment = mysqli_num_rows($table_checker);
			if ($existing_assignment == 0) {
				foreach ($student_ids as $student_id) {
					$insert_query = "INSERT into individual_assignment(assignment_id, subject_id, student_id) VALUES('$lastID' , '$id', $student_id) ";
					$insert_query_connect = mysqli_query($dbconn, $insert_query);
				}
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	

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
			<div class="row">
				<div class="col-12 col-lg-12">
					<div class="section-heading">
						<h3>Create New Assignment</h3>
					</div>        
			   </div>
			</div>
			<br>
			<div class="row">
				<h7 class="text-danger"><?php echo $error1 ?></h7>
				<h7 class="text-danger"><?php echo $error2 ?></h7>
				
				<div class="col-12 col-lg-12 border rounded">
					<div style="padding: 20px 12px 60px 12px;">
						<form method="post" action="teacher_assignment.php?subject_id=<?php echo $id ?>" enctype="multipart/form-data">
							<div class="form-group offset-md-4">
								<label style="font-weight: bold" for="assignment_type">Assignment Type:</label>
									<input type="radio" name="assignment_type" value="individual" onclick="showdiv('individual')" checked ="checked" /> Individual
									<input type="radio" name="assignment_type" value="group" onclick="showdiv('group')"/> Group
							</div>

							<!-- script when assignment is group type to show the input field for number of groups !-->

							<script>
								function showdiv(x){
									if (x == "group") {
										document.getElementById('showgroup').style.display='block';
									}
									else{
										document.getElementById('showgroup').style.display='none';
									}
								}

								function printMems() {
									document.getElementById('showMembers').style.display = 'block';
								}

							</script>

							<!-- end script -->


							<div class="offset-md-2 col-8 input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Title:</div>
									<textarea data-autoresize rows="1" cols="80" class="form-control expand_this" id="assignment_title" name="assignment_title"></textarea>
									<input type="text" id="id_of_subject" value="<?php echo($id) ?>" style="display: none;">
								</div>
							</div>

							<br>

							<div class="offset-md-3 col-6 input-group">
								<div class="input-group-prepend">
									<div class="input-group-text">Deadline:</div>
								</div>
								<?php
									$startTime = date("Y-m-d H:i:s");
									$cenvertedTime = date('Y-m-d',strtotime('+1 hour',strtotime($startTime)));

								?>
								<input type="date" name="deadline_date" id="deadline_date" value="<?php echo $cenvertedTime; ?>" min="<?php echo $cenvertedTime; ?>" class="form-control">
								<input type="time" name="deadline_time" id="deadline_time" value="<?php echo date('H:i', time()+3600);?>" class="form-control">
							</div>
							<div class="offset-md-3 col-6">
								<p style="font-style: italic">Deadline time is set 1 hour after of current time. (You can change it)</p>
							</div>
							<br><br>

							<div class="form-group offset-md-1 col-10">
								<label style="font-weight: bold">Instruction:</label>
								<textarea data-autoresize rows="2" class="form-control expand_this" id="assignment_instruction" name="assignment_instruction"></textarea>

								<input type="file" name="fileToUpload">
							</div>
							<div class="offset-md-3 col-6 input-group">
								<div class="input-group-text">Total Points:</div>
								<input type="number" class="form-control expand_this" id="score" name="score" required>
							</div>

							<br>
							<br>

							<div id="showgroup" class="row group offset-md-1" style="display: none;">
								<div class="col-6 input-group group_div">
									<div class="input-group-text">Number of Groups:</div>
									<input id="group_num_id" type="number" min="2" placeholder="min of 2 groups" class="form-control" name="group_num">
									&nbsp;
									<input type="button" class="btn btn-outline-success" id="generate" value="Generate">
									<script>
										$(document).ready(function(){
										  $('#generate').click(function(){
										  	document.getElementById('generate').style.display='none';
										    var number_of_groups = $('#group_num_id').val();
										    var subj_number = $('#id_of_subject').val();
										    var dataString = "groupCount=" + number_of_groups + "&subject_id=" + subj_number;
										    if(number_of_groups >= 2){
										    	if(number_of_groups >= 2){
											    	$('#showMembers').load('load_mems.php', {
											    		groupCount: number_of_groups,
											    		subject_id: subj_number
											    	});
											    }	
										    }
										    else{
										    	alert("Number of groups must be at least 2!");
										  		document.getElementById('generate').style.display='block';
										    }
										  });
										});
									</script>
								</div>
							</div>

							<br>

							<div id="showMembers" class="offset-md-2 col-md-8">

							</div>

							<div id="showMemCode">
								<?php 
									
								 ?>
							</div>
								
							<br>

							<input id="create_now" type="submit" class="btn btn-success pull-right" name="add_assignment" value="SUBMIT"/>
						</form>
					</div>
				</div>
			</div>
			<div style="margin-top:12px;">
				<?php 
					echo "<a href=teacher_course.php?subject_id=",urlencode($id)," class='btn clever-btn'>Back</a>";
				?>
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
	<script src="js/quiz.js"></script>
	<script src="js/expand.js"></script>
</body>

</html>