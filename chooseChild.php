<?php 
include "../inc/dbinfo.inc"; ?>
<html>
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
<!--For user authentication. Must paste into every file you want to be protected on the server. Probably would be easier to include all of this in a js file and im    port it. -->
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
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
<h1>Select Child</h1>


<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
date_default_timezone_set('America/Chicago');
/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

//a database or something?
$database = mysqli_select_db($connection, DB_DATABASE);
$db=mysql_connect  ("tutorial-db-instance.cl2lz81okayq.us-east-2.rds.amazonaws.com", "tutorial_user",  "password") or die ('I cannot connect to the database  because: ' . mysql_error());

$mydb=mysql_select_db("sample");
//variables for children table
$ID1 = $_GET['parID'];
$ID2 = htmlentities($_POST['parentID']);
$child_name = htmlentities($_POST['boyname']);
$bday= strtotime($_POST["bday"]);
$bday= date('Y-m-d H:i:s', $bday);
$gender = htmlentities($_POST['gender']);
$diaper = htmlentities($_POST['diaperOptions']);
//gets name for deletion
$delname = $_POST['delname'];

//gets name for search


//echo $ID1;
$sql="SELECT * FROM Children WHERE parentID='$ID1'";

$result = mysql_query($sql);
$num = mysql_num_rows($result);

echo $child_name;
/*adds person to database
if (strlen($Id)) {
	AddEmployee($connection, $employee_name, $employee_address, $lastname, $origin, $phone, $number_family, $visits_before, $Id, $num_men, $num_women, $num_boys, $num_girls, $boy_age, $girl_age, $diaper_size, $notes, $pregnant, $registration);
	echo $employee_name . " " . $lastname . " has been added";
	//header('Location: jamesPage.php');
}
 */

if(isset($_POST['Add']))
{
	header("Location: addChild.php?parID=$ID1");
}

?>
<!-- back -->
<form method="post" action="currentversion.php?go" id="searchform">
<input type="submit" name="submit"value="Back to Homepage"/>


</form>
<form method="POST">
	<td>
		<input type="submit" name="Add" value="Add Child" />
	</td>
</form>

<!-- Display table data. -->
<table border="0" cellpadding="2" cellspacing="2">
	<tr>
		<th>Name</th>
		<th>Birthday</th>
		<th>Sex</th>
		<th>Diaper</th>
		<th>Edit</th>		
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
			<?php echo "<td> <a href='editChild.php?parID=$f0&childname=$f1'><i class='fa fa-pencil' aria-hidden='true'></i> </a> </td>";?>	 
		</tr>
		<?php
		$i++;
	}
	/*$result = mysqli_query($connection, "SELECT * FROM Children"); 
	fills in table with data from SQL server
	while($query_data = mysqli_fetch_row($result)) {
		echo "<tr>";
		echo "<td>",$query_data[0], "</td>",
	  		  "<td>",$query_data[1], "</td>",
			  "<td>",$query_data[2], "</td>",
			  "<td>",$query_data[3], "</td>",
			  "<td>",$query_data[4], "</td>",
			  "<td> <a href='editPage.php?idd=$query_data[0]'><i class='fa fa-pencil' aria-hidden='true'></i> </a> </td>";	
		echo "</tr>";
	}
	 */
	?>
	
</table>

<!-- Clean up. -->
<?php
mysqli_free_result($result);
mysqli_close($connection);
?>

</body>
</html>


