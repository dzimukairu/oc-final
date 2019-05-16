<?php
	include("db_connection.php");

	$username = $_GET['t_username'];

	$getchat = $dbconn->query("SELECT subject_id, count(*), message from chat where (receiver = '$username') and opened = 'false' group by subject_id ");

	if (mysqli_num_rows($getchat) != 0) {
		while ($row = mysqli_fetch_row($getchat)) {
			$getSubject = $dbconn->query("SELECT * from subject where subject_id = '$row[0]' ");
			$subject = mysqli_fetch_array($getSubject);
			$subject_id = $row[0];
?>
			<a href='teacher_course.php?subject_id=<?php echo $subject_id; ?>' style='margin-bottom: 0;'>
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