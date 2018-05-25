<?php
session_start();
require("../includes/dbconx.php");
$uid = $_SESSION['id'];
$exid = $_GET["exid"];
$tcost;

$vPassword = $_POST['bookPassword'];
$ticketNo = $_POST["bookingselec"];
$ticketNo = (int)$ticketNo;

$sqlExi = mysqli_query($conn, "SELECT price, spacesleft from exhibitions where exhibitionid LIKE $exid");

while($row = mysqli_fetch_array($sqlExi)){
  global $tcost;
  global $ticketNo;
  $tcost = ($ticketNo * $row['price']); //total cost is no of tickets * price
  $tcost = (int)$tcost;

  $realSpacesLeft = $row['spacesleft'];
  $realSpacesLeft = (int)$realSpacesLeft;
}

//Fix for user being able to moditfy the html source to book more tickets than exist
if ($realSpacesLeft < $ticketNo || $ticketNo > 7){
  header('location: ../bookingForm.php?exid=' . $exid . '&alertBarMsg=You are trying to buy more tickets than are avaliable! That is not very fair.');
  die();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") { //prevents scrips from running without POST request
  if(empty($_POST['bookPassword'])){
    header('location: ../bookingForm.php?exid=' .$exid . '&alertBarMsg=You need to enter your password!');
  } else {
    checkPw($_POST['bookPassword']);
  }
}


function checkPw($pw){
  global $conn; global $uid; global $ticketNo; global $exid; global $tcost;
  //if(isset($_SESSION['id'])){
    $sqlUser = mysqli_query($conn, "SELECT * from users where userid LIKE $uid");
    $sqlCheckBookings = mysqli_query($conn, "SELECT userid, exhibitionid from tickets where userid LIKE '$uid' AND exhibitionid LIKE '$exid'");

    $row = mysqli_fetch_assoc($sqlUser);


    if(mysqli_num_rows($sqlCheckBookings)>=1){
      header('location: ../specificExhibition.php?exid=' . $exid . '&alertBarMsg=You have already booked this exhibition! - be sure to leave a review after you visit!');
      return;
    }

    //check doesnt exist

    if(password_verify($pw, $row['password'])){

        $ticketsInsert = mysqli_query($conn, "INSERT into tickets (userid, exhibitionid, tickets, totalcost)
                                            VALUE ('$uid', '$exid', '$ticketNo', '$tcost')");

        if($ticketsInsert){
          //remove spaces from exhibiton table
          $sqlSpacesleft = mysqli_query($conn, "UPDATE exhibitions SET spacesleft = spacesleft - '$ticketNo' WHERE exhibitionid LIKE '$exid'");
          $sqlSpacesleft;
          header("location: ../userProfile.php?alertBarMsg=Tickets booked! - be sure to leave a review after you visit!");
        } else {
          echo "Something went wrong! - Please try again later";
        }
    } else {
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
