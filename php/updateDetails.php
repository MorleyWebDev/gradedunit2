<?php
// connect to db
include('includes/dbconx.php');
  $firstnameExists = $lastnameExists = $unExists = $emailxExists = $noexists = $unInUse = 0;
  // only execute on post req
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // def variabled to be changed later
  $firstnameExists = $lastnameExists = $unExists = $emailxExists = $noexists = $unInUse = 0;

// if input field is empty print required beside the field
   if (empty($_POST["frstName"])) {
     $firstnameEr = " - required field";
   } else {
     // if not empty - test the input and set the OK variable to 1
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
     // check the username they are changing too isnt already in use
     $unInUseSQL = mysqli_num_rows(mysqli_query($conn, "SELECT username from users where username = '$un' AND userid != $currentUserid"));
// func to define vars to be used later
     $unExists = 1;
     if($unInUseSQL > 0){
       $unInUse = 1;
     } else {
       $unGood = $un;
     }
// regular expression test if username has no illegal chars
// if its good - 1 if its illegal chars - 0
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
// if they are all valid
   if(
     $noExists == 1 &&
     $emailxExists == 1 &&
     $unExists == 1 &&
     $lastnameExists == 1 &&
     $firstnameExists == 1
   ){
// and if username is valid - not in use / legal characters
     if($unInUse != 1){
       if($unameSyntax == 1){
         // if all above is good update the user row with input fields
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
    } else {$unEr = "<span class='formErrSpn'>Letters and numbers only - no spaces</span>";}
// error msg if username in use
} else {
  $unEr = "<span class='formErrSpn'>Username in use, please choose another</span>";
}
  }
}
// func to sanitise the data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = (htmlspecialchars($data));
    return $data;
}
// regex to check for illegal chars in username
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
