<?php
// this page is ysed when admin deletes an exhibition
//it instantly sets active to 0
session_start();
include('../includes/dbconx.php');

$uid = $_SESSION['uid'];
$role = $_SESSION['userrole'];
// only for admins - link to profile if not
if($role != 'admin'){
    header('location: userProfile.php');
}

$exid = $_GET['exid'];
//set active to 0 on the exhibiton - making it invisible to users
$setDelete = mysqli_query($conn, "UPDATE exhibitions SET cancel = 1, canceledOn = now(), active = 0 WHERE exhibitionid = $exid");

if($setDelete){
  // if it deletes confimration message
  header('location: ../admin.php?alertBarMsg=Exhibition has been deleted.');
// if it doesnt print error.
} else {
  header('location: ../admin.php?alertBarMsg=server error - try again later');
}


 ?>
