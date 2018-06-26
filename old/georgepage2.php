
<?php include "../inc/dbinfo.inc"; ?>
<html>
<head>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>james Sample page</h1>


<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  /* Ensure that the Employees table exists. */
  VerifyEmployeesTable($connection, DB_DATABASE); 

  /* If input fields are populated, add a row to the Employees table. */
  $employee_name = htmlentities($_POST['Name']);
  $employee_address = htmlentities($_POST['Address']);

  $lastname = $_POST['lastName'];
  $origin = htmlentities($_POST['originCountry']);
  $phone = htmlentities($_POST['Phone']);
  $number_family = htmlentities($_POST['NumFamily']);
  $visits_before = htmlentities($_POST['numVisit']);
  $Id = htmlentities($_POST['id']);

  $delname = $_POST['delname'];

  if (strlen($employee_name) || strlen($employee_address)) {
    AddEmployee($connection, $employee_name, $employee_address, $lastname, $origin, $phone, $number_family, $visits_before, $Id);
  }
  if (true)
  {
	  DeletePerson($connection, $delname); 
  }

?>
<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>

    <td>
	First Name <br>
        <input type="text" name="Name" maxlength="45" size="30" />
      </td>
    </tr>

    <tr>
      <td>
	Address <br>
        <input type="text" name="Address" maxlength="90" size="30" />
      </td>
    </tr>

    <tr>
      <td>
        Last Name <br>
        <input type="text" name="lastName" maxlength="90" size="30" />
      </td>    </tr>

    <tr>
      <td>
        Country of Origin <br>
        <input type="text" name="originCountry" maxlength="90" size="30" />
      </td>
    </tr>

    <tr>
      <td>
        Phone <br>
        <input type="text" name="Phone" maxlength="90" size="30" />
      </td>
    </tr>

    <tr>
      <td>
        Number of Family Members <br>
        <input type="text" name="NumFamily" maxlength="90" size="30" />
      </td>
    </tr>

	<!-- NEED TO ADD IN OPTION TO SELECT SPECIFIC NUMBER OF FAMILY MEMBERS. DROP DOWN MENU FOR MALE, FEMALE, AGE, ETC -->

    <tr>
      <td>
        Visits before 04/22/17 <br>
        <input type="text" name="numVisit" maxlength="90" size="30" />
      </td>
    </tr>

    <tr>
      <td>
        ID <br>
        <input type="text" name="id" maxlength="90" size="30" />
      </td>
    </tr>
    
    <td>
        <input type="submit" value="Add Data" />
      </td>

    </tr>
  </table>
</form>

<!-- delete entry -->
<td> Delete by name </td>
<form method="post" action="">
<input type="text" name="delname">
<input type="submit" value="Delete" />
</form>

<!-- search entry -->
<td> Search by ID </td>
<form method="post" action="search3.php?go" id="searchform">
<input type="text" name="search">
<input type="submit" name="submit"value="Search" />
</form>


<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>Name</td>
    <td>Address</td>
    <td>Last Name</td>
    <td>Country of Origin</td>
    <td>Phone</td>
    <td>Number of Family Members</td>
    <td>Visits before 04/22/17</td>
    <td>Edit</td>
  </tr>

<?php

$result = mysqli_query($connection, "SELECT * FROM Employees6"); 

while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>",
       "<td>",$query_data[3], "</td>",
       "<td>",$query_data[4], "</td>",
       "<td>",$query_data[5], "</td>",
       "<td>",$query_data[6], "</td>",
       "<td>",$query_data[7], "</td>",
       "<td> <input type=submit value=Edit> </td>";

  echo "</tr>";
}
?>

</table>

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
         PRIMARY KEY (`ID`),
         UNIQUE KEY `ID_UNIQUE` (`ID`)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}
//check if table exists
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
   echo $name;
   $query = "DELETE FROM Employees6 WHERE Name='$name'";

   if(!mysqli_query($connection, $query)) echo("<p>Error deleting data.</p>");

}

function EditPerson($name)
{
	echo("I'm here");

}
?>
