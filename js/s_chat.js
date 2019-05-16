function closeDiv() {
	var chatDiv = document.getElementById("chatDiv");
	chatDiv.style.display = "none";
}

function postChat() {
	var postChat = document.getElementById("postChat");
	var sender = document.getElementById("sender").value;
	var receiver = document.getElementById("receiver").value;
	var message = document.getElementById("message").value;
	var subject_id = document.getElementById("subject_id").value;
	var dataString = 'sender='+ sender + '&receiver=' + receiver + '&message=' + message + 
		'&subject_id=' + subject_id;
	$.ajax({
		type: "POST",
		url: "s_post_chat.php",
		data: dataString,
		success: function() {
			getChat(receiver, sender, subject_id);
			updateScroll();
			document.getElementById("chatForm").reset();
		}
	});
	return false;
}

function stillChatting() {
	scrollToBottom();
	var friendName = document.getElementById("chatName").value;
	var friendUname = document.getElementById("chatUname").value;
	var self = document.getElementById("sender").value;
	var subject_id = document.getElementById("subId").value;
	console.log("chatUname", friendName);
	console.log("chatName", friendUname);
	console.log("subject_id", subject_id);
	
	chat(friendUname, friendName, self, subject_id);
}

function chat(uname, name, self, subject_id) {
	var chatDiv = document.getElementById("chatDiv");
	chatDiv.style.display = "block";
	var chatReceiver = document.getElementById("chatReceiver");
	chatReceiver.innerHTML = name;
	var chatUname = document.getElementById("chatUname");
	chatUname.setAttribute("value", uname);
	var chatName = document.getElementById("chatName");
	chatName.setAttribute("value", name);
	console.log("chatUname", chatUname.value);
	console.log("chatName", chatName.value);
	console.log(document.getElementById("subject_id").value);
	document.getElementById("receiver").value = uname;

	getChat(uname, self, subject_id);
	scrollToBottom();
}

function scrollToBottom() {
	var chatBody = document.getElementById("chatBody");
	chatBody.scrollTop = chatBody.scrollHeight;
}

function updateScroll() {
	$("#chatBody").stop().animate({ scrollTop: $("#chatBody")[0].scrollHeight}, 50);
}

function getChat(uname, self, subject_id) {
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("chatBody").innerHTML = this.responseText;
		}
	};
	xmlhttp.open("GET", "s_chatlogs.php?uname1=" + uname + "&uname2=" + self + "&subject_id=" + subject_id, true);
	xmlhttp.send();
	updateScroll();
}

function updateChat(uname, subject_id) {
	console.log(123);
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
		xmlhttp.open("GET", "s_show_chat.php?uname=" + uname + "&s_id=" + subject_id, true);
		xmlhttp.send();
	}, 500);
}