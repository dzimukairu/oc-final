<?php
	require "db_connection.php";

	$username = $_GET['uname'];

	$checkUname = $dbconn->query("SELECT username from teacher where username = '$username' ");
	$count1 = mysqli_num_rows($checkUname);

	$checkUname2 = $dbconn->query("SELECT username from student where username = '$username' ");
	$count2 = mysqli_num_rows($checkUname2);

	$count = $count1 + $count2;

	if ($count > 0) {
		echo '<span style="color: red;">Username is taken.</span>';
	} else {
		echo '<span style="color: green;">Username is available.</span>';
	}
?>