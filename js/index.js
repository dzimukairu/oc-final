window.onload = function () {
	var first_name = document.getElementById("first_name");
	var last_name = document.getElementById("last_name");
	var email = document.getElementById("email");
	// var username = document.getElementById("username");
	var pwd = document.getElementById("pwd");
	var retype_pwd = document.getElementById("retype_pwd");
	var nameMsg = document.getElementById("nameMsg");
	var usernameMsg = document.getElementById("usernameMsg");
	var emailMsg = document.getElementById("emailMsg");
	var pwdMsg = document.getElementById("pwdMsg");
	var retype_pwdMsg = document.getElementById("retype_pwdMsg");
	firstnameMsg.style.visibility = "hidden";
	lastnameMsg.style.visibility = "hidden";
	usernameMsg.style.visibility = "hidden";
	emailMsg.style.visibility = "hidden";
	pwdMsg.style.visibility = "hidden";
	retype_pwdMsg.style.visibility = "hidden";

	var createAccountForm = document.getElementById("createAccountForm");
	createAccountForm.onsubmit = checkInputs;

	email.onkeyup = checkEmail;
	pwd.onkeyup = checkPwd;
	retype_pwd.onkeyup = verifyPwd;
	username.onkeyup = checkUsername;
	first_name.onkeyup = checkFName;
	last_name.onkeyup = checkLName;
}

function checkInputs() {
	checkFName();
	checkLName();
	checkUsername();
	checkEmail();
	checkPwd();
}

function checkFName() {
	var first_name = document.getElementById("first_name").value;

	if (first_name == null || first_name == "") {
		return false;
	}
	else {
		var pattern = /^([A-Z]{1}[a-z]*(\s)?)+$/igm;
		var match = pattern.test(first_name);
		console.log(match);
		if (match) {
			firstnameMsg.style.visibility = "visible";
			firstnameMsg.style.color = "green";
			firstnameMsg.innerHTML = "First Name is Valid!";
		} else {
			firstnameMsg.style.color = "red"
			firstnameMsg.style.visibility = "visible";
			firstnameMsg.innerHTML = "Please enter proper name.";
		}  
		return false;
	}
}

function checkLName() {
	var last_name = document.getElementById("last_name").value;

	if (last_name == null || last_name == "") {
		return false;
	}
	else {
		var pattern = /^([A-Z]{1}[a-z]*(\s)?)+$/igm;
		var match = pattern.test(last_name);
		console.log(match);
		if (match) {
			lastnameMsg.style.visibility = "visible";
			lastnameMsg.style.color = "green";
			lastnameMsg.innerHTML = "Last Name is Valid!";
		} else {
			lastnameMsg.style.color = "red"
			lastnameMsg.style.visibility = "visible";
			lastnameMsg.innerHTML = "Please enter proper name.";
		}  
		return false;
	}
}

function checkUsername() {
	var uname = document.getElementById("username").value;

	if (uname == null || uname == "") {
		return false;
	}
	else {
		var pattern = /^[a-zA-Z0-9]{6,}$/igm;
		var match = pattern.test(uname);
		console.log(match);
		if (match) {
			usernameMsg.style.visibility = "visible";
			usernameMsg.style.color = "green";
			usernameMsg.innerHTML = "Username is Valid!";
		} else {
			usernameMsg.style.color = "red"
			usernameMsg.style.visibility = "visible";
			usernameMsg.innerHTML = "Username must be 6 in length with no special characters.";
		}  
		return false;
	}
}

function checkEmail() {
	var email = document.getElementById("email").value;

	if (email == null || email == "") {
		return false;
	}
	else {
		var pattern = /^[a-zA-Z0-9_-]+@[A-Z0-9a-z]+\.[a-zA-Z]{2,}$/igm;
		var match = pattern.test(email);
		console.log(match);
		if (match) {
			emailMsg.style.visibility = "visible";
			emailMsg.style.color = "green";
			emailMsg.innerHTML = "Email is Valid!";
		} else {
			emailMsg.style.color = "red"
			emailMsg.style.visibility = "visible";
			emailMsg.innerHTML = "Please enter proper email.";
		}
		return false;
	}
}

function checkPwd() {
	verifyPwd();
	var pwd = document.getElementById("pwd").value;

	if (pwd == null || pwd == "") {
		return false;
	}
	else {
		var pattern = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]*).{8,}$/igm;
		var match = pattern.test(pwd);
		console.log(match);
		if (match) {
			pwdMsg.style.visibility = "visible";
			pwdMsg.style.color = "green";
			pwdMsg.innerHTML = "Password is Valid!";
		} else {
			pwdMsg.style.color = "red"
			pwdMsg.style.visibility = "visible";
			pwdMsg.innerHTML = "Password must be 8 in length and contain 1 number.";
		}
		return false;
	}
}

function verifyPwd() {
	var retype_pwd = document.getElementById("retype_pwd").value;
	var pwd = document.getElementById("pwd").value;

	if (retype_pwd == null || retype_pwd == "") {
		return false;
	}
	else {
		if (retype_pwd == pwd) {
			retype_pwdMsg.style.visibility = "visible";
			retype_pwdMsg.style.color = "green";
			retype_pwdMsg.innerHTML = "Password matched!";
		} else {
			retype_pwdMsg.style.color = "red"
			retype_pwdMsg.style.visibility = "visible";
			retype_pwdMsg.innerHTML = "Password doesn't match.";
		}
		return false;
	}
}