<?php include "../inc/dbinfo.inc"; ?>
<html>
<head>
<title> 
	Refugee Database
</title>
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style> 

</style>
</head>
<body>
<div id="wrapper">
<!--logout button -->
<div class="button">
	<button onclick="location.href = '/index.html';" id="myButton" class="float-right submit-button">Logout</button>
</div>

<div class="image">
  <img src="../icons/nwicon.png">
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


<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

//a database or something?
$database = mysqli_select_db($connection, DB_DATABASE);

/* Ensure that the Employees table exists. 
VerifyEmployeesTable($connection, DB_DATABASE); 
*/
/* variables for personal details */
$employee_name = htmlentities($_POST['Name']);
$employee_address = htmlentities($_POST['Address']);
$lastname = $_POST['lastName'];
$origin = htmlentities($_POST['originCountry']);
$phone = htmlentities($_POST['Phone']);
$number_family = htmlentities($_POST['NumFamily']);
$visits_before = htmlentities($_POST['numVisit']);
$Id = htmlentities($_POST['id']);

//gets name for deletion
$delname = $_POST['delname'];
//gets name for search
$search_name = htmlentities($_POST['searchname']);

//adds person to database
if (strlen($employee_name) || strlen($employee_address)) {
  AddEmployee($connection, $employee_name, $employee_address, $lastname, $origin, $phone, $number_family, $visits_before, $Id);
}
//deletes person from database
if (strlen($delname))
{
  DeletePerson($connection, $delname); 
}
?>
<!-- Add person 
<td> Add by First Name </td>-->
<div class="addrelative" id="one">
	<div style="width:1000px;">
		<div style="float: left; ">
			<form method="post" action='inputPage.php?' inputname="whats">
				<!--<input type="text" name="personName">-->
				<input type="submit" name="submit"value="Add Person">
			</form>  
		</div>
	</div>
	<!-- delete entry 
	<td> Delete by ID </td>
	<form method="post" action="">
		<input type="text" name="delname">
		<input type="submit" value="Delete" />
	</form> -->
	<!-- search entry -->
	<div style="float: right;">
		<form action="search6.php?go" method="post">
			Search by
			<select name="searchOptions">
				<option value="ID">ID</option>
				<option value="name">Name</option>
				<option value="lastName">Last Name</option>
				<option value="countryOfOrigin">Country of Origin</option>
				<option value="phone">Phone</option>
				<option value="allOptions">All</option>
			</select>
			<input type="text" name="search" id="s1">
			<input type="submit" name="submit" value="Search" id="s2"> 
		</form>
	</div>
</div>

<td> <a href='statistics.php'> View Statistics </a></td>


<!-- Display table data. -->
<div class="tablerelative" id="three">
	<table border="0" cellpadding="2" cellspacing="2" >
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Last Name</th>
		<th>Country of Origin</th>
		<th>Phone</th>
		<th>View Info</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>

	<?php
	$result = mysqli_query($connection, "SELECT * FROM Employees7"); 
	//fills in table with data from SQL server
	while($query_data = mysqli_fetch_row($result)) 
	{   
		echo "<tr>";
		echo "<td>",$query_data[0], "</td>",
			  "<td>",$query_data[1], "</td>",
			  "<td>",$query_data[3], "</td>",
			  "<td>",$query_data[4], "</td>",
			  "<td>",$query_data[5], "</td>",
			  "<td> <a href='viewInfo2.php?idd=$query_data[0]'> <i class='fa fa-search' aria-hidden='true'></i> </a> </td>",
		  	  "<td> <a href='editPage.php?idd=$query_data[0]'><i class='fa fa-pencil' aria-hidden='true'></i> </a> </td>",
		  	  "<td> <a href='delete2.php?idd=$query_data[0]'> <i class='fa fa-trash' aria-hidden='true'></i> </a> </td>";
		echo "</tr>";
	}
	?>
	</table>
</div>

<!-- Clean up. -->
<?php

mysqli_free_result($result);
mysqli_close($connection);

?>


</body>
</html>


<?php

/* Add an employee to the table. */
function AddEmployee($connection, $name, $address, $lastName, $originCountry, $phone, $numberFamily, $numberVisits, $id) {
  $n = mysqli_real_escape_string($connection, $name);
  $a = mysqli_real_escape_string($connection, $address);

  $l = mysqli_real_escape_string($connection, $lastName);
  $o = mysqli_real_escape_string($connection, $originCountry);
  $p = mysqli_real_escape_string($connection, $phone);
  $numf = mysqli_real_escape_string($connection, $numberFamily);
  $numv = mysqli_real_escape_string($connection, $numberVisits);
  $i = mysqli_real_escape_string($connection, $id);

  $query = "INSERT INTO `Employees7` (ID, Name, Address, LastName, OriginCountry, Phone, NumberOfFamily, VisitsBefore) VALUES ('$i', '$n', '$a', '$l', '$o', '$p', '$numf', '$numv');";


  if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

/* Check whether the table exists and, if not, create it. */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("Employees7", $connection, $dbName)) 
  { 
	 echo("<p> custom error. table does not exist</p>");

	 $query = "CREATE TABLE `Employees7` (
		  `ID` varchar(11) DEFAULT NULL,
		  `Name` varchar(45) DEFAULT NULL,
		  `Address` varchar(90) DEFAULT NULL,
		  `LastName` varchar(90) DEFAULT NULL,
		  `OriginCountry` varchar(90) DEFAULT NULL,
		  `Phone` varchar(90) DEFAULT NULL,
		  `NumberOfFamily` varchar(90) DEFAULT NULL,
		  `VisitsBefore` varchar(90) DEFAULT NULL,
		  `NumMen` varchar(90) DEFAULT NULL,
		  `NumWomen` varchar(90) DEFAULT NULL,
		  `NumBoys` varchar(90) DEFAULT NULL,
		  `NumGirls` varchar(90) DEFAULT NULL,
		  `Notes` varchar(200) DEFAULT NULL,
		  `Pregnant` varchar(90) DEFAULT NULL,
		  `RegistrationDate` varchar(90) DEFAULT NULL,
		  PRIMARY KEY (`ID`),
		  UNIQUE KEY `ID_UNIQUE` (`ID`)
		  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

	 if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection, 
		"SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}

/* delete someone from table */
function DeletePerson($connection, $name)
{

  //echo $name; // echo name for debug purposes
  if (strlen($name))
  {
	 $query = "DELETE FROM Employees7 WHERE ID='$name'";
  }

  if(!mysqli_query($connection, $query)) echo("<p>Error deleting data.</p>");

}

?>
</div>
