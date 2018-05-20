<?php
session_start();
include('../includes/dbconx.php');

$uid = $_SESSION['uid'];
$role = $_SESSION['userrole'];

if($role != 'admin'){
    header('location: userProfile.php');
}

$exid = $_GET['exid'];

$setDelete = mysqli_query($conn, "UPDATE exhibitions SET cancel = 1, canceledOn = now(), active = 0 WHERE exhibitionid = $exid");

if($setDelete){
  header('location: ../admin.php?alertBarMsg=Exhibition has been deleted.');

} else {
  header('location: ../admin.php?alertBarMsg=server error - try again later');
}


 ?>
