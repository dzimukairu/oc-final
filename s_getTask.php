<?php
	include("db_connection.php");

	$username = $_GET['username'];
	$group_count = 0;
	$indiv_count = 0;
	$announcement_count = 0;

	$total_count = 0;

	$getStudentId = "SELECT * from student WHERE username = '$username'";
	$getStudentId_connect = mysqli_query($dbconn, $getStudentId);
	if (mysqli_num_rows($getStudentId_connect) != 0) {
		while ($studentData = mysqli_fetch_array($getStudentId_connect)) {
			$studentId = $studentData['student_id'];
		}
	}

	$getAnnouncement = "SELECT subject_id, count(*) from see_announcement where student_id = '$studentId' and opened = 'false' group by subject_id ";
	$getAnnouncement_connect = mysqli_query($dbconn, $getAnnouncement);
	$announcement_count = mysqli_num_rows($getAnnouncement_connect);

	$getGroupAssignment = "SELECT subject_id, count(*) from group_assignment where student_id = '$studentId' and opened = 'false' and assignment_id <> 0 group by subject_id ";
	$getGroupAssignment_connect = mysqli_query($dbconn, $getGroupAssignment);
	$group_count = mysqli_num_rows($getGroupAssignment_connect);

	$getIndivAssignment = "SELECT subject_id, count(*) from individual_assignment where student_id = '$studentId' and opened = 'false' group by subject_id";
	$getIndivAssignment_connect = mysqli_query($dbconn, $getIndivAssignment);
	$indiv_count = mysqli_num_rows($getIndivAssignment_connect);

	$assignment_graded = "SELECT subject_id, count(*) from graded_assignment where student_id = '$studentId' and graded = 'true' and opened = 'false' group by subject_id ";
	$assignment_graded_connect = mysqli_query($dbconn, $assignment_graded);
	$graded_count = mysqli_num_rows($assignment_graded_connect);

	$total_count = $announcement_count + $indiv_count + $group_count + $graded_count;




	if ($total_count != 0) {
		while ($row = mysqli_fetch_row($getGroupAssignment_connect)) {
			$getSubject = $dbconn->query("SELECT * from subject where subject_id = '$row[0]' ");
			$subject = mysqli_fetch_array($getSubject);
			$subject_id = $row[0];
?>
			<a href='student_course.php?subject_id=<?php echo $subject_id; ?>' style='margin-bottom: 0;'>
<?php
			echo "<strong>".$row[1]."</strong> new group assignments from <strong>".$subject['course_title']."</strong>.";
			echo "</a>";
			echo "<br>";
		}
		while ($row2 = mysqli_fetch_array($getIndivAssignment_connect)) {
			$getSubject2 = $dbconn->query("SELECT * from subject where subject_id = '$row2[0]' ");
			$subject2 = mysqli_fetch_array($getSubject2);
			$subject_id2 = $row2[0];
?>
			<a href='student_course.php?subject_id=<?php echo $subject_id2; ?>' style='margin-bottom: 0;'>
<?php
			echo "<strong>".$row2[1]."</strong> new individual assignments from <strong>".$subject2['course_title']."</strong>.";
			echo "</a>";
			echo "<br>";
		}
		while ($row3 = mysqli_fetch_array($assignment_graded_connect)) {
			$getSubject3 = $dbconn->query("SELECT * from subject where subject_id = '$row3[0]' ");
			$subject3 = mysqli_fetch_array($getSubject3);
			$subject_id3 = $row3[0];
?>
			<a href='s_classrecord.php?subject_id=<?php echo $subject_id3; ?>' style='margin-bottom: 0;'>
<?php
			//echo $group_count;
			echo "<strong>".$row3[1]."</strong> newly graded assignment from <strong>".$subject3['course_title']."</strong>.";
			echo "</a>";
			echo "<br>";
		}
		while ($row4 = mysqli_fetch_array($getAnnouncement_connect)) {
			$getSubject4 = $dbconn->query("SELECT * from subject where subject_id = '$row4[0]' ");
			$subject4 = mysqli_fetch_array($getSubject4);
			$subject_id4 = $row4[0];
?>
			<a href='student_course.php?subject_id=<?php echo $subject_id4; ?>' style='margin-bottom: 0;'>
<?php
			//echo $group_count;
			echo "<strong>".$row4[1]."</strong> unseen announcement from <strong>".$subject4['course_title']."</strong>.";
			echo "</a>";
			echo "<br>";
		}

		echo "||";
		echo "!";
	} else {
		echo "<p style='margin-bottom: 0; font-weight: bold;' >No new notification.</p>";

		echo "||";
		echo "";
	}

?>