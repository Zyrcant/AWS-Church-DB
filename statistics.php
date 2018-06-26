<html>
<header>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<title> View statistics </title>
</header>
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


<!-- back -->
<form method="post" action="currentversion.php?go" id="searchform">
<input type="submit" name="submit"value="Back to Homepage" />
</form>



<?php
//connect  to the database
$db=mysql_connect  ("tutorial-db-instance.cl2lz81okayq.us-east-2.rds.amazonaws.com", "tutorial_user",  "password") or die ('I cannot connect to the database  because: ' . mysql_error());
//select  the database to use
$mydb=mysql_select_db("sample");
?>

<?php
$sql="SELECT * FROM Employees7";
$sql2="SELECT * FROM Children";
$sql3="SELECT * FROM Months";
//run  the query against the mysql query function
//result and num is for the lined up results kreygasm
$result=mysql_query($sql);
$child_result = mysql_query($sql2);
$month_result = mysql_query($sql3);

$size0 = 0;
$size1 = 0;
$size2 = 0;
$size3 = 0;
$size4 = 0;
$size5 = 0;
$size6 = 0;

//$num_family = 0;
//$num_visits = 0;
$num_men = 0;
$num_women = 0;
$num_boys = 0;
$num_girls = 0;
$boy_age_arr = array();
$girl_age_arr = array();
$month_arr = array();

//COUNTS CHILDREN DATA
while($query_data = mysql_fetch_row($child_result))
{
	$diaper = $query_data[4];
	$sex = $query_data[3];
	$bday = $query_data[2];
        $age=date_diff(date_create($bday), date_create('today'))->y;
//echo $c4 . " ";
	if ($diaper == "Size 0") $size0 += 1;
        if ($diaper == "Size 1") $size1 += 1;
        if ($diaper == "Size 2") $size2 += 1;
        if ($diaper == "Size 3") $size3 += 1;
        if ($diaper == "Size 4") $size4 += 1;
        if ($diaper == "Size 5") $size5 += 1;
        if ($diaper == "Size 6") $size6 += 1;
	if ($sex == "Male")
	{
		$num_boys += 1;
		if (is_numeric($age)) $boy_age_arr[$age] += 1; // counts the age
	}
	if ($sex == "Female")
	{
		$num_girls += 1;
                if (is_numeric($age))$girl_age_arr[$age] += 1; // counts the age
	}
}

/* COUNTS NUMBER OF MEN AND WOMEN*/
while($query_data = mysql_fetch_row($result))
{
	$men = $query_data[8];
	$women = $query_data[9];
        if (is_numeric($men)) $num_men += (int) $men;
        if (is_numeric($women)) $num_women += (int) $women;
}

/* COUNTS NUMBER OF FAMLIES COME EACH MONTH */
while($query_data = mysql_fetch_row($month_result))
{
	$i = 0;
	while ($i < 13)
	{
		if ($query_data[$i] == "came")
		{
			$month_arr[$i] += 1;
		}
		$i += 1;
	}
}
?>


<br>

<?php
/* PRINTS STATISTICAL INFORMATION */
echo "<b>Current diaper amounts by sizes on the database.</b>" . "<br>";
echo "Newborn: " . $size0 . "<br>";
echo "Size1: " . $size1 . "<br>";
echo "Size2: " . $size2 . "<br>";
echo "Size3: " . $size3 . "<br>";
echo "Size4: " . $size4 . "<br>";
echo "Size5: " . $size5 . "<br>";
echo "Size6: " . $size6 . "<br><br>";

$people = $num_men + $num_women + $num_boys + $num_girls;
echo "<b>Additional Statistics:</b>" . "<br>";
echo "<b>Total amount of X in database:</b> " . "<br>";
echo "People: " . $people . "<br>";
echo "Men: " . $num_men . "<br>";
echo "Women: " . $num_women . "<br>";
echo "Boys: " . $num_boys . "<br>";
echo "Girls: " . $num_girls . "<br>";

echo "<br>";
echo "<b>Number of families that came per month<br></b>";
echo "January: " . $month_arr[1] . "<br>";
echo "Febuary: " . $month_arr[2] . "<br>";
echo "March: " . $month_arr[3] . "<br>";
echo "April: " . $month_arr[4] . "<br>";
echo "May: " . $month_arr[5] . "<br>";
echo "June: " . $month_arr[6] . "<br>";
echo "July: " . $month_arr[7] . "<br>";
echo "August: " . $month_arr[8] . "<br>";
echo "September: " . $month_arr[9] . "<br>";
echo "October: " . $month_arr[10] . "<br>";
echo "November: " . $month_arr[11] . "<br>";
echo "December: " . $month_arr[12] . "<br>";

$i = 0;
echo "<br>";
echo "<b>Number of Girls by Age<br></b>";
while ($i < 18)
{
	echo "Age " . $i . ": " . $girl_age_arr[$i] . "<br>";
	$i++;
}

$i = 0;
echo "<br>";
echo "<b>Number of Boys by Age<br></b>";
while ($i < 18)
{
        echo "Age " . $i . ": " . $boy_age_arr[$i] . "<br>";
        $i++;
}

?>

<br>
<br>

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

<?php /* LISTS THE AMOUNT OF PEOPLE IN THE DATABASE */
//query  the database table
$sql="SELECT * FROM Employees7";

//run  the query against the mysql query function
//result and num is for the lined up results kreygasm
$result=mysql_query($sql);
$num=mysql_num_rows($result);
echo "Total number of families in database: " . $num;

while($query_data = mysql_fetch_row($result)) {

  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
                 "<td>",$query_data[1], "</td>",
                 "<td>",$query_data[3], "</td>",
                 "<td>",$query_data[4], "</td>",
                 "<td>",$query_data[5], "</td>",
                 "<td> <a href='viewInfo2.php?idd=$query_data[0]'> View Info </a> </td>",
                 "<td> <a href='editPage.php?idd=$query_data[0]'> Edit </a> </td>",
                 "<td> <a href='delete2.php?idd=$query_data[0]'>Delete</a> </td>";


  echo "</tr>";
}
?>
</body>
</html>
