function getSeenChat(username) {
	setInterval(function() {
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				// document.getElementById("newMessages").innerHTML = this.responseText;
				var responseArray = xmlhttp.responseText.split("||");
				document.getElementById("newMessages").innerHTML = responseArray[0];
				console.log(responseArray[1]);
				document.getElementById("checkMes").innerHTML = responseArray[1];
			}
		};
		xmlhttp.open("GET", "seen_chat.php?t_username=" + username, true);
		xmlhttp.send();
	}, 1000);
}

function s_getSeenChat(username) {
	setInterval(function() {
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				// document.getElementById("newMessages").innerHTML = this.responseText;
				var responseArray = xmlhttp.responseText.split("||");
				document.getElementById("newMessages").innerHTML = responseArray[0];
				console.log(responseArray[1]); 
				document.getElementById("checkMes").innerHTML = responseArray[1];
			}
		};
		xmlhttp.open("GET", "s_seen_chat.php?t_username=" + username, true);
		xmlhttp.send();
	}, 1000);
}

// function s_getTask(username) {
// 	setInterval(function() {
// 		xmlhttp = new XMLHttpRequest();
// 		xmlhttp.onreadystatechange = function() {
// 			if (this.readyState == 4 && this.status == 200) {
// 				// document.getElementById("newMessages").innerHTML = this.responseText;
// 				var responseArray = xmlhttp.responseText.split("||");
// 				document.getElementById("newTask").innerHTML = responseArray[0];
// 				console.log(responseArray[1]);
// 				document.getElementById("checkTask").innerHTML = responseArray[1];
// 			}
// 		};
// 		xmlhttp.open("GET", "s_seen_chat.php?username=" + username, true);
// 		xmlhttp.send();
// 	}, 5000);
// }

function s_getTask(username) {
	setInterval(function() {
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				// document.getElementById("newMessages").innerHTML = this.responseText;
				var responseArray = xmlhttp.responseText.split("||");
				document.getElementById("newTask").innerHTML = responseArray[0];
				console.log(responseArray[1]);
				document.getElementById("checkTask").innerHTML = responseArray[1];
			}
		};
		xmlhttp.open("GET", "s_getTask.php?username=" + username, true);
		xmlhttp.send();
	}, 5000);
}