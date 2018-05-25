<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php
      require('includes/dbconx.php');
      $sql = mysqli_query($conn, "SELECT E.exhibitionid, image, title, spacesleft, type, title, ROUND(AVG(rating),1) as average
      FROM exhibitions E LEFT JOIN ratings R ON E.exhibitionid = R.exhibitionid
      WHERE ACTIVE = 1 GROUP By E.exhibitionid, title ORDER BY cancel, average DESC");
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

    <div class="jumbotron">
      <h1>All Exhibitions</h1>
      <p class='light centerText'>Here's everything, cancelled exhibtions and exhibitions which have ended are on this page too. But they will be at the bottom</p>
    </div>

    <div class="container">
      <a href="javascript:history.go(-1)"><span class="backbtn">Back</span></a>
      <br/><br/>

  <div class="shopContainer row justify-content-center">
    <?php
      while($row = mysqli_fetch_array($sql)){
        $exid = $row['exhibitionid'];
        $imageMain = $row['image'];
        $spaceLeftMain = $row['spacesleft'];
        $typeMain = $row['type'];
        $titleMain = $row['title'];
        $averageMain = $row['average'];

?>
<div class="col-md-4">
  <div class="card centerText mainPageCard">
    <img class="IndexExImg" src="img/exhibitions/<?php echo $imageMain; ?>" alt="exhibition_image">
    <div class="card-body">
      <h5 class="card-title"><?php echo $titleMain; ?></h5>
      <p class="card-text">Exhibition field: <?php echo $typeMain; ?> </p>
        <?php  if(($averageMain != "")){ ?>
      <p class="score">Rating: <?php echo $averageMain; ?> / 10</p>
      <!-- Line break to replace the "rating" p tag -->
    <?php } else { echo "<br/>"; } ?>
      <?php if($spaceLeftMain > 0){ ?>
      <p class="card-text">Tickets left <?php echo $spaceLeftMain; ?></p>
    <?php }else{  ?>
      <p>Sold out!</p>
    <?php } ?>
    </div>
    <a  class="btnStyle aWhiteHover" href="specificExhibition.php?exid=<?php echo $exid; ?>">View Exhibition </a>

  </div>

</div>

<?php } ?>



   </div>


   <script src="https://code.jquery.com/jquery-3.3.1.min.js"
     integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
     crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
   <script src="js/letterBoxAlerts.js"></script>
   <script src="js/loginForm.js"></script>

   <script>
   // Highlight the navpage page link
   $(document).ready(function(){
       $('a[href^="exhibitionsMain.php"]').addClass('active');
   });
   </script>

  </body>
</html>
