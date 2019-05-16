<?php
	require "db_connection.php";

	$a_id = $_GET['a_id'];

	$comment_query = $dbconn->query("SELECT * FROM `announcement_comment` WHERE announcement_id = $a_id  order by date_posted asc");
	$affected = mysqli_num_rows($comment_query);
																									
	if ($affected != 0) {
		while ($row = mysqli_fetch_row($comment_query)) {
			$get_uname = $row[2];
			$content = $row[3];
			$d_post = $row[4];

			$xdate = new DateTime($d_post);
			$show_post = date_format($xdate, 'M d, Y - h:i A');

			$student_query = $dbconn->query("SELECT * FROM student WHERE username = '$get_uname'");
				if (mysqli_num_rows($student_query) == 1) {
					$srow = mysqli_fetch_row($student_query);
					$first_name = $srow[1];
					$last_name = $srow[2];
				} else {
					$teacher_query = $dbconn->query("SELECT * FROM teacher WHERE username = '$get_uname'");
					$trow = mysqli_fetch_row($teacher_query);
					$first_name = $trow[1];
					$last_name = $trow[2];
				}
?>
				<tr>
					<?php
						echo "<th style='width: 15%; padding-bottom: 30px' rowspan='2'>".$first_name." ".$last_name."</th>";
						echo "<td style='width: 85%; font-size: 18px;' colspan='3'>".$content."</td>";
					?>
				</tr>
				<tr>
					<?php
						echo "<td style='width: 85%; font-size: 10px; font-style: italic;' colspan='3'><h7>".$show_post."</h7></td>";
					?>
				</tr>
<?php 
		}
	}
?>