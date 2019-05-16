window.onload = function () {
	subject_code = document.getElementById("subject_code");
	genCode = document.getElementById("genCode");

	genCode.onclick = generateCode;


}

function generateCode() {
   //  var text = "";
  	// var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  	// for (var i = 0; i < 8; i++) {
   //  	text += possible.charAt(Math.floor(Math.random() * possible.length));
   //  }

   //  return text

   	code = btoa(Math.random().toString(36).substring(2,8));

	subject_code.setAttribute("value", code);
	subject_code.innerHTML = code;

	console.log(subject_code.value)
}
 