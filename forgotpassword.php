<html>
	<head>
		<title> Forgot password</title>
		<link rel="stylesheet" type="text/css" href="styles1.css">
	</head>
	<body>
		<h1><b>Forgot your password?</b></h1>
		Type your email to receive instructions on resetting your password.<br><br>
		<input type="text" id="email_field" maxlength="90" size="30" /> <br>
		<br>
		<button onclick="forgotpass()" id="forgotButton">Send</button>
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

		<!-- Reset function that sends an email to the currently logged in user to reset their password hehe -->
		<script>
		function forgotpass()
		{
			var auth = firebase.auth();
			var emailAddress = document.getElementById("email_field").value;
			console.log(emailAddress);
			auth.sendPasswordResetEmail(emailAddress).then(function() {
				// Email sent.
				window.alert("Email has been sent to " + emailAddress + ". If you have not received an email, please verify that your email has been typed correctly.");
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
