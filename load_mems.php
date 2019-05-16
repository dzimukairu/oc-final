<?php
	require "db_connection.php";

	$numberOfGroups = $_POST['groupCount'];
	$idOfSubject = $_POST['subject_id'];




	$mem_query = "SELECT student.student_id, student.first_name, student.last_name FROM student INNER JOIN enrolls on student.student_id = enrolls.student_id WHERE enrolls.subject_id = $idOfSubject and enrolls.status = 'enrolled'";
	$query_connect_db = mysqli_query($dbconn, $mem_query);
	$number_of_enrollees = mysqli_num_rows($query_connect_db);
	$number_of_members = intdiv($number_of_enrollees, $numberOfGroups);
	$remainder = $number_of_enrollees % $numberOfGroups;

	$indicator_query = "SELECT MAX(indicator) FROM group_assignment WHERE subject_id = $idOfSubject";
	$indicator_connect = mysqli_query($dbconn, $indicator_query);
	
	//$max_indicator= $max_indicator_result['indicator'];

	

	$remCount = 0;
	$member_data = array(); 
	$id_data = array(); 
	$group_id = array();
	$gathered_ids = array();

	/*$member_data = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30];
	$number_of_enrollees = sizeof($member_data);
	$number_of_members = intdiv($number_of_enrollees, $numberOfGroups);
	$remainder = $number_of_enrollees  % $numberOfGroups;*/

	//echo $number_of_enrollees."<br>".$number_of_members."<br>".$remainder;
	?>
	<input id="number_of_enrollees" type="hidden" name="number_of_enrollees" value="<?php echo $number_of_enrollees ?>">
	<input type="hidden" name="number_of_members" value="<?php echo $number_of_members ?>">
	<input type="hidden" name="remainder" value="<?php echo $remainder ?>">

	<?php

	if ($remainder > 0) {
		$remCount = 1;
	}

	while ($row2 = mysqli_fetch_array($indicator_connect)) {
		$max_result = $row2[0];
		//echo"maximum is:"." ". $max_result;
		$new_indicator = $max_result + 1;
	}

	if ($number_of_enrollees > 0) {
		while ($membersRow = mysqli_fetch_array($query_connect_db)) {
			$member_data[] = $membersRow['student_id'];
			//$id_data[] = $membersRow['student_id'];

		}
	}
	else{
		echo "no enrollees for this subject";
	}

	$counter = 0;

	if ($numberOfGroups <= $number_of_enrollees) { ?>
		<table border="1">
<?php	for ($i=0; $i < $numberOfGroups; $i++) { ?>

			<tr>
				<h4>Group <?php echo $i+1; ?> </h4>
			</tr>
	<?php	for ($j=0; $j < $number_of_members + $remCount; $j++) { ?>

					<tr>
						<?php
							if (sizeof($member_data) > $j) {
								shuffle($member_data);
								//echo $member_data[$j]."\n ";
								$single_id = $member_data[$j];

								$get_id = $dbconn->query("SELECT * from student where student_id = '$single_id'");
								$student = mysqli_fetch_array($get_id);
								$gathered_ids[$i][$j] = $single_id;
								
						?>

								<input id= "<?php echo 'student_id'.$counter; ?>" name="<?php echo 'student_id'.$counter; ?>" type= "hidden" value = "<?php echo $new_indicator; ?>" class="student_id_value">
							<?php 
								
								echo $student['first_name']." ".$student['last_name'];
								echo "<br>";
								unset($member_data[$j]);
								$group_no = $i + 1;

								$query_insert = "INSERT into group_assignment(subject_id, group_number, student_id, indicator) VALUES('$idOfSubject', '$group_no', '$single_id','$new_indicator' )";
								$insert_connect = mysqli_query($dbconn, $query_insert);
								
								if ($insert_connect) {

										echo "<script> console.log($single_id); </script>";
									
									
								}
								else{
									echo "<script> console.log(mysqli_connect_error())</script>";
								}
								$member_data = array_values($member_data);
								$counter++;

							} else {
								$size = (sizeof($member_data)-1);
								$randomized = rand(0, $size);
								//echo $member_data[$randomized]."\n ";
								$single_id = $member_data[$randomized];
								
								$get_id = $dbconn->query("SELECT * from student where student_id = '$single_id'");
								$student = mysqli_fetch_array($get_id);
								$gathered_ids[$i][$j] = $single_id;
							?>

								<input id= "<?php echo 'student_id'.$counter; ?>" name="<?php echo 'student_id'.$counter; ?>" type= "hidden" value = "<?php echo $new_indicator; ?>" class="student_id_value">
							<?php 
								
								echo $student['first_name']." ".$student['last_name'];
								echo "<br>";
								unset($member_data[$randomized]);

								$group_no = $i + 1;

								$query_insert = "INSERT into group_assignment(subject_id, group_number, student_id, indicator) VALUES('$idOfSubject', '$group_no', '$single_id', '$new_indicator' )";
								$insert_connect = mysqli_query($dbconn, $query_insert);
								
								if ($insert_connect) {

										echo "<script> console.log($single_id)</script>";
									
									
								}
								else{
									echo "<script> console.log(mysqli_connect_error())</script>";
								}


								$member_data = array_values($member_data);
								$counter++;
							}
							
						 ?>
					</tr>
				
							
	<?php	}
		
			$remainder--;


			if($remainder <= 0){
				$remCount = 0;
			}

	?>

<?php	} ?>

	</table>

<?php	

	
	}

	/*else if ($numberOfGroups == $number_of_enrollees) {
		echo "<script>alert('Why not make it individual instead?');</script>";
	}*/
	else{
		echo "<script>alert('Exceeded the number of students.');</script>";
	}

	
?>