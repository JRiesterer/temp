const urlBase = 'https://icepekoe.xyz/LAMPAPI';
const extension = 'php';

let userId = 0;
let firstName = "";
let lastName = "";

function doLogin() {
	userId = 0;
	firstName = "";
	lastName = "";
	
	let login = document.getElementById("user").value;
	let password = document.getElementById("password").value;
	
	document.getElementById("loginResult").innerHTML = "Request Sent...";

	let tmp = {login:login, password:password};
	let jsonPayload = JSON.stringify(tmp);
	
	let url = urlBase + '/Login.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	
	try
	{
		xhr.onreadystatechange = function() 
		{
			if (this.readyState == 4 && this.status == 200) 
			{
				let jsonObject = JSON.parse( xhr.responseText );
				userId = jsonObject.id;
		
				if( userId < 1 )
				{		
					document.getElementById("loginResult").innerHTML = "User/Password combination incorrect";
					return;
				}
		
				firstName = jsonObject.fname;
				lastName = jsonObject.lname;
	
				window.location.href = "color.html";
			}
		};
		xhr.send(jsonPayload);
	}

	catch(err)
	{
		document.getElementById("loginResult").innerHTML = err.message;
	}

}

function register() {
	userId = 0;
	firstName = "";
	lastName = "";
	
	let login = document.getElementById("newUser").value;
	let password = document.getElementById("newPassword").value;
	let fname = document.getElementById("fname").value;
	let lname = document.getElementById("lname").value;
	
	document.getElementById("registerResult").innerHTML = "Attempting registration...";

	let tmp = {login:login, password:password, fname:fname, lname:lname};
	let jsonPayload = JSON.stringify(tmp);
	
	let url = urlBase + '/AddUser.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	
	try	{
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				let jsonObject = JSON.parse( xhr.responseText );

				if (jsonObject.error != '') {
					document.getElementById("registerResult").innerHTML = "Issue registering...";
				} else {
					document.getElementById("registerResult").innerHTML = "Registration successful!";
				}

			}
		};
		xhr.send(jsonPayload);
	}

	catch(err) {
		document.getElementById("loginResult").innerHTML = err.message;
	}

}

function isAvailable(login) {
	
	let tmp = {login:login};
	let jsonPayload = JSON.stringify(tmp);
	
	let url = urlBase + '/CheckUsernameAvailability.' + extension;

	let xhr = new XMLHttpRequest();
	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");
	
	try	{
		xhr.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				let jsonObject = JSON.parse( xhr.responseText );

				if (jsonObject.error != '') {
					return false;
				} else {
					return true;
				}

			}
		};
		xhr.send(jsonPayload);
	}

	catch(err) {
		return false;
	}

}

function setupPage() {
	showLogin();
	document.getElementById("registerButton").disabled = true;
}

function showLogin() {
	document.getElementById("loginOption").className = "Selected";
	document.getElementById("registerOption").className = "Unselected";
	document.getElementById("registerDiv").style.display = "none";
	document.getElementById("loginDiv").style.display = "block";
}

function showRegister() {
	document.getElementById("loginOption").className = "Unselected";
	document.getElementById("registerOption").className = "Selected";
	document.getElementById("registerDiv").style.display = "block";
	document.getElementById("loginDiv").style.display = "none";
}