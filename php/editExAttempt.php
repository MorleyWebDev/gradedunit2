<?php
require('includes/dbconx.php');
session_start();

$role = $_SESSION['userrole'];

if($role != 'admin'){
  header('location: userProfile.php');
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {



   if (empty($_POST["title"])) {
       $titleErr = "Required";
   } else {
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



  if(
    $titleV == 1 &&
    $descV == 1 &&
    $typeV == 1 &&
    $SDV == 1 &&
    $EDV == 1 &&
    $priceV == 1 &&
    $limitV = 1
  ){
    $exid = $_POST['exid'];


#update
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
    echo "Exhibition Edited.";
  } else {
echo "Server error, please try again later.";
  }

 }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = (htmlspecialchars($data));
    return $data;
}


?>
