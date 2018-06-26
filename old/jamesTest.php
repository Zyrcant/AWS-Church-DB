<?php include "../inc/dbinfo.inc"; ?>
<html>
<head>
<h1 align="center">Picture Testing Page</h1>
</head>
<body>
<?php

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

//a database or something?
$database = mysqli_select_db($connection, DB_DATABASE);

/* Ensure that the Employees table exists. */
VerifyEmployeesTable($connection, DB_DATABASE);

if(TableExists("Months", $connection, DB_DATABASE))
{
	echo "table exists <br>";
}
else
{
	echo "table does not exist";
}

$s = $_POST['drop'];
if (isset($s))
{
	echo "dropped";
	$_POST = array();
	dropTable($connection);
}
else
{
	echo "wew";
}
/*
echo "<br>";
$pic = $_FILES["fileToUpload"];
if (isset($pic))
{
	echo "image exists";
}
else
{
	echo "image does not exist";
}
*/
?>

</form>
<form method="post" action="">
<input type="submit" name = "drop" value="Drop Table" />
</form>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
<?php
/* Check whether the table exists and, if not, create it. */
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("Months", $connection, $dbName))
  {
         echo("<p> custom error. table does not exist</p>");

         $query = "CREATE TABLE `Months` (
                  `ID` varchar(11) DEFAULT NULL,
                  `January` varchar(11) DEFAULT NULL,
                  `Febuary` varchar(11) DEFAULT NULL,
                  `March` varchar(11) DEFAULT NULL,
                  `April` varchar(11) DEFAULT NULL,
                  `May` varchar(11) DEFAULT NULL,
                  `June` varchar(11) DEFAULT NULL,
                  `July` varchar(11) DEFAULT NULL,
                  `August` varchar(11) DEFAULT NULL,
                  `September` varchar(11) DEFAULT NULL,
                  `October` varchar(11) DEFAULT NULL,
                  `November` varchar(11) DEFAULT NULL,
                  `December` varchar(11) DEFAULT NULL,
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

/* drops table */
function dropTable($connection)
{
	$query = "DROP TABLE Months";
	if(!mysqli_query($connection, $query)) echo("<p>Error dropping table.</p>");
}
?>
