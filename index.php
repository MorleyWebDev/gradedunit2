<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles/style.css">
  <title>National Museums Scotland</title>
</head>

<body>
    <?php
    require("includes/nav.php");
    //js script here to add class "active to all the "home" links in the
    require("includes/landing.php");
    session_start();
    echo $_SESSION['userrole'];
    echo $_SESSION['name'];
    echo $_SESSION['email'];
    ?>
      <?php
    if(isset($_GET['message']))
    {
      $message = $_GET['message'];
      echo "<div class ='alertMessage'>" .  $message . "</div>";
    }
     ?>



  </body>




<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
    <?php include('js/letterBoxAlerts.php'); ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/modalHandle.js"></script>
<script src="js/bookingAlerts.js"></script>
<script src="js/loginForm.js"></script>
</html>
