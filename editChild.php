<?php 
include "../inc/dbinfo.inc"; ?>
<html>
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
<h1>Edit Child</h1>


<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
date_default_timezone_set('America/Chicago');
/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

$database = mysqli_select_db($connection, DB_DATABASE);

$db=mysql_connect  ("tutorial-db-instance.cl2lz81okayq.us-east-2.rds.amazonaws.com", "tutorial_user",  "password") or die ('I cannot connect to the database  because: ' . mysql_error());

$mydb=mysql_select_db("sample");
/* Ensure that the Employees table exists. 
VerifyEmployeesTable($connection, DB_DATABASE); 
*/
/* variables for personal details 
$employee_name_in = '';
$employee_name_in = $_POST['personName'];
//  echo "a " . $employee_name_in . " b";

$employee_name = htmlentities($_POST['Name']);
$employee_address = htmlentities($_POST['Address']);
$lastname = $_POST['lastName'];
$origin = htmlentities($_POST['originCountry']);
$phone = htmlentities($_POST['Phone']);
$number_family = htmlentities($_POST['NumFamily']);
$visits_before = htmlentities($_POST['numVisit']);
$Id = htmlentities($_POST['id']);

$num_men = htmlentities($_POST['nummen']);
$num_women = htmlentities($_POST['numwomen']);
$num_boys = htmlentities($_POST['numboys']);
$num_girls = htmlentities($_POST['numgirls']);
$boy_age = htmlentities($_POST['boyage']);
$girl_age = htmlentities($_POST['girlage']);
$diaper_size = htmlentities($_POST['diaperOptions']);
$notes = htmlentities($_POST['notes']);

$pregnant = htmlentities($_POST['pregnant']);
$registration = htmlentities($_POST['date']);
*/
//variables for children table
$ID1 = $_GET['parID'];
$getname = $_GET['childname'];
//echo $ID1;
//echo $getname;
$ID2 = htmlentities($_POST['parentID']);
$child_name = htmlentities($_POST['boyname']);
$bday= strtotime($_POST["bday"]);
$bday= date('Y-m-d H:i:s', $bday);
$gender = htmlentities($_POST['gender']);
$diaper = htmlentities($_POST['diaperOptions']);
$ogname = htmlentities($_POST['hname']);
//gets name for deletion
$delname = $_POST['delname'];

//Select Children table 
$sql="SELECT * FROM Children WHERE parentID='$ID1' AND name='$getname'";
$result = mysql_query($sql);
$num = mysql_num_rows($result);
$i=0;
while($i<$num)
{	
	$match1= mysql_result($result, $i, "parentID");	
	$match2= mysql_result($result, $i, "name");
	if($match=$ID1 AND $match2=$getname)
	{
		$ID2 = mysql_result($result, $i, "parentID");
		$name = mysql_result($result, $i, "name");
		$bday = mysql_result($result, $i, "birthday");
		$gender = mysql_result($result, $i, "gender");
		$diaper = mysql_result($result, $i, "DiaperSize");
	}	
	$i++;
}
//echo $bday;
//echo $child_name;

?>
<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
	Edit a child   
	<br>
	<input type="hidden" name="parentID" maxlength="90" value='<?=$ID2?>' readonly size="30" >
	<input type="hidden" name="hname" maxlength="90" value='<?=$name?>' readonly size="30" >
	<input type="text" name="boyname" maxlength="90" value='<?=$name?>' size="30"/>
	<input type="date" name="bday" value='<?=$bday?>'/>
	<select name="gender">
	<option selected='<?=$gender?>'><?=$gender?></option>
		<option value="Male">Male</option>
		<option value="Female">Female</option>
	</select>
	<br>
	<br>
	Diaper Size
	<br>
	<select name="diaperOptions">
		<option selected='<?=$diaper?>'><?=$diaper?></option>
		<option value="None">None</option>
		<option value="Newborn">Newborn</option>
      <option value="Size 1">Size 1</option>
      <option value="Size 2">Size 2</option>
      <option value="Size 3">Size 3</option>
      <option value="Size 4">Size 4</option>
      <option value="Size 5">Size 5</option>
      <option value="Size 6">Size 6</option>
	</select>
	<br>
	<br>
	<input type="submit" name="editchild" value ="Edit Child"/>	
	<br>
</form>

<?php
if(isset($_POST['editchild']))
{	
	$i = mysqli_real_escape_string($connection, $ID2);
	$n = mysqli_real_escape_string($connection, $child_name);
	$g = mysqli_real_escape_string($connection, $gender);
	$d = mysqli_real_escape_string($connection, $diaper);
	$ogn = mysqli_real_escape_string($connection, $ogname);
	$query="UPDATE Children SET name='$n', birthday='$bday', gender='$g',DiaperSize='$d' WHERE parentID = '$ID2' AND name = '$ogname'";
	if(!mysqli_query($connection, $query)) 
	{	
		echo("<p>Error adding child data.</p>");
	}
	else
	{
		header("Location: chooseChild.php?parID=$ID2");
	}	
}
?>
<!-- back -->
<form method="post" action="currentversion.php?go" id="searchform">
<input type="submit" name="submit"value="Back to Homepage" />
</form>

<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
	<tr>
		<th>Name</th>
		<th>Birthday</th>
		<th>SEX</th>
		<th>Diaper</th>
		<th>Delete</th>		
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
			<?php echo "<td> <a href='delete.php?idd=$f0&childname=$f1'> <i class='fa fa-trash' aria-hidden='true'></i> </a> </td>";?>	 
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


