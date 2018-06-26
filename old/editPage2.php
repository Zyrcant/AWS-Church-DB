<?php include "../inc/dbinfo.inc"; ?>
<html>
<link rel="stylesheet" type="text/css" href="styles1.css">
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

<br><h1>Edit a card</h1>

<?php
$id = $_GET['idd'];

//variables to store in person data on page
$name_in = '';
$address_in = '';
$lastname_in = '';
$origin_in = '';
$phone_in = '';
$number_family_in = '';
$visits_before_in = '';
$id_in;

$num_men_in = '';
$num_women_in = '';
$num_boys_in = '';
$num_girls_in = '';
$boy_age_in = '';
$girl_age_in = '';
$notes_in = '';
$pregnant_in = '';
$registration_date_in = '';

//gets person data from input fields
$name_in = htmlentities($_POST['Name']);
$address_in = htmlentities($_POST['Address']);
$lastname_in = htmlentities($_POST['lastName']);
$origin_in = htmlentities($_POST['originCountry']);
$phone_in = htmlentities($_POST['Phone']);
$number_family_in = htmlentities($_POST['NumFamily']);
$visits_before_in = htmlentities($_POST['numVisit']);
$id_in = htmlentities($_POST['Id']);

$num_men_in = htmlentities($_POST['nummen']);
$num_women_in = htmlentities($_POST['numwomen']);
$num_boys_in = htmlentities($_POST['numboys']);
$num_girls_in = htmlentities($_POST['numgirls']);
$boy_age_in = htmlentities($_POST['boyage']);
$girl_age_in = htmlentities($_POST['girlage']);
$notes_in = htmlentities($_POST['notes']);

$pregnant_in = htmlentities($_POST['pregnant']);
$registration_date_in = htmlentities($_POST['date']);


// testing
//echo $id_in;

/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
$database = mysqli_select_db($connection, DB_DATABASE);

//connect  to the database
$db=mysql_connect  ("tutorial-db-instance.cjtuhcr4ubfw.us-east-2.rds.amazonaws.com", "tutorial_user",  "password") or die ('I cannot connect to the database  because: ' . mysql_error());

//select  the database to use
$mydb=mysql_select_db("sample");

//query  the database table
$sql="SELECT * FROM Employees7 WHERE ID LIKE '%" . $id . "%'";
$sql2="SELECT * FROM Months WHERE ID = '$id'";
//run  the query against the mysql query function
//result and num is for the lined up results
$result=mysql_query($sql);
$num=mysql_num_rows($result);

$result2=mysql_query($sql2);
$num2=mysql_num_rows($result2);
//gets person data from SQL server and auto fills in fields for editing
$i=0; // counter
while ($i < $num)
{
	$check = mysql_result($result,$i,"ID");
	if ($check = $id)
	{
		$id_in = mysql_result($result,$i,"ID");
		$name_in = mysql_result($result,$i,"Name");
		$address_in = mysql_result($result,$i,"Address");
		$lastname_in = mysql_result($result,$i,"LastName");
		$origin_in = mysql_result($result,$i,"OriginCountry");
		$phone_in = mysql_result($result,$i,"Phone");
		$number_family_in = mysql_result($result,$i,"NumberOfFamily");
		$visits_before_in = mysql_result($result,$i,"VisitsBefore");
		$id_in = mysql_result($result,$i,"ID");
		$num_men_in = mysql_result($result,$i,"NumMen");
		$num_women_in = mysql_result($result,$i,"NumWomen");
		$num_boys_in = mysql_result($result,$i,"NumBoys");
		$num_girls_in = mysql_result($result,$i,"NumGirls");
		$boy_age_in = mysql_result($result,$i,"BoyAge");
		$girl_age_in = mysql_result($result,$i,"GirlAge");
		$notes_in = mysql_result($result,$i,"Notes");
		$pregnant_in = mysql_result($result,$i,"Pregnant");
		$registration_date_in = mysql_result($result,$i,"RegistrationDate");
	}
	$i++;
}

$i = 0;
while ($i < $num2)
{
        $m1=mysql_result($result2,$i,"January");
        $m2=mysql_result($result2,$i,"Febuary");
        $m3=mysql_result($result2,$i,"March");
        $m4=mysql_result($result2,$i,"April");
        $m5=mysql_result($result2,$i,"May");
        $m6=mysql_result($result2,$i,"June");
        $m7=mysql_result($result2,$i,"July");
        $m8=mysql_result($result2,$i,"August");
        $m9=mysql_result($result2,$i,"September");
        $m10=mysql_result($result2,$i,"October");
        $m11=mysql_result($result2,$i,"November");
        $m12=mysql_result($result2,$i,"December");
        $i++;
}



if (isset($_POST['submit']))
{
	//echo "there was input"; // for debug
	//echo $id_in . "inside"; // for debug

	//updates query and server
	$query="UPDATE Employees7 SET Name = '$name_in', Address = '$address_in', LastName = '$lastname_in', OriginCountry = '$origin_in', Phone = '$phone_in', NumberOfFamily = '$number_family_in', VisitsBefore = '$visits_before_in', NumMen='$num_men_in', NumWomen='$num_women_in', NumBoys='$num_boys_in', numGirls='$num_girls_in', Notes='$notes_in', Pregnant='$pregnant_in', RegistrationDate='$registration_date_in' WHERE ID = '$id_in'";

	if(!mysqli_query($connection, $query)) echo("<p>Custom error editing data.</p>");
	else
	{
		header('Location: currentversion.php'); //If book.php is your main page where you list your all records
	}
}

?>

<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
	 <td>
		  First Name <br>
		  <input type="text" name="Name" maxlength="45" value='<?=$name_in?>' size="30"/> <br>
		</td>
		<td>
		  Address <br>
		  <input type="text" name="Address" maxlength="90" value='<?=$address_in?>' size="30"/> <br>
		</td>
		<td>
		  Last Name <br>
		  <input type="text" name="lastName" maxlength="90" value='<?=$lastname_in?>' size="30"/> <br>
		</td>
		<td>
		  Country of Origin <br>
		  <input type="text" name="originCountry" maxlength="90" value='<?=$origin_in?>' size="30"/> <br>
		</td>
		<td>
		  Phone <br>
		  <input type="text" name="Phone" maxlength="90" value='<?=$phone_in?>' size="30"/> <br>
		</td>
		<td>
		  Number of Family Members <br>
		  <input type="text" name="NumFamily" maxlength="90" value='<?=$number_family_in?>' size="30"/> <br>
		</td>

		  <!-- NEED TO ADD IN OPTION TO SELECT SPECIFIC NUMBER OF FAMILY MEMBERS. DROP DOWN MENU FOR MALE, FEMALE, AGE, ETC -->

		<td>
		  Visits before 04/22/17 <br>
		  <input type="text" name="numVisit" maxlength="90" value='<?=$visits_before_in?>' size="30"/> <br>
		</td>

		<td>
		  Registration Date <br>
		  <input type="text" name="date" maxlength="90" value='<?=$registration_date_in?>' size="30"/> <br>
		</td>

	 <!-- <tr>
		<td> 
		  ID <br> -->
		  <input type="hidden" name="Id" maxlength="90" value='<?=$id_in?>' readonly size="30"/>
		<!-- </td>
	 </tr> -->

		<td>
		  Number of Men <br>
		  <input type="text" name="nummen" maxlength="90" value='<?=$num_men_in?>' size="30"/> <br>
		</td>

		<td>
		  Number of Women <br>
		  <input type="text" name="numwomen" maxlength="90" value='<?=$num_women_in?>' size="30"/> <br>
		</td>

		<td>
		  Number of Boys <br>
		  <input type="text" name="numboys" maxlength="90" value='<?=$num_boys_in?>' size="30"/> <br>
		</td>

		<td>
		  Number of Girls <br>
		  <input type="text" name="numgirls" maxlength="90" value='<?=$num_girls_in?>' size="30"/> <br>
		</td>

		<td>
		  Age of Boys <br>
		  <input type="text" name="boyage" maxlength="90" value='<?=$boy_age_in?>' size="30"/> <br>
		</td>

		<td>
		  Age of Girls <br>
		  <input type="text" name="girlage" maxlength="90" value='<?=$girl_age_in?>' size="30"/> <br>
		</td>

		<td>
		  Pregnant <br>
		  <input type="text" name="pregnant" maxlength="90" value='<?=$pregnant_in?>' size="30"/> <br>
		</td>

		<td>
		  Additional Notes <br>
		  <input type="text" name="notes" maxlength="90" value='<?=$notes_in?>' size="30"/> <br> <br>
		</td>

	 	<td>
		  <input type="submit" value="Edit Data" name="submit" />
		</td>
</form>

<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
    <input type="hidden" name="idd" value=<?php echo $id_in ?>>
</form>

<!-- TABLE FOR MONTHLY DISTRIBUTION VISITS -->
<table style="float: left;" border="1" cellspacing="2" cellpadding="2">
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>January</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m1; ?></font> </td>
	<td> </form> <form method="post"> <input type="submit" name = "jan_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "jan_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>February</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m2; ?></font> </td>
        <td> </form> <form method="post"> <input type="submit" name = "feb_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "feb_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>March</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m3; ?></font> </td>
        <td> </form> <form method="post"> <input type="submit" name = "mar_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "mar_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>April</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m4; ?></font> </td>
        <td> </form> <form method="post"> <input type="submit" name = "apr_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "apr_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>May</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m5; ?></font> </td>
        <td> </form> <form method="post"> <input type="submit" name = "may_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "may_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>June</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m6; ?></font> </td>
        <td> </form> <form method="post"> <input type="submit" name = "jun_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "jun_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>July</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m7; ?></font> </td>
	<td> </form> <form method="post"> <input type="submit" name = "jul_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "jul_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>August</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m8; ?></font> </td>
        <td> </form> <form method="post"> <input type="submit" name = "aug_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "aug_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>September</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m9; ?></font> </td>
        <td> </form> <form method="post"> <input type="submit" name = "sep_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "sep_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>October</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m10; ?></font> </td>
        <td> </form> <form method="post"> <input type="submit" name = "oct_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "oct_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>November</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m11; ?></font> </td>
        <td> </form> <form method="post"> <input type="submit" name = "nov_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "nov_r" value="Remove" /> </form> </td>
</tr>
<tr>
        <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>December</b></font> </td>
        <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m12; ?></font> </td>
        <td> </form> <form method="post"> <input type="submit" name = "dec_s" value="Set" /> </form> </td>
        <td> </form> <form method="post"> <input type="submit" name = "dec_r" value="Remove" /> </form> </td>
</tr>

</table>


<!-- back -->
<form method="post" action="currentversion.php?go" id="searchform">
<input type="submit" name="submit"value="Back to Homepage" />
</form>


</body>
</html>
