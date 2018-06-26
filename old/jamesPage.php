
<?php include "../inc/dbinfo.inc"; ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles1.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style> 

</style>
</head>
<body>
<script src="https://www.gstatic.com/firebasejs/5.0.4/firebase.js"></script>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyDKjsEDFbAezJnvIaggsKjiNrNaNRHXJ_k",
    authDomain: "refugeedblogin.firebaseapp.com",
    databaseURL: "https://refugeedblogin.firebaseio.com",
    projectId: "refugeedblogin",
    storageBucket: "refugeedblogin.appspot.com",
    messagingSenderId: "916804553903"
  };
  firebase.initializeApp(config);
</script>

<script>
//Handle Account Status
firebase.auth().onAuthStateChanged(user => {
  if(!user) {
    location.replace('/index.html'); //If User is not logged in, redirect to login page
  }
  else
  {
    document.body.style.display="block";
  }
});
</script>
<body style="display:none">
<h1 align="center">Refugee Database Server</h1>


<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

//a database or something?
$database = mysqli_select_db($connection, DB_DATABASE);

/* Ensure that the Employees table exists. */
VerifyEmployeesTable($connection, DB_DATABASE); 

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
<form method="post" action='inputPage.php?' inputname="whats">
<!--<input type="text" name="personName">-->
	<div class="relative">
		<input type="submit" name="submit"value="Add Person">
	</div>
</form>  

<!-- delete entry 
<td> Delete by ID </td>
<form method="post" action="">
<input type="text" name="delname">
<input type="submit" value="Delete" />
</form> -->

<!-- search entry -->

<form action="search6.php?go" method="post">
<div class="relative1">
Search by
<select name="searchOptions">
<option value="ID">ID</option>
<option value="name">Name</option>
<option value="lastName">Last Name</option>
<option value="countryOfOrigin">Country of Origin</option>
<option value="phone">Phone</option>
<option value="allOptions">All</option>
</select>
<input type="text" name="search">
<input type="submit" name="submit" value="Search"> 
</div>
</form>



<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2" align="center">
<tr>
<td>ID</td>
<td>Name</td>
<td>Last Name</td>
<td>Country of Origin</td>
<td>Phone</td>
<td>View Info</td>
<td>Edit</td>
<td>Delete</td>
</tr>



<?php

$result = mysqli_query($connection, "SELECT * FROM Employees6"); 
//fills in table with data from SQL server
while($query_data = mysqli_fetch_row($result)) {
   
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
		 "<td>",$query_data[1], "</td>",
		 "<td>",$query_data[3], "</td>",
		 "<td>",$query_data[4], "</td>",
		 "<td>",$query_data[5], "</td>",
		 "<td> <a href='viewInfo.php?idd=$query_data[0]'> <i class='fa fa-search' aria-hidden='true'></i> </a> </td>",
		 "<td> <a href='editPage.php?idd=$query_data[0]'><i class='fa fa-pencil' aria-hidden='true'></i> </a> </td>",
		 "<td> <a href='delete2.php?idd=$query_data[0]'> <i class='fa fa-trash' aria-hidden='true'></i> </a> </td>";
		  			

  echo "</tr>";
}
?>

</table>

<td> <a href='statistics.php'> View Statistics </td>
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

  $query = "INSERT INTO `Employees6` (ID, Name, Address, LastName, OriginCountry, Phone, NumberOfFamily, VisitsBefore) VALUES ('$i', '$n', '$a', '$l', '$o', '$p', '$numf', '$numv');";


  if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

/* Check whether the table exists and, if not, create it. */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("Employees6", $connection, $dbName)) 
  { 
	 echo("<p> custom error. table does not exist</p>");

	 $query = "CREATE TABLE `Employees6` (
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
		  `BoyAge` varchar(90) DEFAULT NULL,
		  `GirlAge` varchar(90) DEFAULT NULL,
		  `DiaperSize` varchar(90) DEFAULT NULL,
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
	 $query = "DELETE FROM Employees6 WHERE ID='$name'";
  }

  if(!mysqli_query($connection, $query)) echo("<p>Error deleting data.</p>");

}

?>
