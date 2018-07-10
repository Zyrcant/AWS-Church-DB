<?php include "../inc/dbinfo.inc"; ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles.css">

<script type='text/javascript'>
function confirmDelete()
{
	return confirm("Are you sure you want to delete this?");
}
</script>
</head>
<body>
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

<h1 align="center">Delete a Child</h1>


<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$id = $_GET['idd'];
//debug
//echo $id;

/* Connect to MySQL and select the database. */ 
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

$database = mysqli_select_db($connection, DB_DATABASE);


$db=mysql_connect  ("tutorial-db-instance.cl2lz81okayq.us-east-2.rds.amazonaws.com", "tutorial_user",  "password") or die ('I cannot connect to the databas    e  because: ' . mysql_error());
$mydb=mysql_select_db("sample");

//deletes the person
DeletePerson($connection, $id);
//deletesomeone($connection, $id);
//returns to home page
//header('Location: currentversion.php');
//exit;

if(isset($_POST['deleted']))
{
	//A child died
	$id=$_GET['idd'];
	$getname=$_GET['childname'];
	$query = "DELETE From Children WHERE parentID='$id' AND name = '$getname'";
	$result2=mysqli_query($connection, $query);
	//Decrement children when deleted
	$query2 = "SELECT * FROM Employees7 WHERE ID='$id'";
   $resultsss=mysql_query($query2);
	$pls = 0;
	$g = $_GET['genderofchild'];
	$n1 = mysql_result($resultsss, $pls, "NumGirls");
	$n2 = mysql_result($resultsss, $pls, "NumBoys");
   if($g == "Female")
   {
      $n1 -= 1;
      $query3 = "UPDATE `Employees7` SET NumGirls ='$n1' WHERE ID='$id'";
   }
   else
   {
		$n2 -= 1;
      $query3 = "UPDATE `Employees7` SET NumBoys ='$n2' WHERE ID='$id'";
   }
	if(!mysqli_query($connection, $query3))
	{
		echo("Error updating num cildren");
	}

	array_map('unlink', glob("uploads/" . $id .".jpg"));
	header('Location: currentversion.php');
	exit;
}

?>
<form name="form2" action="currentversion.php?go" method="post">
	<table border=0; cellpadding="1" cellcpasing="1" bgcolor="" align="center">
		<div style=text-align:center;margin-top:20px;>
			<input type="submit" name="back" value="Go back">
		</div>
</form>

<form name="form1" action="" method="post"> 
	<table border=0; cellpadding="1" cellspacing="1" bgcolor="" align="center" > 
		<div style=text-align:center;margin-top:20px;> 
			<input type="submit" name="deleted" value="Delete" onclick="return confirmDelete()"> 
		</div> 
</form>


</body>
</html>


<?php

/* delete someone from table */
function DeletePerson($connection, $idd)
{

	//echo $name; // echo name for debug purposes if you get ID from link
	if (strlen($idd))
	{
?>	
		<script>
		function deleletconfig()
		{
			var del=confirm("Are you sure want to delete this record?");
			if(del==true)
			{
				alert ("Record has been deleted")
			}
			else
			{
				alert("Record Not deleted")
			}
			return del;
		}
		</script>
<?php
	}
}
?>
