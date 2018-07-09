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

<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$id = $_POST['idd'];
//echo $id;

//target_dir is directory image will be placed in. hardcoded for now
//changing thid directory will also need to change view image and delete image code
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$target_file = $target_dir . $id . "." . $imageFileType;
//echo $target_file;
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }
}

// Check if file already exists and deletes it if new file is submitted
if (file_exists($target_file) && $check !== false) {
    echo "file already exists. Deleting previous file<br>";
    //$uploadOk = 0;
    array_map('unlink', glob("uploads/" . $id .".jpg"));
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg")// && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
{
    echo "Sorry, only JPG files are allowed<br>";//, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}
//$result = $_FILES["fileToUpload"]["tmp_name"];
//echo $_FILES["fileToUpload"];
?>
<!-- back -->
<form method="post" action="currentversion.php?go" id="searchform">
<input type="submit" name="submit"value="Back to Homepage" />
</form>

