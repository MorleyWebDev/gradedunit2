<?php
  session_start();
  require("includes/dbconx.php");
  $uid = $_SESSION['id'];
  $exid = $_GET["exid"];

  $vTitle = $vPrice = "";

  $sqlBookForm = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");

       while($row = mysqli_fetch_array($sqlBookForm)){
         global $vPrice;
         global $vTitle;
         $vPrice = $row['price'];
         $vTitle = $row['title'];
         $ticketsLeft = $row['spacesleft'];
       }
$checkExists = mysqli_num_rows($sqlBookForm);

#if query string doesnt link to a exhibitions
#link user to main
if($checkExists == 0){
  header('location: exhibitionsMain.php');
}

 ?>


 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
     <link rel="stylesheet" href="styles/style.css">
     <meta charset="utf-8">
     <title>Booking Form</title>
   </head>
   <body>
     <?php
     require("includes/nav.php");
     ?>
     <div class="jumbotron">
       <h1>Booking Form</h1>
       <h6>Complete the form below to book tickets!</h6>
     </div>



    <div class="container">
     <a href="javascript:history.go(-1)"><span class="backbtn">Back</span></a><br/>
     <p class="bold margintop underBackbtn">Booking for - <?php echo $vTitle;  ?> </p>


    <form class="bookingForm" action="php/buyTickets.php?exid=<?php echo $exid;?>" method="post"> <!--tkaes user back with a message under the form -->
      <p><span class="bold">Tickets Remaining </span>- <?php echo $ticketsLeft ?> [Maximum 7 per customer]</p>
      <p class="pNoMarginBelow"><span class="bold">Price per ticket </span>- £<span class="stringPrice"><?php echo $vPrice; ?></span></p><br/>

      <label for="bookingselec" class="bold">Ticket Quantity - </label>
      <!-- If 7 or more tickets left -->
      <?php if($ticketsLeft >= 7){ ?>
      <select name="bookingselec" id="bookingselec" class="bookingselec marginbottom">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
      </select> <br/>
    <?php } else { ?>

      <!-- if less than 7 tickets left find out how many tickets remain and only allow the user to purchase that many. -->
      <select name="bookingselec" id="bookingselec" class="bookingselec marginbottom">
          <?php for($x=1; $x<=$ticketsLeft; $x++) {
            echo "<option value=". $x.">" .$x. "</option>";
          } ?>
      </select>


       <br/>
    <?php } ?>



      <br/>
      <button type="button" class="confirmBKBtn btnStyle" name="button" data-toggle="modal" data-target ="#confirmBookingModal">Book Tickets</button>

      <!-- Modal -->
          <div id="confirmBookingModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Confirm booking</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>
              <div class="modal-body">
                <p>You are attempting to reserve <span class="bold" id="echoTicketsSelected"></span> tickets</p>
                <p><span>This will cost you </span>£
                  <span class="bold" id="echoTotalCost">
                  </span>
                  [To pay at door]
                </p>


                <label for="bookPassword">Re-enter your Password to reserve tickets</label>
                <input type="password" name="bookPassword" required id="bookPassword" class="marginbottom" placeholder="Enter your password" value="">

                <input type="submit" class="purchaseTickets btnStyle" name="Purchase tickets" value="Reserve">
              </div>
              <div class="modal-footer">
                <button type="button" class="btnStyle btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
          </div>
    </form>

  </div>
  <?php
  if(isset($_GET['message']))
  {
    $message = $_GET['message'];
    echo "<div class ='alertMessage'>" .  $message . "</div>";
  }
   ?>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/letterBoxAlerts.js"></script>
  <script src="js/loginForm.js"></script>

  <script type="text/javascript">
    // echo tickets selected into id="echoTicketsSelected"

    // scripts to figure out how many tickets user booked and how much it will cost.
    $('.confirmBKBtn').on('click', function(){
      // get the price as an int
      var price = parseInt($('.stringPrice').text());
      // get int value of the select (the amount of tickets booked)
      var ticketsBK = $('#bookingselec').val();
      // calc total cost
      var totalcost = (price * ticketsBK);

      // echo cost + tickets booked to relevant html tags.
      $('#echoTicketsSelected').html(ticketsBK);
      $('#echoTotalCost').html(totalcost);
    })



    //echo total cost into #echoTotalCost
  </script>

  <script>
  // Highlight the navpage page link
  $(document).ready(function(){
      $('a[href^="exhibitionsMain.php"]').addClass('active');
  });
  </script>

  </html>
