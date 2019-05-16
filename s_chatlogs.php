<?php 
	include("db_connection.php");

	$friend = $_GET['uname1'];
	$self = $_GET['uname2'];
	$subject_id = $_GET['subject_id'];

	$updateSeenChat = $dbconn->query("UPDATE chat set opened = 'true' where (receiver = '$self') and subject_id = '$subject_id' ");

	if($updateSeenChat) {
		$getchat = $dbconn->query("SELECT * from chat where (receiver = '$friend' or sender = '$friend') and (receiver = '$self' or sender = '$self') and subject_id = '$subject_id' order by date_posted asc");
	
		if (mysqli_num_rows($getchat) != 0) {
			while ($chat = mysqli_fetch_array($getchat)) {
				$xdate = new DateTime($chat['date_posted']);
				$y = date_format($xdate, 'M d, Y - h:i A');

				if ($friend == $chat['sender']) {
	?>
					<div class="chat friend">
						<p class="chat-message"><?php echo $chat['message']; ?></p>
						<p class="date-posted"><?php echo $y; ?></p>
					</div>
	<?php
				}	else {
	?>
					<div class="chat self">
						<p class="chat-message"><?php echo $chat['message']; ?></p>
						<p class="date-posted"><?php echo $y; ?></p>
					</div>
	<?php
				}
			}
		} else {
	?>
			<p style="width: 100%; text-align: center"><i>No conversation.</i></p>
	<?php
		}
	}
?>
