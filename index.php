<!doctype html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lancelot" rel="stylesheet">
  <link rel="stylesheet" href="styles/style.css">
  <title>National Museums Scotland</title>
</head>

<body>
    <?php
    session_start();
    require("includes/nav.php");

    ?>

    <div class="indexShowcase">
      <h1 class="vLarge">National Museum Of Scotland</h1>
    </div>

    <?php
    require('includes/dbconx.php');
    #get mid page index content - will change depending on login state
    require("includes/landing.php");
    ?>

    <div class="indexExhibitList">
      <div class="container posDown">
        <h3 class="marginbottom posDown centerText">Hot Exhibits</h3>
        <p class="light posDown marginbottom centerText">Top three exhibits currently running.</p>
        <div class="row justify-content-center">
        <!-- get top 3 exhibits - active only, non cancelled for front page. -->
        <?php $sqlTop1 = mysqli_query($conn, "SELECT E.exhibitionid, image, spacesleft, type, title, ROUND(AVG(rating),1) as average
                                    FROM exhibitions E LEFT JOIN ratings R ON E.exhibitionid = R.exhibitionid
                                    WHERE active = 1 AND cancel = 0 AND enddate > CURDATE()
                                    GROUP By E.exhibitionid, title ORDER BY average DESC LIMIT 1");

              $sql2and3 = mysqli_query($conn, "SELECT E.exhibitionid, image, spacesleft, type, title, ROUND(AVG(rating),1) as average
                                          FROM exhibitions E LEFT JOIN ratings R ON E.exhibitionid = R.exhibitionid
                                          WHERE active = 1 AND cancel = 0 AND enddate > CURDATE()
                                          GROUP By E.exhibitionid, title ORDER BY average DESC LIMIT 2 OFFSET 1");



       while($row = mysqli_fetch_array($sqlTop1)){
              $Exid = $row['exhibitionid'];
              $ExIMG = $row['image'];
              $ExTitle = $row['title'];
              $ExType = $row['type'];
              $spaceLeft = $row['spacesleft'];
              $averageScr = $row['average'];?>
                <div class="col-md-4 posDown">
                  <div class="card hotExCardTOP">
                    <img class="IndexExImg"src="img/exhibitions/<?php echo $ExIMG ?>" class="card-img-top" alt="exhibition_image">
                    <div class="card-body">
                      <h5 class="card-title marginbottom"> <?php echo $ExTitle ?> </h5>
                      <p class="card-text">Exhibition field: <?php echo $ExType; ?> </p>
                      <p class="score">Rating: <?php echo $averageScr; ?> / 10</p>
                      <?php if($spaceLeft > 0){
                         ?>
                         <p>Tickets left: <?php echo $spaceLeft; ?></p>
                       <?php } else {?>
                          <p>Sold out!</p>
                        <?php } ?>
                        <a  class="btn aWhiteHover" href="specificExhibition.php?exid=<?php echo $Exid; ?>">View Exhibition</a>
                    </div>

                  </div>
                </div>



          <?php } ?>

        <?php  while($row = mysqli_fetch_array($sql2and3)){
                 $Exid = $row['exhibitionid'];
                 $ExIMG = $row['image'];
                 $ExTitle = $row['title'];
                 $ExType = $row['type'];
                 $spaceLeft = $row['spacesleft'];
                 $averageScr = $row['average'];?>
                   <div class="col-md-4 posDown">
                     <div class="card hotExCard">
                       <img class="IndexExImg"src="img/exhibitions/<?php echo $ExIMG ?>" class="card-img-top" alt="exhibition_image">
                       <div class="card-body">
                         <h5 class="card-title marginbottom"> <?php echo $ExTitle ?> </h5>
                         <p class="card-text">Exhibition field: <?php echo $ExType; ?> </p>
                         <?php if($averageScr != ""){ ?>
                           <p class="score">Rating: <?php echo $averageScr; ?> / 10</p>
                         <?php } else {echo "<br/>";} ?>
                         <?php if($spaceLeft > 0){
                            ?>
                            <p>Tickets left: <?php echo $spaceLeft; ?></p>
                          <?php } else {?>
                             <p>Sold out!</p>
                           <?php } ?>
                       <a  class="btn aWhiteHover" href="specificExhibition.php?exid=<?php echo $Exid; ?>">View Exhibition</a>
                       </div>

                     </div>
                   </div>



             <?php } ?>

      </div>
    <div class="row justify-content-center posDown">
      <a class="viewAllExhibitionsBtn btn aWhiteHover" href="exhibitionsMain.php">View All Exhibitions </a>
    </div>
    </div>
  </div>

  </body>




<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script src="js/letterBoxAlerts.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/modalHandle.js"></script>
<script src="js/bookingAlerts.js"></script>
<script src="js/loginForm.js"></script>

<script>
// Highlight the navpage page link
$(document).ready(function(){
    $('a[href^="index.php"]').addClass('active');
});
</script>

</html>
