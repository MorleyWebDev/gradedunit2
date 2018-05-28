<?php
session_start();
// connect to db
include('../includes/dbconx.php');
$GETexid = $_GET['exid'];
$uid = $_SESSION['id'];

//check if user has actually booked the exhibition
$checkBooked = mysqli_query($conn, "SELECT * from tickets where userid like $uid AND exhibitionid like $GETexid");
$ticketNo = mysqli_fetch_assoc($checkBooked);
$checkNumRow = mysqli_num_rows($checkBooked);

$refundTickets = mysqli_query($conn,"SELECT spacesleft from exhibitions where exhibitionid = $GETexid");
$spacesRow = mysqli_fetch_assoc($refundTickets);

// if they actuyally have booked it
if ($checkNumRow > 0){
  // get tickets
  $ticketNo = $ticketNo['tickets'];
  // delete users row for the ehxibition
  $sqlDeleteUsersBkng = mysqli_query($conn, "DELETE FROM tickets WHERE userid like $uid AND exhibitionid like $GETexid");
  // ADd the deleted tickets back to the exhibition spacesleft
  $ReSellTickets = mysqli_query($conn, "UPDATE exhibitions SET spacesleft = spacesleft + $ticketNo WHERE exhibitionid LIKE $GETexid");
  // remove the reviews - user cancelled the booking - meaning they didnt attend the exhibition - so they shouldnt have a review.
  $DeleteReviews = mysqli_query($conn, "DELETE FROM ratings WHERE userid like $uid AND exhibitionid like $GETexid");
// if all three statemnets complete successfully
  if($sqlDeleteUsersBkng && $ReSellTickets && $DeleteReviews){
    // link user back to profile with confirmation message
    header('location: ../userProfile.php?alertBarMsg=Removed Booking');
  } else {
    // if not, alert error
    header('location: ../userProfile.php?alertBarMsg=server error.');
  }
} else {
  //user doesn't have any tickets.
    header('location: ../exhibitionsMain.php');
}

?>
