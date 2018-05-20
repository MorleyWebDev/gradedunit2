 <?php
require_once('../includes/dbconx.php');

session_start();
 $specuid = $_GET['uid'];
 $exid  = $_GET['exid'];

 $uid = $_SESSION['id'];

// furhter validation - cannot access this page through url unless session matches the comment
// or user role = admin
if($uid == $specuid || $_SESSION['userrole'] == 'admin'){

  $deleteReview = mysqli_query($conn, "DELETE from ratings where userid like $specuid");

  if($deleteReview){

    header('location: ../specificExhibition.php?exid='.$exid . '&alertBarMsg=Comment deleted');
  } else {
    echo "derp";
  }
 }







 ?>
