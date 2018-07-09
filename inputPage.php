<?php include "../inc/dbinfo.inc"; ?>
<html>
<link rel="stylesheet" type="text/css" href="styles.css">
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
</form>

<h1>Insert Person</h1>


<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
/* Connect to MySQL and select the database. */
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
//a database or something?
$database = mysqli_select_db($connection, DB_DATABASE);
$db=mysql_connect  ("tutorial-db-instance.cl2lz81okayq.us-east-2.rds.amazonaws.com", "tutorial_user",  "password") or die ('I cannot connect to the database  because: ' . mysql_error());
$mydb=mysql_select_db("sample");
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
$notes = htmlentities($_POST['notes']);
$pregnant = htmlentities($_POST['pregnant']);
$registration = htmlentities($_POST['date']);
$race = htmlentities($_POST['race']);
//gets name for deletion
$delname = $_POST['delname'];
//gets name for search
$search_name = htmlentities($_POST['searchname']);
$sql="SELECT * FROM Employees7 WHERE ID='$Id'";
 
$result = mysql_query($sql);
 
$num = mysql_num_rows($result);
//adds person to database
if (isset($_POST['Add'])) 
{
	if($num!==0)
	{	
		echo "ID already exists";
	}
	else
	{
		AddEmployee($connection, $employee_name, $employee_address, $lastname, $origin, $phone, $number_family, $visits_before, $Id, $num_men, $num_women, $num_boys, $num_girls, $notes, $pregnant, $registration, $race);
	echo $employee_name . " " . $lastname . " has been added";
		header("Location: addChild.php?parID=$Id");
	}
}
?>
<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" autocomplete="nope" method="POST">
	ID<br>
	<input type="text" name="id" maxlength="90" size="30"/><br>
	First Name<br>
	<input type="text" name="Name" maxlength="45" value='<?=$employee_name_in?>' size="30"/><br>
	Last Name <br>
	<input type="text" name="lastName" maxlength="90" size="30"/><br>
	Address (123 Rainbow Road) <br>
	<input type="text" name="Address" maxlength="90" size="30"/><br>
	<!--Country of Origin (USA, Syria, etc.)<br>
	<input type="text" name="originCountry" maxlength="90" size="30"/><br> -->

	<!--This lengthy section of code implements autocomplete for countries. When we were doing data analysis by country, we noticed the volunteers had a very difficult time spelling countries. Small quality of life upgrade.-->
	Country of Origin <br>
		<div class="autocomplete" style="width:300px;">
			<input id="myInput" type="text" name="originCountry" placeholder="Country">
		</div>
	<script>
		function autocomplete(inp, arr) {
			/*the autocomplete function takes two arguments,
		  the text field element and an array of possible autocompleted values:*/
			var currentFocus;
			/*execute a function when someone writes in the text field:*/
			inp.addEventListener("input", function(e) {
				var a, b, i, val = this.value;
				/*close any already open lists of autocompleted values*/
				closeAllLists();
				if (!val) { return false;}
				currentFocus = -1;
				/*create a DIV element that will contain the items (values):*/
				a = document.createElement("DIV");
				a.setAttribute("id", this.id + "autocomplete-list");
				a.setAttribute("class", "autocomplete-items");
				/*append the DIV element as a child of the autocomplete container:*/
				this.parentNode.appendChild(a);
				/*for each item in the array...*/
				for (i = 0; i < arr.length; i++) {
					/*check if the item starts with the same letters as the text field value:*/
					if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
						/*create a DIV element for each matching element:*/
						b = document.createElement("DIV");
						/*make the matching letters bold:*/
						b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
						b.innerHTML += arr[i].substr(val.length);
						/*insert a input field that will hold the current array item's value:*/
						b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
						/*execute a function when someone clicks on the item value (DIV element):*/
						b.addEventListener("click", function(e) {
							/*insert the value for the autocomplete text field:*/
							inp.value = this.getElementsByTagName("input")[0].value;
							/*close the list of autocompleted values,
						  (or any other open lists of autocompleted values:*/
							closeAllLists();
						});
						a.appendChild(b);
					}
				}
			});
			/*execute a function presses a key on the keyboard:*/
			inp.addEventListener("keydown", function(e) {
				var x = document.getElementById(this.id + "autocomplete-list");
				if (x) x = x.getElementsByTagName("div");
				if (e.keyCode == 40) {
					/*If the arrow DOWN key is pressed,
				  increase the currentFocus variable:*/
					currentFocus++;
					/*and and make the current item more visible:*/
					addActive(x);
				} else if (e.keyCode == 38) { //up
					/*If the arrow UP key is pressed,
				  decrease the currentFocus variable:*/
					currentFocus--;
					/*and and make the current item more visible:*/
					addActive(x);
				} else if (e.keyCode == 13) {
					/*If the ENTER key is pressed, prevent the form from being submitted,*/
					e.preventDefault();
					if (currentFocus > -1) {
						/*and simulate a click on the "active" item:*/
						if (x) x[currentFocus].click();
					}
				}
			});
			function addActive(x) {
				/*a function to classify an item as "active":*/
				if (!x) return false;
				/*start by removing the "active" class on all items:*/
				removeActive(x);
				if (currentFocus >= x.length) currentFocus = 0;
				if (currentFocus < 0) currentFocus = (x.length - 1);
				/*add class "autocomplete-active":*/
				x[currentFocus].classList.add("autocomplete-active");
			}
			function removeActive(x) {
				/*a function to remove the "active" class from all autocomplete items:*/
				for (var i = 0; i < x.length; i++) {
					x[i].classList.remove("autocomplete-active");
				}
			}
			function closeAllLists(elmnt) {
				/*close all autocomplete lists in the document,
			 except the one passed as an argument:*/
				var x = document.getElementsByClassName("autocomplete-items");
				for (var i = 0; i < x.length; i++) {
					if (elmnt != x[i] && elmnt != inp) {
						x[i].parentNode.removeChild(x[i]);
					}
				}
			}
			/*execute a function when someone clicks in the document:*/
			document.addEventListener("click", function (e) {
				closeAllLists(e.target);
			});
		}
		/*An array containing all the country names in the world:*/
		var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
		/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
		autocomplete(document.getElementById("myInput"), countries);
	</script>
	<br>
	Phone (xxx-xxx-xxxx)<br>
	<input type="text" name="Phone" maxlength="90" size="30"/><br>
	Date of Registration (MM/DD/YYYY)<br>
	<input id="datefield" type="date" name="date" max="2018-12-31" maxlength="90" size="30"/><br>
	<!--Sets the max date a person can register to the current date -->
	<script>
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0
		var yyyy = today.getFullYear();
		if(dd<10){
			dd='0'+dd
		}
		if(mm<10){
			mm='0'+mm
		}
		today = yyyy+'-'+mm+'-'+dd;
		document.getElementById("datefield").setAttribute("max", today);
	</script>

	Race<br>
	<select name="race">
		<option value="White">White</option>
		<option value="Asian">Asian</option>
		<option value="Hispanic">Hispanic</option>
		<option value="Black">Black</option>
		<option value="American Indian">American Indian</option>
		<option value="Pacific Islander">Pacific Islander</option>
		<option value="Other">Other</option>
	</select><br>
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

	Pregnant<br>
	<select name="pregnant">
		<option value="No">No</option>
		<option value="Yes">Yes</option>
	</select><br>

	Additional Notes 
	<br>
	<input type="text" name="notes" maxlength="90" size="30" /><br>

	<br>
	<input type="submit" name="Add" value="Add Data" />
	<br>
</form>



<!--
 Display table data. 
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
-->

<?php
	
/*
$result = mysqli_query($connection, "SELECT * FROM Employees7"); 
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
}*/
?>

<!--</table> -->

<!-- Clean up. -->
<?php
mysqli_free_result($result);
mysqli_close($connection);
?>

</body>
</html>


<?php
/* Add an employee to the table. */
function AddEmployee($connection, $name, $address, $lastName, $originCountry, $phone, $numberFamily, $numberVisits, $id, $men, $women, $boys, $girls, $notes, $pregnant, $date, $race) {
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
	$b = "0";
	$g = "0";
	$note = mysqli_real_escape_string($connection, $notes);
	$preg = mysqli_real_escape_string($connection, $pregnant);
	$dat = mysqli_real_escape_string($connection, $date);
	$rac = mysqli_real_escape_string($connection, $race);
	//echo $d; //debug
	$query = "INSERT INTO `Employees7` (ID, Name, Address, LastName, OriginCountry, Phone, NumberOfFamily, VisitsBefore, NumMen, NumWomen, NumBoys, NumGirls, Notes, Pregnant, RegistrationDate, Race) VALUES ('$i', '$n', '$a', '$l', '$o', '$p', '$numf', '$numv', '$m', '$w', '$b', '$g', '$note', '$preg', '$dat', '$rac');";
	if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
        $query2 = "INSERT INTO Months (ID, January, Febuary, March, April, May, June, July, August, September, October, November, December) VALUES ('$i', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no');";
        if(!mysqli_query($connection, $query2)) echo("<p>Error adding month data.</p>");
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
         `Race` varchar(90) DEFAULT NULL,
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
