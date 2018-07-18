<html>
<link rel="stylesheet" type="text/css" href="styles1.css">
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
<!-- back -->
<form method="post" action="currentversion.php?go" id="searchform">
<input type="submit" name="submit"value="Back to Homepage" />
<br>
<?php
/*3 if statements saying if search button is pushed, it will go and search the databaseby connecting to the database first the running $sql. */
if(isset($_POST['submit']))
{
	if(isset($_GET['go']))
	{
		//if(preg_match("/^[  a-zA-Z]+/", $_POST['search']))
		//{
			$search=$_POST['search'];
			$selected_val = $_POST['searchOptions'];  // Storing Selected Value In Variable
			echo "Searching results by " .$selected_val; //Displaying Selected Value
			//connect  to the database
			$db=mysql_connect  ("tutorial-db-instance.cl2lz81okayq.us-east-2.rds.amazonaws.com", "tutorial_user",  "password") or die ('I cannot connect to the database  because: ' . mysql_error());
			//select  the database to use
			$mydb=mysql_select_db("sample");
			
			//query  the database table
			switch($selected_val)
			{
				case "ID":
					$sql="SELECT * FROM Employees7 WHERE ID LIKE '%" . $search . "%'";
					break;
			   case "name":
					$sql="SELECT * FROM Employees7 WHERE Name LIKE '%" . $search . "%'";
					break;
			   case "lastName":
					$sql="SELECT * FROM Employees7 WHERE LastName LIKE '%" . $search . "%'";
					break;
				case "countryOfOrigin":
					$sql="SELECT * FROM Employees7 WHERE OriginCountry LIKE '%" . $search . "%'";
					break;
				case "phone":
					$sql="SELECT * FROM Employees7 WHERE Phone LIKE '%" . $search . "%'";
					break;
			 	case "allOptions":
					$sql="SELECT * FROM Employees7 WHERE Name LIKE '%" . $search . "%' OR LastName  LIKE '%" . $search . "%' OR OriginCountry LIKE '%" . $search . "%' OR Phone LIKE '%" . $search . "%' OR ID LIKE '%" . $search . "%'  ";
					break;
			}
			//run  the query against the mysql query function
			?>
			<?php
			//result and num is for the lined up results kreygasm
			$result=mysql_query($sql);
			$num=mysql_num_rows($result);
			
			?>

			<table border="0" cellspacing="2" cellpadding="2">
			<tr>
				<th>
					<font face="Trebuchet MS, Helvetica, sans-serif"><b>ID</b></font>
				</th>
				<th>
					<font face="Trebuchet MS, Helvetica, sans-serif"><b>Name</b></font>
				</th>
				<th>
					<font face="Trebuchet MS, Helvetica, sans-serif"><b>Last Name</b></font>
				</th>
				<th>
					<font face="Trebuchet MS, Helvetica, sans-serif"><b>Country of Origin</b></font>
				</th>
				<th>
					<font face="Trebuchet MS, Helvetica, sans-serif"><b>Phone</b></font>
				</th>
            <th>
               <font face="Trebuchet MS, Helvetica, sans-serif"><b>View Info</b></font>
            </th>
            <th>
               <font face="Trebuchet MS, Helvetica, sans-serif"><b>Edit</b></font>
            </th>
            <th>
            	<font face="Trebuchet MS, Helvetica, sans-serif"><b>Delete</b></font>
            </th>
			</tr>

			<?php
			//Looks through all the rows for matching columns with search field XD
			$i=0;
			while ($i < $num) 
			{
				$f1=mysql_result($result,$i,"ID");
				$f2=mysql_result($result,$i,"Name");
				$f3=mysql_result($result,$i,"Address");
				$f4=mysql_result($result,$i,"LastName");
				$f5=mysql_result($result,$i,"OriginCountry");
				$f6=mysql_result($result,$i,"Phone");
				$f7=mysql_result($result,$i,"NumberOfFamily");
				$f8=mysql_result($result,$i,"VisitsBefore");
				?>

				<tr>
					<td>
						<font face="Arial, Helvetica, sans-serif"><?php echo $f1; ?></font>
					</td>
					<td>	
						<font face="Arial, Helvetica, sans-serif"><?php echo $f2; ?></font>
					</td>
					<td>
						<font face="Arial, Helvetica, sans-serif"><?php echo $f4; ?></font>
					</td>
					<td>
						<font face="Arial, Helvetica, sans-serif"><?php echo $f5; ?></font>
					</td>
					<td>
						<font face="Arial, Helvetica, sans-serif"><?php echo $f6; ?></font>
					</td>
               <td>
                  <?php echo "<a href='viewInfo2.php?idd=$f1'> View Info </a>" ?>
               </td>
               <td>
                  <?php echo "<a href='editPage.php?idd=$f1'> Edit </a>" ?>
               </td>
               <td>
               	<?php echo "<a href='delete2.php?idd=$f1'> Delete </a>" ?>
               </td>

				</tr>

				<?php
				$i++;
			}
		}
		else
		{
			echo  "<p>Please enter another search query</p>";
		}
	//}
}
	
?>

</table>
</form>
</body>
</html>
