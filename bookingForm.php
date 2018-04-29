<?php
  session_start();
  require("includes/dbconx.php");
  $uid = $_SESSION['id'];
  $exid = $_GET["exid"];

  $vTitle = $vPrice = "";

  $sqlBookForm = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");
  $sqlBookFormTest = mysqli_query($conn, "SELECT * FROM exhibitions where exhibitionid LIKE $exid");

       while($row = mysqli_fetch_array($sqlBookFormTest)){
         global $vPrice;
         global $vTitle;
         $vPrice = $row['price'];
         $vTitle = $row['title'];
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
      <p>Price per ticket - <?php echo $vPrice; ?></p><br/>
      <label for="bookingselec">Ticket Quantity - </label>
      <select name="bookingselec" id="bookingselec"class="bookingselec marginbottom">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select> <br/>

      <label for="bookPassword">Re-enter Password - </label>
      <input type="text" name="bookPassword" id="bookPassword" class="marginbottom" placeholder="Enter your password" value="">

      <p>Total cost - fix this later
        <span id="totalCost">
          <script>
          //
          </script>
        </span>
      </p>

      <br/><input type="submit" class="purchaseTickets" name="Purchase tickets" value="Purchase tickets">
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
  <script src="js/loginForm.js"></script>
  </html>
