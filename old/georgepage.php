
<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Refugee Database Server</h1>


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
<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>

    <tr>
      <td>
        ID <br>
        <input type="text" name="id" maxlength="90" size="30" />
      </td>
    </tr>

    <td>
	First Name <br>
        <input type="text" name="Name" maxlength="45" size="30" />
      </td>
    </tr>

    <tr>
      <td>
        Last Name <br>
        <input type="text" name="lastName" maxlength="90" size="30" />
      </td>    </tr>

    <tr>
      <td>
	Address <br>
        <input type="text" name="Address" maxlength="90" size="30" />
      </td>
    </tr>

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
    
    <td>
        <input type="submit" value="Add Data" />
      </td>

    </tr>
  </table>
</form>

<!-- delete entry -->
<td> Delete by ID </td>
<form method="post" action="">
<input type="text" name="delname">
<input type="submit" value="Delete" />
</form>


<td>Search by</td>
 <form action="search6.php?go" method="post">
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
 </form>



<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
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
       "<td> <a href=viewInfo.php?idd=$query_data[0]> View Info </a> </td>",
       "<td> <a href=editPage.php?idd=$query_data[0]> Edit </a> </td>",
       "<td> <a href=delete2.php?idd=$query_data[0]> Delete </a> </td>";

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
         `NumMen` varchar(90) DEFAULT NULL,
         `NumWomen` varchar(90) DEFAULT NULL,
         `NumBoys` varchar(90) DEFAULT NULL,
         `NumGirls` varchar(90) DEFAULT NULL,
         `BoyAge` varchar(90) DEFAULT NULL,
         `GirlAge` varchar(90) DEFAULT NULL,
         `Notes` varchar(200) DEFAULT NULL,
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
