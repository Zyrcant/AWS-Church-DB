<!--For user authentication. Must paste into every file you want to be protected on the server. Probably would be easier to include all of this in a js file and import it. -->
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

<html>
	<header>
		<title>
			View Card
		</title>
	</header>
	<!-- back -->
	<form method="post" action="currentversion.php?go" id="searchform">
		<input type="submit" name="submit"value="Back to Homepage" />
	</form>

<?php
$search=$_GET['idd'];

//connect  to the database
$db=mysql_connect  ("tutorial-db-instance.cl2lz81okayq.us-east-2.rds.amazonaws.com", "tutorial_user",  "password") or die ('I cannot connect to the database  because: ' . mysql_error());

//select  the database to use
$mydb=mysql_select_db("sample");

//query  the database table
$sql="SELECT * FROM Employees7 WHERE ID='$search'";
$sql2="SELECT * From Children WHERE parentID='$search'";
$sql3="SELECT * FROM Months WHERE ID = '$search'"; // new james code
//run  the query against the mysql query function
$result=mysql_query($sql);
$resultChildren = mysql_query($sql2);


$result2=mysql_query($sql3); // new james code
$num3=mysql_num_rows($result2); // new james code
//count how many rows to loop through
$num2=mysql_num_rows($resultChildren);

$i=0;
//Assigns variables to the selected person
$f1=mysql_result($result,$i,"ID");
$f2=mysql_result($result,$i,"Name");
$f3=mysql_result($result,$i,"Address");
$f4=mysql_result($result,$i,"LastName");
$f5=mysql_result($result,$i,"OriginCountry");
$f6=mysql_result($result,$i,"Phone");
$f7=mysql_result($result,$i,"NumberOfFamily");
$f8=mysql_result($result,$i,"VisitsBefore");
$f9=mysql_result($result,$i,"NumMen");
$f10=mysql_result($result,$i,"NumWomen");
$f11=mysql_result($result,$i,"NumBoys");
$f12=mysql_result($result,$i,"NumGirls");
$f15=mysql_result($result,$i,"Notes");
$f16=mysql_result($result,$i,"DiaperSize");
$f17=mysql_result($result,$i,"Pregnant");
$f18=mysql_result($result,$i,"RegistrationDate");

$i = 0;
while ($i < $num3)
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
?>

<table style="display: inline-block;" border="1" cellspacing="2" cellpadding="2">
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>ID</b></font> </td>
	<td> <font face="Arial, Helvetica, sans-serif"><?php echo $f1; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Name</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f2; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Address</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f3; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Last Name</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f4; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Country of Origin</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f5; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Phone</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f6; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Number of Family Members</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f7; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Visits before 04/22/17</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f8; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Registration Date</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f18; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Men</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f9; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Women</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f10; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Boys</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f11; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Girls</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f12; ?></font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Pregnant</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f17; ?></ 13 $search=$_GET['idd'];font> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Notes</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $f15; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Picture</b></font> </td>
		  <td> <?php echo "<a href='/uploads/" . $f1 . ".jpg'> View Picture </a>" ?> </td>
</tr>
<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Edit</b></font> </td>
	<td> <?php echo "<a href='editPage.php?idd=$f1'> Edit </a>" ?> </td>
</tr>
<!--<tr>
	<td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>Delete</b></font> </td>
	<td> <?php/* echo "<a href='delete2.php?idd=$f1'> Delete </a>" */?> </td>
</tr>-->
</table>

<!-- TABLE FOR MONTHLY DISTRIBUTION VISITS -->

<table style="display: inline-block;" border="1" cellspacing="2" cellpadding="2">
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>January</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m1; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>February</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m2; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>March</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m3; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>April</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m4; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>May</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m5; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>June</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m6; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>July</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m7; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>August</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m8; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>September</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m9; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>October</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m10; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>November</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m11; ?></font> </td>
</tr>
<tr>
		  <td> <font face="Trebuchet MS, Helvetica, sans-serif"><b>December</b></font> </td>
		  <td> <font face="Arial, Helvetica, sans-serif"><?php echo $m12; ?></font> </td>
</tr>
</table>
<br>

<table style="float: left;" border="1" cellspacing="2" cellpadding="2">
	<tr>
		<th>
			<font face="Arial, Helvetica, sans-serif"><b>Name</b></font>
		</th>
		<th>
			<font face="Arial, Helvetica, sans-serif"><b>Birthday</b></font>
		</th>
		<th>
			<font face="Arial, Helvetica, sans-serif"><b>Gender</b></font>
		</th>
		<th>
			<font face="Arial, Helvetica, sans-serif"><b>Diaper Size</b></font>
		</th>
		<th>
			<font face="Arial, Helvetica, sans-serif"><b>Age</b></font>
		</th>
	</tr>
	<?php
	//loops through all children results and displays them
	$j=0;
	while($j < $num2)
	{
		$c0=mysql_result($resultChildren, $j, "name");
		$c1=mysql_result($resultChildren, $j, "birthday");
		$c2=mysql_result($resultChildren, $j, "gender");
		$c3=mysql_result($resultChildren, $j, "DiaperSize");
		$c4=date_diff(date_create($c1), date_create('today'))->y;
		?>
		<tr>
			<td>
				 <font face="Arial, Helvetica, sans-serif"><?php echo $c0; ?></font>
			</td>
			<td>
				 <font face="Arial, Helvetica, sans-serif"><?php echo $c1; ?></font>
			</td>
			<td>
				 <font face="Arial, Helvetica, sans-serif"><?php echo $c2; ?></font>
			</td>
			<td>
				<font face="Arial, Helvetica, sans-serif"><?php echo $c3; ?></font>
			</td>
			<td>
				<font face="Arial, Helvetica, sans-serif"><?php echo $c4 ?></font>
			</td>
		</tr>
		<?php
		$j++;
	}
?>
</table>
</body>
</html>
