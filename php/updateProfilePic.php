<?php
session_start();
require('../includes/dbconx.php');


$target_dir = "../img/userUploaded/";
$target_file = $target_dir . basename($_FILES["updatedProfPic"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["updatedProfPic"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
      header('location: ../userprofile.php?alertBarMsg=Please upload an image file only.');
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    header('location: ../userprofile.php?alertBarMsg=That file already exists in our database, either rename it or choose another file, sorry!');
    $uploadOk = 0;
}
// Check file size
if ($_FILES["updatedProfPic"]["size"] > 500000) {
    header('location: ../userprofile.php?alertBarMsg=Sorry, that picture is too big for our database. Please upload a smaller one (<500kb)');
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    header('location: ../userprofile.php?alertBarMsg=Please upload an image file only.');
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["updatedProfPic"]["tmp_name"], $target_file)) {
        $uid = $_SESSION['id'];
        $picUrl = basename($_FILES["updatedProfPic"]["name"]);
        #do some cool stuff here
        $updateProfPic = mysqli_query($conn, "UPDATE users set avatar = '$picUrl' WHERE userid = $uid");
        if($updateProfPic) {
          header('location: ../userprofile.php?alertBarMsg=Profile picture changed!');
        }
          else {header('location: ../userprofile.php?alertBarMsg=Server error. Please try again later!');}

    } else {
      header('location: ../userprofile.php?alertBarMsg=Sorry, there was a server error, please try again later.');

    }
}


?>
