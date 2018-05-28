<?php
// start php sessions
session_start();
// connect to db
require("../includes/dbconx.php");
// get user id
$uid = $_SESSION['id'];
// get exhibition id from
$exid = $_GET["exid"];
$tcost;

$vPassword = $_POST['bookPassword'];
$ticketNo = $_POST["bookingselec"];
$ticketNo = (int)$ticketNo;

// get price and spaces left from exid
$sqlExi = mysqli_query($conn, "SELECT price, spacesleft from exhibitions where exhibitionid LIKE $exid");

$checkExists = mysqli_num_rows($sqlExi);
// if non existant query string field link user back to exhibitionsMain.php
if($checkExists == 0){
  header('location: exhibitionsMain.php');
}



while($row = mysqli_fetch_array($sqlExi)){
  global $tcost;
  global $ticketNo;
  $tcost = ($ticketNo * $row['price']); //total cost is no of tickets * price
  // didnt work without int
  $tcost = (int)$tcost;

  $realSpacesLeft = $row['spacesleft'];
  // define the number of spaces left to a variable
  $realSpacesLeft = (int)$realSpacesLeft;
}

//Fix for user being able to moditfy the html source to book more tickets than exist
// if user manages to get to this page with more tickets than possible take them back to
if ($realSpacesLeft < $ticketNo || $ticketNo > 7){
  header('location: ../bookingForm.php?exid=' . $exid . '&alertBarMsg=You are trying to buy more tickets than are avaliable! That is not very fair.');
  die();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") { //prevents scripts from running without POST request
  // if user doesnt enter password. This isn't really needed anymore as i added required tag to the
  // original input field
  if(empty($_POST['bookPassword'])){
    header('location: ../bookingForm.php?exid=' .$exid . '&alertBarMsg=You need to enter your password!');
  } else {
    // if not blank, check password is correct. - this function processes the ticket inputs too
    checkPw($_POST['bookPassword']);
  }
}


function checkPw($pw){
  global $conn; global $uid; global $ticketNo; global $exid; global $tcost;
  //if(isset($_SESSION['id'])){
    $sqlUser = mysqli_query($conn, "SELECT * from users where userid LIKE $uid");
    $sqlCheckBookings = mysqli_query($conn, "SELECT userid, exhibitionid from tickets where userid LIKE '$uid' AND exhibitionid LIKE '$exid'");

    $row = mysqli_fetch_assoc($sqlUser);

    // check user hasn't already booked the exhibition
    if(mysqli_num_rows($sqlCheckBookings)>=1){
      // if they have take them back to the exhibition page.
      header('location: ../specificExhibition.php?exid=' . $exid . '&alertBarMsg=You have already booked this exhibition! - be sure to leave a review after you visit!');
      return;
    }

    // test password
    if(password_verify($pw, $row['password'])){
        $ticketsInsert = mysqli_query($conn, "INSERT into tickets (userid, exhibitionid, tickets, totalcost)
                                            VALUE ('$uid', '$exid', '$ticketNo', '$tcost')");

        if($ticketsInsert){
          //remove spaces from exhibiton table
          $sqlSpacesleft = mysqli_query($conn, "UPDATE exhibitions SET spacesleft = spacesleft - '$ticketNo' WHERE exhibitionid LIKE '$exid'");
          $sqlSpacesleft;
          // after tickets are booked take user back to profile with confirmation message
          header("location: ../userProfile.php?alertBarMsg=Tickets booked! - be sure to leave a review after you visit!");
        } else {
          echo "Server error! - Please try again later";
        }
    } else {
      // if incorrect password take user back with error message
     header('location: ../bookingForm.php?exid=' .$exid . '&alertBarMsg=incorrect password! - please try again');
    }
  }


?>


<?php
#if statement before for validation
#IF start date is before present date
#i literallt have the ability to go if user.role=creator disable the button or whatever


#sql insert wt
#JUST COPY FROM registerUser.php
?>
