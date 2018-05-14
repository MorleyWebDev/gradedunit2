<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php
      require('includes/dbconx.php');
      $sql = mysqli_query($conn, "SELECT * from Exhibitions");
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <title>National Museums Scotland</title>
  </head>
  <body>
    <?php require("includes/nav.php") ?>

    <div class="container">
  <h1 class="underline">Here are some of our cool exhibitons lol</h1>

  <div class="shopContainer">
    <?php
      while($row = mysqli_fetch_array($sql)){

        echo "<div class='container'>";
          echo '<h3>' . $row['title'] . '</h3>';
          echo '<p>' . $row['description'] . '<p>';
          echo '<p> spaces left: ' . $row['spacesleft'] . '</p>';
          echo '<a href="specificExhibition.php?exid=' . $row['exhibitionid'] . '"' . '><input type="submit" value="More information"></a>';
        echo "</div>";
      }
      mysqli_close($conn);
     ?>
   </div>


   <script src="https://code.jquery.com/jquery-3.3.1.min.js"
     integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
     crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
   <?php include('js/letterBoxAlerts.php'); ?>
   <script src="js/loginForm.js"></script>
  </body>
</html>
