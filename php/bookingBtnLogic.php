<?php
#this page hosts the logic for the booking button - The booking button will change state depending on a varierty of factors
$sdate = $edate = $sleft = $cncl = "";
// get the dates to be used in button logic
$sqlGetDates = mysqli_query($conn, "SELECT startdate, enddate, spacesleft, cancel from exhibitions where exhibitionid LIKE $exid");
while($row = mysqli_fetch_array($sqlGetDates)){
  global $sdate; global $edate; global $sleft; global $cncl;
// assign to varaibles
  $sdate = $row['startdate'];
  $edate = strtotime($row['enddate']);
  $sleft = $row['spacesleft'];
  $cncl = $row['cancel'];

}


#five conditions need to be met for the real button to be echoed.
if(ISSET($_SESSION['id'])){
  if($CheckBooked == 0){
    if($cncl == 0){
      if($edate > strtotime('today GMT')){
        if($sleft > 0 ){
          #if user meets all conditions allow them to book
          echo '<a class="btnStyle workingBkBtn aWhiteHover" href="bookingForm.php?exid=' . $exid  . '">Book Tickets</a>';
        } else {
          #if no spaces left
          echo '<input type="button" name="booktickets" class="btnDisable bookcaseNoSpace" value="Book Tickets">';
        }
      } else {
        #if exhibition has ended
        echo '<input type="button" name="booktickets" class="btnDisable bookcaseEnded" value="Book Tickets">';
      }
    } else {
      #if exhibition is canceled
      echo '<input type="button" name="booktickets" class="btnDisable bookcaseCncl" value="Book Tickets">';
    }
  } else {
    #if user has booked a ticket - no button. As they can only purchase one set of tickets
    echo "";
  } }
else {
  #if user is logged out
 echo '<input type="button" name="booktickets" class="btnDisable bookcaseLoggedOut" value="Book Tickets">';
}
?>
<!-- for printing error messages -->
<p class="bookingLogicErr hideOnClick"></p>
