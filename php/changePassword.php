<?php
// start session
session_start();
// only execute code when post request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // connect to db
  include('../includes/dbconx.php');
// filter the input content (stops user from executing js through the input fields - trims extra spaces)
  $inputCurrPw = test_input($_POST['crrntPassword']);
  $inputNewPw = test_input($_POST['newPassword']);



  $uid = $_SESSION['id'];
  //get the password
  $getUserPw = mysqli_query($conn, "select password from users where userid = $uid");
  $numRows = mysqli_num_rows($getUserPw);
  // scripts for if user didnt fill out either password field - no longer needed with required on original form
  if (empty($inputCurrPw) || empty($inputNewPw)) {
    header('location: ../userProfile.php?alertBarMsg=Make sure you fill out both password fields!');
  }else {
    // if userid exists as a user- this is not really needed
  if($numRows ==1){
    // get password
    $row = mysqli_fetch_assoc($getUserPw);
    // test password against the inputted password
    if(password_verify($inputCurrPw, $row['password'])){
      // hash the new password
      $hashNewPw = password_hash($inputNewPw, PASSWORD_DEFAULT);
      // update password with the new hashed password
      $changed = mysqli_query($conn, "UPDATE users set password = '$hashNewPw' where userid like $uid");
      // if successful link user back to their profile with confirmation
      if($changed){
       header('location: ../userProfile.php?alertBarMsg=Password changed successfully.');
      } else {
        // error message if server breaks
       header('location: ../userProfile.php?alertBarMsg=Cannot connect to the server. Oh Dear.');
      }
    } else {
      // error message if incorrect password
      header('location: ../userProfile.php?alertBarMsg=Incorrect password! - please try again');
    }
   }
 }
}

// func to process data
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
