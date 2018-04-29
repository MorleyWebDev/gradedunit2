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
  $edate = $row['enddate'];
  $sleft = $row['spacesleft'];
  $cncl = $row['cancel'];
}

// echo $sdate;
// echo $edate;
// echo $sleft;
// echo $cncl;
// echo $exid;
// echo $uid;

//change echo to innerhtml of error div
//also add buttons - disabled etc class="disabled"
if(ISSET($_SESSION['id'])){
  if($edate > date("Y-m-d")){
    if($sleft > 0 ){
      echo '<a href="bookingForm.php?exid=' . $exid  . '"><input type="button" name="booktickets" value="Book Tickets"></a>';
    } else {
      echo '<button type="button" name="booktickets" class="btn disabled btnDisable bookcase3" value="Book Tickets">Book Tickets</button>';
    }
  } else {
    echo '<button type="button" name="booktickets" class="btn disabled btnDisable bookcase2" value="Book Tickets">Book Tickets</button>';
  }
} else {
  echo '<button type="button" name="booktickets" class="btn disabled btnDisable bookcase1" value="Book Tickets">Book Tickets</button>';
}




// if(ISSET($_SESSION['id']))
// {
//   #user is logged in -
//   if($edate > date("Y-m-d"))
//   {
//     #exhibit is on - further validation required
//     if($sleft > 0)
//     {
//       #has spaces left
//       echo "you good";
//     }
//     else
//     {
//       #
//       echo "DISABLED BUTTON - no spaces";
//     }
//   }
//   else
//   {
//     #change inner html of error div / add active class to error
//     echo "DISABLED BUTTON - ENDED";
//   }
// else
// {
//     echo "DISABLED BUTTON - LOG IN BRO";
// }
// }

 ?>


<?php
#else
#echo button as disabled
 ?>
