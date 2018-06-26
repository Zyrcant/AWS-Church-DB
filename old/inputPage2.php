<?php include "../inc/dbinfo.inc"; ?>
<html>
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>
<!--For user authentication. Must paste into every file you want to be protected on the server. Probably would be easier to include all of this in a js file and im    port it. -->
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
else {
	document.body.style.display="block";
}
});
</script>
<body style="display:none">
<!-- End user authentication -->
<h1>Insert Person</h1>


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

//gets name for deletion
$delname = $_POST['delname'];
//gets name for search
$search_name = htmlentities($_POST['searchname']);

//adds person to database
if (strlen($Id)) {
	AddEmployee($connection, $employee_name, $employee_address, $lastname, $origin, $phone, $number_family, $visits_before, $Id, $num_men, $num_women, $num_boys, $num_girls, $boy_age, $girl_age, $diaper_size, $notes, $pregnant, $registration);
	echo $employee_name . " " . $lastname . " has been added";
	//header('Location: jamesPage.php');
}
?>
<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
	<td>
		ID <br>
		<input type="text" name="id" maxlength="90" size="30"/><br>
	</td>
	<td>
		First Name <br>
	  <input type="text" name="Name" maxlength="45" value='<?=$employee_name_in?>' size="30"/><br>
	</td>
	<td>
		Last Name <br>
	  <input type="text" name="lastName" maxlength="90" size="30"/><br>
	</td>    
	<td>
		Address (123 Rainbow Road) <br>
		<input type="text" name="Address" maxlength="90" size="30"/><br>
	</td>
	<td>
		Country of Origin (USA, Syria, etc.)<br>
		<input type="text" name="originCountry" maxlength="90" size="30"/><br>
	</td>
	<td>
		Phone (xxx-xxx-xxxx)<br>
		<input type="text" name="Phone" maxlength="90" size="30"/><br>
	</td>
	<td>
		Date of Registration (MM/DD/YYYY)<br>
		<input type="text" name="date" maxlength="90" size="30"/><br>
	</td>
	<td>
	<!--
		  Number of Family Members (0, 1, 2...)<br>
		  <input type="text" name="NumFamily" maxlength="90" size="30" />
	-->
	Number of Family Members<br>
	<select name="NumFamily">
		<option value="0">0</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
		<option value="16">16</option>
 	   <option value="17">17</option>
		<option value="18">18</option>
		<option value="19">19</option>
		<option value="20">20</option>
	</select><br>
	</td>
	<td>
	<!--
		  Visits before 04/22/17 (0, 1, 2...) <br>
		  <input type="text" name="numVisit" maxlength="90" size="30" />
	-->
	Visits before 04/22/17<br>
	<select name="numVisit">
		<option value="0">0</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
	</select><br>
	</td>
	<td>
	<!--
		  Number of Men (0, 1, 2...)<br>
		  <input type="text" name="nummen" maxlength="90" size="30" />
	-->
	Number of Men<br>
	<select name="nummen">
		<option value="0">0</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
	</select><br>
	</td>
	<td>
	<!--
		  Number of Women (0, 1, 2...)<br>
		  <input type="text" name="numwomen" maxlength="90" size="30" />
	-->
	Number of Women<br>
	<select name="numwomen">
		<option value="0">0</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
	</select><br>
	</td>
	<td>
		  <!--
	Number of Boys (0, 1, 2...)<br>
		  <input type="text" name="numboys" maxlength="90" size="30" />
	-->
	Number of Boys<br>
	<select name="numboys">
		<option value="0">0</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
		<option value="11">11</option>
	 	<option value="12">12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
	</select><br>
	</td>
	<td>
	<!--
		  Number of Girls (0, 1, 2...)<br>
		  <input type="text" name="numgirls" maxlength="90" size="30" />
	-->
	Number of Girls<br>
	<select name="numgirls">
		<option value="0">0</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
	</select><br>
	</td>

	<td>
	<!--
		  Age of Boys (0, 1, 2...)<br>
		  <input type="text" name="boyage" maxlength="90" size="30" />
	-->
	Age of Boys<br>
	<select name="boyage">
		  <option value="0">0</option>
		  <option value="1">1</option>
		  <option value="2">2</option>
		  <option value="3">3</option>
		  <option value="4">4</option>
		  <option value="5">5</option>
		  <option value="6">6</option>
		  <option value="7">7</option>
		  <option value="8">8</option>
		  <option value="9">9</option>
		  <option value="10">10</option>
		  <option value="11">11</option>
		  <option value="12">12</option>
		  <option value="13">13</option>
		  <option value="14">14</option>
		  <option value="15">15</option>
		  <option value="16">16</option>
		  <option value="17">17</option>
		  <option value="18">18</option>
	</select><br>
	</td>

	<td>
	<!--
		  Age of Girls (0, 1, 2...)<br>
		  <input type="text" name="girlage" maxlength="90" size="30" />
	-->
	Age of Girls<br>
	<select name="girlage">
		  <option value="0">0</option>
		  <option value="1">1</option>
		  <option value="2">2</option>
		  <option value="3">3</option>
		  <option value="4">4</option>
		  <option value="5">5</option>
		  <option value="6">6</option>
		  <option value="7">7</option>
		  <option value="8">8</option>
		  <option value="9">9</option>
		  <option value="10">10</option>
		  <option value="11">11</option>
		  <option value="12">12</option>
		  <option value="13">13</option>
		  <option value="14">14</option>
		  <option value="15">15</option>
		  <option value="16">16</option>
		  <option value="17">17</option>
		  <option value="18">18</option>
	</select><br>
	</td>

	<td>
	Pregnant<br>
	<select name="pregnant">
		  <option value="No">No</option>
		  <option value="Yes">Yes</option>
	</select><br>
	</td>

	<td>
	Diaper Size<br>
	<select name="diaperOptions">
		<option value="size0">Newborn</option>
		<option value="size1">1</option>
		<option value="size2">2</option>
		<option value="size3">3</option>
		<option value="size4">4</option>
		<option value="size5">5</option>
		<option value="size6">6</option>
	</select><br>
	</td>

	<td>
	Additional Notes <br>
		<input type="text" name="notes" maxlength="90" size="30" /><br>
	</td>

<br>

	<td>
		<input type="submit" value="Add Data" />
	</td>
</form>


<!-- back -->
<form method="post" action="currentversion.php?go" id="searchform">
<input type="submit" name="submit"value="Back to Homepage" />
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
		"<td> <a href='viewInfo.php?idd=$query_data[0]'> View Info </a> </td>",
		"<td> <a href='editPage.php?idd=$query_data[0]'> Edit </a> </td>",
		"<td> <a href='delete2.php?idd=$query_data[0]'> Delete </a> </td>";

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
function AddEmployee($connection, $name, $address, $lastName, $originCountry, $phone, $numberFamily, $numberVisits, $id, $men, $women, $boys, $girls, $boy_age, $girl_age, $diapersize, $notes, $pregnant, $date) {
	$n = mysqli_real_escape_string($connection, $name);
	$a = mysqli_real_escape_string($connection, $address);

	$l = mysqli_real_escape_string($connection, $lastName);
	$o = mysqli_real_escape_string($connection, $originCountry);
	$p = mysqli_real_escape_string($connection, $phone);
	$numf = mysqli_real_escape_string($connection, $numberFamily);
	$numv = mysqli_real_escape_string($connection, $numberVisits);
	$i = mysqli_real_escape_string($connection, $id);

	$m = mysqli_real_escape_string($connection, $men);
	$w = mysqli_real_escape_string($connection, $women);
	$b = mysqli_real_escape_string($connection, $boys);
	$g = mysqli_real_escape_string($connection, $girls);
	$ba = mysqli_real_escape_string($connection, $boy_age);
	$ga = mysqli_real_escape_string($connection, $girl_age);
	$d = mysqli_real_escape_string($connection, $diapersize);
	$note = mysqli_real_escape_string($connection, $notes);
	$preg = mysqli_real_escape_string($connection, $pregnant);
	$dat = mysqli_real_escape_string($connection, $date);
	//echo $d; //debug

	$query = "INSERT INTO `Employees6` (ID, Name, Address, LastName, OriginCountry, Phone, NumberOfFamily, VisitsBefore, NumMen, NumWomen, NumBoys, NumGirls, BoyAge, GirlAge, Notes, DiaperSize, Pregnant, RegistrationDate) VALUES ('$i', '$n', '$a', '$l', '$o', '$p', '$numf', '$numv', '$m', '$w', '$b', '$g', '$ba', '$ga', '$note', '$d', '$preg', '$dat');";
	if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");

	$query2 = "INSERT INTO Months (ID, January) VALUES ('$i', 'sdf');";
        if(!mysqli_query($connection, $query2)) echo("<p>Error adding month data.</p>");
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
