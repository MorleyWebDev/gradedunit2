<?php
$sdate = $edate = $sleft = $cncl = "";
#if(ex-startDate < presentDate)
#and
#user is logged in
#and userid+exid num rows = 0
#echo button as active
$sqlGetDates = mysqli_query($conn, "SELECT startdate, enddate, spacesleft, cancel from exhibitions where exhibitionid LIKE $exid");
while($row = mysqli_fetch_array($sqlGetDates)){
  global $sdate; global $edate; global $sleft; global $cncl;

  $sdate = $row['startdate'];
  $edate = strtotime($row['enddate']);
  $sleft = $row['spacesleft'];
  $cncl = $row['cancel'];

}
// echo $sdate;
// echo $edate;
// echo $sleft;
//echo $cncl;
// echo $exid;
// echo $uid;
//change echo to innerhtml of error div
//also add buttons - disabled etc class="disabled"

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
<p class="bookingLogicErr hideOnClick"></p>
