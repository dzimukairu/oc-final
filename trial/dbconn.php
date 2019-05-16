<?php
	// $host = 'localhost';
	// $username = 'root';
	// $password = '';
	// $db = 'oc';
	// $dbconn = mysqli_connect($host, $username, $password, $db) or die("NO DATABASE FOUND!");
	$dbconn = mysqli_connect("localhost", "root", "", "trial_quiz");

	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>