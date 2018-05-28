<?php
require_once('../includes/dbconx.php');

session_start();
 $specuid = $_GET['uid'];
 $exid  = $_GET['exid'];

 $uid = $_SESSION['id'];

// furhter validation - cannot access this page through url unless session matches the comment
// or user role = admin
if($uid == $specuid || $_SESSION['userrole'] == 'admin'){
// if it matches delete the review from the ex
  $deleteReview = mysqli_query($conn, "DELETE from ratings where userid like $specuid and exhibitionid = $exid");

  if($deleteReview){
    // if delete is successful post confirmation message
    header('location: ../specificExhibition.php?exid='.$exid . '&alertBarMsg=Comment deleted');
  } else {
    // if not post server error
    echo "server error. Please try again later, sorry!";
  }
} else {
  // if user isnt logged in as the user display error message
  header('location: ../specificExhibition.php?exid='.$exid . '&alertBarMsg=You do not have permission to delete this comment!');

}

 ?>
