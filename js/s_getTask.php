<?php
	include("db_connection.php");

	$username = $_GET['username'];

	$getStudentId = "SELECT * from student WHERE username = '$username'";
	$getStudentId_connect = mysqli_query($dbconn, $getStudentId);
	if (mysqli_num_rows($getStudentId_connect) != 0) {
		while ($studentData = mysqli_fetch_array($getStudentId_connect)) {
			$studentId = $studentData['student_id'];
		}
	}

	$getGroupAssignment = "SELECT subject_id, count(*) from group_assignment where student_id = '$studentId' and opened = 'false' group by subject_id ";
	$getGroupAssignment_connect = mysqli_query($dbconn, $getGroupAssignment)

	if (mysqli_num_rows($getGroupAssignment_connect) != 0) {
		while ($row = mysqli_fetch_row($getGroupAssignment_connect)) {
			$getSubject = $dbconn->query("SELECT * from subject where subject_id = '$row[0]' ");
			$subject = mysqli_fetch_array($getSubject);
			$subject_id = $row[0];
?>
			<a href='student_course.php?subject_id=<?php echo $subject_id; ?>' style='margin-bottom: 0;'>
<?php
			echo "<strong>".$row[1]."</strong> new messages from <strong>".$subject['course_title']."</strong>.";
			echo "</a>";
			echo "<br>";
		}

		echo "||";
		echo "!";
	} else {
		echo "<p style='margin-bottom: 0; font-weight: bold;' >No new messages.</p>";

		echo "||";
		echo "";
	}

?>