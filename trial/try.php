<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<!-- Stylesheet -->
		<link rel="stylesheet" href="../style.css">
		<link rel="stylesheet" href="../css/expand.css">
		<link rel="stylesheet" href="../css/bootstrap-toggle.min.css">

		<style>
			.toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
			.toggle.ios .toggle-handle { border-radius: 20px; }
		</style>

		
	</head>
	<body>
		<div class="row">
			<div style=" width: 92%; margin-left: 4%; margin-top: 10px">
				<form method="POST" action="createQuiz.php">
					<input name="quiz_name" class="form-control" placeholder="Quiz Name">
					<div id="quiz_multipleAnswer" class="form-group">
						<label>
							<input id="toggle3" name="toggle3" class="on_off" data-toggle="toggle" data-style="ios" data-on="Enable" data-off="Disable" type="checkbox">
							<input type="hidden" id="hidden_toggle" name="hidden_toggle">
							Multiple Answers
						</label>
						<div id="multipleAnswer">
							<input type="button" value="Add Row" onclick="addRow('multipleAnswerTable')"  class="btn btn-success"/>
							<input type="button" value="Delete Row" onclick="deleteRow('multipleAnswerTable')"  class="btn btn-danger"/>
							<br>
							<br>

							<table id="multipleAnswerTable" class="table table-hover">
								<tr>
									<td style="width: 10px"><input type="checkbox" class="form-check-input" name="chk"/></td>
									<td style="width: 20px"><p>1</p></td>

									<td><textarea data-autoresize rows="2" class="form-control expand_this" id="multipleAnswer_question[]" name="multipleAnswer_question[]" value="" placeholder="Enter question here." ></textarea></td>                                          
									<td><textarea data-autoresize rows="2" class="form-control expand_this" id="multipleAnswer_choices[]" name="multipleAnswer_choices[]" value="" placeholder="Enter choices here (separated by semicolon ';' )" ></textarea></td>
									<td><textarea data-autoresize rows="2" class="form-control expand_this" id="multipleAnswer_answer[]" name="multipleAnswer_answer[]" value="" placeholder="Enter answer here (separated by semicolon ';' )" ></textarea></td>

								</tr>
							</table>
							<input id="multipleAnswerTable_length" name="multipleAnswerTable_length" value="0"/>
						</div>
					</div>

					<input type="submit" name="add_quiz" class="btn btn-success pull-right" value="Submit">
				</form>
			</div>
		</div>

		<script src="../js/jquery/jquery-2.2.4.min.js"></script>
		<!-- Popper js -->
		<script src="../js/bootstrap/popper.min.js"></script>
		<!-- Bootstrap js -->
		<script src="../js/bootstrap/bootstrap.min.js"></script>
		<!-- All Plugins js -->
		<script src="../js/plugins/plugins.js"></script>
		<!-- Active js -->
		<script src="../js/active.js"></script>
		<!-- Toggle -->
		<script src="../js/bootstrap-toggle.min.js"></script>
		<script src="../js/expand.js"></script>
		<script src="quiz.js"></script>
		<script>
			$('#toggle3').change(function() {
				if($(this).prop('checked')) {
					$('#hidden_toggle').val('enable');
					// console.log(1);
				} else {
					$('#hidden_toggle').val('disable');
					// console.log(2);
				}
				console.log($('#hidden_toggle').val());
			});
		</script>
	</body>
</html>