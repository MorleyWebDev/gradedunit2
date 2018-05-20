<?php
session_start();
include('../includes/dbconx.php');
$GETexid = $_GET['exid'];
$uid = $_SESSION['id'];
//check if user has actually booked the exhibition

$checkBooked = mysqli_query($conn, "SELECT * from tickets where userid like $uid AND exhibitionid like $GETexid");
$ticketNo = mysqli_fetch_assoc($checkBooked);
$checkNumRow = mysqli_num_rows($checkBooked);

$refundTickets = mysqli_query($conn,"SELECT spacesleft from exhibitions where exhibitionid = $GETexid");
$spacesRow = mysqli_fetch_assoc($refundTickets);


if ($checkNumRow > 0){
  $ticketNo = $ticketNo['tickets'];
  $sqlDeleteUsersBkng = mysqli_query($conn, "DELETE FROM tickets WHERE userid like $uid AND exhibitionid like $GETexid");
  $ReSellTickets = mysqli_query($conn, "UPDATE exhibitions SET spacesleft = spacesleft + $ticketNo WHERE exhibitionid LIKE $GETexid");
  $DeleteReviews = mysqli_query($conn, "DELETE FROM ratings WHERE userid like $uid AND exhibitionid like $GETexid");

  if($sqlDeleteUsersBkng && $ReSellTickets && $DeleteReviews){
    header('location: ../userProfile.php?alertBarMsg=Removed Booking');
  } else {
    header('location: ../userProfile.php?alertBarMsg=server error.');
  }
} else {
  //user doesn't have any tickets.
    header('location: ../exhibitionsMain.php');
}

//if they have not direct them to the booking page


//if they have delete the entry where user id and ex id like -...
?>
