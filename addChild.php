<?php 
include "../inc/dbinfo.inc"; ?>
<html>
<header>
	<title>
		Add Child
	</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</header>
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

<h1>Add a Child</h1>


<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
date_default_timezone_set('America/Chicago');
/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

//a database or something?
$database = mysqli_select_db($connection, DB_DATABASE);

$db=mysql_connect  ("tutorial-db-instance.cl2lz81okayq.us-east-2.rds.amazonaws.com", "tutorial_user",  "password") or die ('I cannot connect to the databas    e  because: ' . mysql_error());

$mydb=mysql_select_db("sample");

$ID1 = $_GET['parID'];
$ID2 = htmlentities($_POST['parentID']);
$child_name = htmlentities($_POST['boyname']);
$bday= strtotime($_POST["bday"]);
$bday= date('Y-m-d H:i:s', $bday);
$gender = htmlentities($_POST['gender']);
$diaper = htmlentities($_POST['diaperOptions']);
//gets name for deletion
$delname = $_POST['delname'];

$sql="SELECT * FROM Children WHERE parentID='$ID1'";
 
$result = mysql_query($sql);

$num = mysql_num_rows($result);



?>
<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">   
	<input type="hidden" name="parentID" maxlength="90" value='<?=$ID1?>' readonly size="30" >
	<input type="text" name="boyname" maxlength="90" size="30"/>
	<input id="datefield" type="date" name="bday" max="2018-12-31"/>
	<!--Sets the max date a child can be born to the current date -->
	<script>
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0
	var yyyy = today.getFullYear();
 	if(dd<10){
		dd='0'+dd
	} 
	if(mm<10){
		mm='0'+mm
	} 
	today = yyyy+'-'+mm+'-'+dd;
	document.getElementById("datefield").setAttribute("max", today);
	</script>
	<select name="gender">
		<option value="Male">Male</option>
		<option value="Female">Female</option>
	</select>
	<br>
	<br>
	Diaper Size
	<br>
   <select name="diaperOptions">
		<option value="None">None</option>
		<option value="Newborn">Newborn</option>
      <option value="Size 1">1</option>
      <option value="Size 2">2</option>
      <option value="Size 3">3</option>
      <option value="Size 4">4</option>
      <option value="Size 5">5</option>
      <option value="Size 6">6</option>
	</select>
	<br>
	<br>
	<input type="submit" name="addchild" value ="Add Child"/>	
	<br>
</form>

<?php
if(isset($_POST['addchild']))
{	
	$i = mysqli_real_escape_string($connection, $ID2);
	$n = mysqli_real_escape_string($connection, $child_name);
	$g = mysqli_real_escape_string($connection, $gender);
	$d = mysqli_real_escape_string($connection, $diaper);
	$query = "INSERT INTO `Children` (parentID, name, birthday, gender, DiaperSize) VALUES ('$i', '$n', '$bday', '$g', '$d');";	
	$query2 = "SELECT * FROM Employees7 WHERE ID='$ID2'";
	$resultsss=mysql_query($query2);
	$numrows =mysql_num_rows($resultsss);
	$pls = 0;
	$n2 = mysql_result($resultsss, $pls, "NumBoys");
	$n1 = mysql_result($resultsss, $pls, "NumGirls");
	if($g == "Female")
	{
		$n1 += 1;
		$query3 = "UPDATE `Employees7` SET NumGirls = '$n1' WHERE ID='$i'";
	}
	else
	{
		$n2 += 1;
		$query3 = "UPDATE `Employees7` SET NumBoys = '$n2' WHERE ID='$i'";
	}
	if(!mysqli_query($connection, $query3))
	{
		echo("<p>Error updating num children.</p>");
	}
	if(!mysqli_query($connection, $query)) 
	{	
		echo("<p>Error adding child data.</p>");
	}
	else
	{
		header("Location: addChild.php?parID=$ID2");
	}	
}
?>
<!-- back -->
<form method="post" action="currentversion.php?go" id="searchform">
<input type="submit" name="submit"value="Back to Homepage" />
</form>

<!-- Display table data. -->
<table border="0" cellpadding="2" cellspacing="2">
	<tr>
		<th>Name</th>
		<th>Birthday</th>
		<th>Sex</th>
		<th>Diaper</th>
	</tr>


	<?php
	
	$i=0;
	while($i<$num)
   {
      $f0 = mysql_result($result, $i, "parentID");
      $f1 = mysql_result($result, $i, "name");
      $f2 = mysql_result($result, $i, "birthday");
      $f3 = mysql_result($result, $i, "gender");
      $f4 = mysql_result($result, $i, "DiaperSize");
	 	?>
      <tr>
         <td><?php echo $f1; ?></td>
         <td><?php echo $f2; ?></td>
         <td><?php echo $f3; ?></td>
         <td><?php echo $f4; ?></td>
      </tr>
      <?php
		$i++;    
	}


	/*$result = mysqli_query($connection, "SELECT * FROM Children"); 
	//fills in table with data from SQL server
	while($query_data = mysqli_fetch_row($result)) {
		echo "<tr>";
		echo "<td>",$query_data[0], "</td>",
	  		  "<td>",$query_data[1], "</td>",
			  "<td>",$query_data[2], "</td>",
			  "<td>",$query_data[3], "</td>",
			  "<td>",$query_data[4], "</td>";
		echo "</tr>";
	}*/
?>
</table>




<!-- Clean up. -->
<?php
mysqli_free_result($result);
mysqli_close($connection);
?>

</body>
</html>


