<?php
// this page is used to process an edit exhibition attempt.
// db connect
require('../includes/dbconx.php');
session_start();

$role = $_SESSION['userrole'];
// if user isnt on admin account - take them back to profile
if($role != 'admin'){
  header('location: ../userProfile.php');
}
// only execute code on post requirest.
// below are functions to validated the data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // if empty - place requiresd next to the form field
   if (empty($_POST["title"])) {
       $titleErr = "Required";
   } else {
     // if not empty - sanitise the data and set the Valid variable to 1
       $title = test_input($_POST["title"]);
       $titleV = 1;
     }
  if(empty($_POST['description'])) {
    $descErr = "Required";
  } else {
    $desc = test_input($_POST['description']);
    $descV = 1;
  }
  if(empty($_POST['type'])) {
    $typeErr = "Required";
  } else {
    $type = test_input($_POST['type']);
    $typeV = 1;
  }
  if(empty($_POST['startdate'])) {
    $SDErr = "Required";
  } else {
    $sdate = test_input($_POST['startdate']);
    $SDV = 1;
  }
  if(empty($_POST['enddate'])) {
    $EDErr = "Required";
  } else {
    $edate = test_input($_POST['enddate']);
    $EDV = 1;
  }
  if(empty($_POST['price'])) {
    $priceErr = "Required";
  } else {
    $price = test_input($_POST['price']);
    $priceV = 1;
  }
  if(empty($_POST['ticketlimit'])) {
    $limitErr = "Required";
  } else {
    $spacesleft = test_input($_POST['ticketlimit']);
    $limitV = 1;
  }
    $exid = $_POST['exid'];

// if all form fields are inputted correctly
  if(
    $titleV == 1 &&
    $descV == 1 &&
    $typeV == 1 &&
    $SDV == 1 &&
    $EDV == 1 &&
    $priceV == 1 &&
    $limitV == 1
  ){

#update the exhibition with the fields
  $updateEx = mysqli_query($conn,
  "UPDATE exhibitions SET title = '$title',
  description = '$desc',
  type = '$type',
  startdate = '$sdate',
  enddate = '$edate',
  spacesleft = '$spacesleft',
  price = '$price'
   WHERE exhibitionid = $exid");
  if($updateEx){
    // if successful take user back with confirmation
    header('location: ../editExhibition.php?exid='.$exid . '&alertBarMsg=Updated.');
  } else {
echo "Server error, please try again later.";
  }
} else {
  // if not all inputted correctly take admin back
  header('location: ../editExhibition.php?exid='. $exid . '&alertBarMsg=Make sure you will out all the form fields before editing');
}
}

// function to sanitise data
function test_input($data)
{
  global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}
?>
