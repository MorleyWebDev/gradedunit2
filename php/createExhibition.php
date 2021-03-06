<?php
session_start();

$role = $_SESSION['userrole'];

// if not admin dont allow the connect
if($role != 'admin'){
  header('location: userProfile.php');
}
// db connect
require('includes/dbconx.php');

// only execute code on post request
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
// below is validation for empty form fields
    if (empty($_POST["title"])) {
        $titleErr = "Required";
    } else {
      // if not empty, process data and add variable for success
        $titleCreate = test_input($_POST["title"]);
        $titleV = 1;
      }

   if(empty($_POST['description'])) {
     $descErr = "Required";
   } else {
     $desc = test_input($_POST['description']);
     $descV = 1;
   }

   if(empty($_POST['type'])) {
     $catErr = "Required";
   } else {
     $cat = test_input($_POST['type']);
     $catV = 1;
   }

   if(empty($_POST['startdate'])) {
     $SDErr = "Required";
   } else {
     $SD = test_input($_POST['startdate']);
     $SDV = 1;
   }

   if(empty($_POST['enddate'])) {
     $EDErr = "Required";
   } else {
     $ED = test_input($_POST['enddate']);
     $EDV = 1;
   }

   if(empty($_POST['price'])) {
     $priceErr = "Required";
   } else {
     $priceCreate = test_input($_POST['price']);
     $priceV = 1;
   }

   if(empty($_POST['ticketlimit'])) {
     $limitErr = "Required";
   } else {
     $limit = test_input($_POST['ticketlimit']);
     $limitV = 1;
   }


   //if all fields are valid execute code
   if(
     $titleV == 1 &&
     $descV == 1 &&
     $catV == 1 &&
     $SDV == 1 &&
     $EDV == 1 &&
     $priceV == 1
   ){
     // code for image upload
   $target_dir = "img/exhibitions/";
   $target_file = $target_dir . basename($_FILES["createExImage"]["name"]);
   $uploadOk = 1;
   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   // Check if image file is a actual image or fake image
   if(isset($_POST["submit"])) {
       $check = getimagesize($_FILES["createExImage"]["tmp_name"]);
       if($check !== false) {
           $uploadOk = 1;
       } else {
           echo "File is not an image.";
           $uploadOk = 0;
       }
   }
   // Check if file already exists
   if (file_exists($target_file)) {
       echo "Sorry, file already exists.";
       $uploadOk = 0;
   }
   // Check file size
   if ($_FILES["createExImage"]["size"] > 500000) {
       echo "Sorry, your file is too large.";
       $uploadOk = 0;
   }
   // Allow certain file formats
   if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
   && $imageFileType != "gif" ) {
       echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
       $uploadOk = 0;
   }
   // Check if $uploadOk is set to 0 by an error
   if ($uploadOk == 0) {
       echo "Sorry, your file was not uploaded.";
   // if everything is ok, try to upload file
   } else {
       if (move_uploaded_file($_FILES["createExImage"]["tmp_name"], $target_file)) {
           $uploadExImage = basename( $_FILES["createExImage"]["name"]);
       } else {
           echo "Sorry, there was an error uploading your file.";
       }
   }
 }

}

// to process trim and remove the potential for rogue js to be executed by user
  function test_input($data)
  {
      $data = trim($data);
      $data = stripslashes($data);
      $data = (htmlspecialchars($data));
      return $data;
  }

// only on post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // if all inputs valid
if(
  $titleV == 1 &&
  $descV == 1 &&
  $catV == 1 &&
  $SDV == 1 &&
  $EDV == 1 &&
  $priceV == 1
  )
// if image not empty
  if(!empty($uploadExImage)){
    // upload the exhibition fields
    $insertEx = mysqli_query($conn, "insert into exhibitions (active, title, description, image, spacesleft, startdate,enddate, price, type, cancel)
            VALUE ('1','$titleCreate', '$desc', '$uploadExImage', '$limit', '$SD', '$ED', '$priceCreate', '$cat', '0')");
// if it worked exho confirmation message
    if($insertEx) {
      echo "Exhibition Uploaded Successfully!";
// if it didnt echo server error
} else {
  echo "server Error. Please try again later";
}

}
}
?>
