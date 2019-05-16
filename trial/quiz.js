window.onload = function() {
	$(".on_off").bootstrapToggle('off');
	// var toggle1 = document.getElementById("toggle1");
	// var toggle2 = document.getElementById("toggle2");
	var toggle3 = document.getElementById("toggle3");
	// var toggle4 = document.getElementById("toggle4");
	// toggle1.onchange = getIdentification;
	// toggle2.onchange = getMultipleChoice;
	toggle3.onchange = getMultipleAnswer;
	// toggle4.onchange = getEssay;

	// var identification = document.getElementById("identification");
	// var multipleChoice = document.getElementById("multipleChoice");
	var multipleAnswer = document.getElementById("multipleAnswer");
	// var essay = document.getElementById("essay");
	// identification.style.display = "none";
	// multipleChoice.style.display = "none";
	multipleAnswer.style.display = "none";
	// essay.style.display = "none";

	// var identificationTable = document.getElementById("identificationTable");
	// var multipleChoiceTable = document.getElementById("multipleChoiceTable");
	var multipleAnswerTable = document.getElementById("multipleAnswerTable");
	// var essayTable = document.getElementById("essayTable");

	addRow;
	deleteRow;
}

function addRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);
	var colCount = table.rows[0].cells.length;

	for(var i=0; i<colCount; i++) {
		var newcell	= row.insertCell(i);
		newcell.innerHTML = table.rows[0].cells[i].innerHTML;
		//alert(newcell.childNodes);
		switch(newcell.childNodes[0].type) {
			case "text":
				newcell.childNodes[0].value = "";
				break;
			case "checkbox":
				newcell.childNodes[0].checked = false;
				break;
		}
	}

	quizTableRow(tableID);
}

function deleteRow(tableID) {
	try {
		var table = document.getElementById(tableID);
		var rowCount = table.rows.length;

		for(var i=0; i<rowCount; i++) {
			var row = table.rows[i];
			var chkbox = row.cells[0].childNodes[0];
			if(null != chkbox && true == chkbox.checked) {
				if(rowCount <= 1) {
					alert("Cannot delete all the rows.");
					break;
				}
				table.deleteRow(i);
				// console.log(row.getAttribute("id") + " has been deleted");
				rowCount--;
				i--;
			}
		}
	} catch(e) {
		alert(e);
	}

	quizTableRow(tableID);
}

function getIdentification() {
	var toggle1_val = $('#toggle1').prop('checked');
	var qLength = document.getElementById("identificationTable_length");
	if (toggle1_val) {
		identification.style.display = "block";
		qLength.setAttribute("value", 1);
	} else {
		identification.style.display = "none";
		qLength.setAttribute("value", 0);
	}
}

// function getMultipleChoice() {
// 	var toggle2_val = $('#toggle2').prop('checked');
// 	var qLength = document.getElementById("multipleChoiceTable_length");
// 	if (toggle2_val) {
// 		multipleChoice.style.display = "block";
// 		qLength.setAttribute("value", 1);
// 	} else {
// 		multipleChoice.style.display = "none";
// 		qLength.setAttribute("value", 0);
// 	}
// }

function getMultipleAnswer() {
	var toggle3_val = $('#toggle3').prop('checked');
	var qLength = document.getElementById("multipleAnswerTable_length");
	if (toggle3_val) {
		multipleAnswer.style.display = "block";
		qLength.setAttribute("value", 1);
	} else {
		multipleAnswer.style.display = "none";
		qLength.setAttribute("value", 0);
	}
}

// function getEssay() {
// 	var toggle4_val = $('#toggle4').prop('checked');
// 	var qLength = document.getElementById("essayTable_length");
// 	if (toggle4_val) {
// 		essay.style.display = "block";
// 		qLength.setAttribute("value", 1);
// 	} else {
// 		essay.style.display = "none";
// 		qLength.setAttribute("value", 0);
// 	}
// }

function quizTableRow(tableID) {
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;

	var qLength = document.getElementById(tableID + "_length");
	qLength.setAttribute("value", rowCount);
	console.log(qLength.getAttribute("id") + " has " + qLength.getAttribute("value"));

	for(var i=0; i<rowCount; i++) {
		var row = table.rows[i];
		var chk = row.cells[0];
		var quizNum = row.cells[1];
		
		var rowNumber = i + 1;
		quizNum.innerHTML = rowNumber;

		row.setAttribute("id", tableID + "_" + rowNumber);
		row.setAttribute("name", tableID + "_" + rowNumber);
		quizNum.setAttribute("value", rowNumber);

		// console.log(quizNum.getAttribute("value"));
		// console.log(row.getAttribute("name"));

		chk.style.width = "10px";
		quizNum.parentNode.style.width = "10px";
	}
}