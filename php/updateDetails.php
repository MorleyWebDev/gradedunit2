<?php

include('includes/dbconx.php');
  $firstnameExists = $lastnameExists = $unExists = $emailxExists = $noexists = $unInUse = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstnameExists = $lastnameExists = $unExists = $emailxExists = $noexists = $unInUse = 0;


   if (empty($_POST["frstName"])) {
     $firstnameEr = " - required field";
   } else {
     $firstN = test_input($_POST['frstName']);
     $firstnameExists = 1;
   }

   if (empty($_POST["scndName"])) {
     $secondnameEr = " - required field";
   } else {
     $lastN = test_input($_POST['scndName']);
     $lastnameExists = 1;
   }


   if (empty($_POST["usrname"])) {
     $unEr = " - required field";
   } else {
     $un = test_input($_POST['usrname']);
     $currentUserid = $_SESSION['id'];
     $unInUseSQL = mysqli_num_rows(mysqli_query($conn, "SELECT username from users where username = '$un' AND userid != $currentUserid"));

     $unExists = 1;
     if($unInUseSQL > 0){
       $unInUse = 1;
     } else {
       $unGood = $un;
     }

     if(checkuname($unGood) !==1 || $un == ""){
       $unEr = "username must be letters and numbers only, no spaces. sorry!";
       $unameSyntax = 0;
     } else {
       $unameSyntax = 1;
     }

   }


   if (empty($_POST["emailx"])) {
     $emailEr = " - required field";
   } else {
     $email = $_POST['emailx'];
     $emailxExists = 1;
   }


   if (empty($_POST["phoneNo"])) {
     $noEr = " - required field";
   } else {
     $phoneNo = $_POST['phoneNo'];
     $noExists = 1;
   }

   if(
     $noExists == 1 &&
     $emailxExists == 1 &&
     $unExists == 1 &&
     $lastnameExists == 1 &&
     $firstnameExists == 1
   ){

     if($unInUse != 1){
       if($unameSyntax == 1){
       $updateDetails = mysqli_query(
       $conn,"UPDATE users
       SET firstname = '$firstN',
       lastname = '$lastN',
       username = '$un',
       email = '$email',
       phonenumber = '$phoneNo'
       WHERE userid = '$uid'");

       $updateDetails;

       //on username change the session for username
      $_SESSION['username'] = $un;
      echo "<div class='updateBubble marginbottom hideOnClick'>Updated. You will need to refresh to see username changes. (click to dismiss)</div>";
      // header('location: ../userProfile.php?alertBarMsg=Details changed successfully!');

    } else {$unEr = "<span class='formErrSpn'>Letters and numbers only - no spaces</span>";}




} else {
  $unEr = "<span class='formErrSpn'>Username in use, please choose another</span>";
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

function checkuname($un)
{
    $regex = "/^[\w.-]*$/";
    if (!preg_match($regex, $un)) {
        return 0;
    } else {
        return 1;
    }
}


 ?>
