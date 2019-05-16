<?php
	include("db_connection.php");

	$username = $_GET['t_username'];
	$s_id = $_GET['s_id'];


	$getchat = $dbconn->query("SELECT sender, count(*) from chat where (receiver = '$username') and opened = 'false' and subject_id = '$s_id' group by sender ");

	if (mysqli_num_rows($getchat) != 0) {
		while ($row = mysqli_fetch_row($getchat)) {
			$getStudent = $dbconn->query("SELECT * from student where username = '$row[0]' ");
			$student = mysqli_fetch_array($getStudent);
			// $name = $student['first_name'] + " " + $student['last_name'];
?>
			<a style='margin-bottom: 0;'>
<?php
			echo "<strong>".$row[1]."</strong> new messages from <strong>".$student['first_name']." ".$student['last_name']."</strong>.";
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