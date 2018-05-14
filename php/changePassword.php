<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include('../includes/dbconx.php');

  $inputCurrPw = test_input($_POST['crrntPassword']);
  $inputNewPw = test_input($_POST['newPassword']);



  $uid = $_SESSION['id'];

  $getUserPw = mysqli_query($conn, "select password from users where userid = $uid");
  $numRows = mysqli_num_rows($getUserPw);
  if (empty($inputCurrPw) || empty($inputNewPw)) {
    header('location: ../userProfile.php?alertBarMsg=Make sure you fill out both password fields!');
  }else {
  if($numRows ==1){
    $row = mysqli_fetch_assoc($getUserPw);
    if(password_verify($inputCurrPw, $row['password'])){
      $hashNewPw = password_hash($inputNewPw, PASSWORD_DEFAULT);
      $changed = mysqli_query($conn, "UPDATE users set password = '$hashNewPw' where userid like $uid");
      if($changed){
       header('location: ../userProfile.php?alertBarMsg=Password changed successfully.');
      } else {
       header('location: ../userProfile.php?alertBarMsg=Cannot connect to the server. Oh Dear.');
      }
    } else {
      header('location: ../userProfile.php?alertBarMsg=Incorrect password! - please try again');
    }
   }
 }
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
