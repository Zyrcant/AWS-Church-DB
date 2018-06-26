<html>
	<head>
		<title> Reset password</title>
		<link rel="stylesheet" type="text/css" href="styles1.css">
	</head>
	<body>
		<div id="pizza">
		<h1><b>Reset your password?</b></h1>
		<button class="button button1" onclick="rstpass()" id="resetButton">Reset</button>
		</div>
	<!--For user authentication. Must paste into every file you want to be protected on the server. Probably would be easier to include all of this in a js file and im    port it. -->
<script src="https://www.gstatic.com/firebasejs/5.1.0/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyC-bT_S5pW2DtcdHp0uonvfKGKoZFqbkHQ",
    authDomain: "dblogin-13589.firebaseapp.com",
    databaseURL: "https://dblogin-13589.firebaseio.com",
    projectId: "dblogin-13589",
    storageBucket: "dblogin-13589.appspot.com",
    messagingSenderId: "689944907277"
  };
  firebase.initializeApp(config);
</script>

<script>
//Handle Account Status
firebase.auth().onAuthStateChanged(user => {
if(!user) {
	location.replace('/index.html'); //If User is not logged in, redirect to login page
}
else {
	document.body.style.display="block";
}
		});
</script>
<body style="display:none">
<!-- End user authentication -->

	<!-- Reset function that sends an email to the currently logged in user to reset their password hehe -->
<script>
function rstpass()
{
	var auth = firebase.auth();
	var user = firebase.auth().currentUser;
	var emailAddress = user.email;
	console.log(emailAddress);
	auth.sendPasswordResetEmail(emailAddress).then(function() {
		// Email sent.
		window.alert("Email has been sent.");
		console.log("EMAIL SENT");
		location.replace('/index.html');
	}).catch(function(error) {
		// Error sending email has happened
		console.log(error);
	});
}
</script>
	</body>
</html>
