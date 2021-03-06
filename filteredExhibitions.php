<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php
      require('includes/dbconx.php');
      $emptyRequest = 0;
// if they go to this page with no post request
      if(!isset($_POST['searchBarInput'])){
        header('location: index.php?alertBarMsg=We didnt quite catch that search query. Could you try again?');
      }
// if the post requet is empty
      if(empty($_POST['searchBarInput'])){
        $emptyRequest = 1;
      }
      // prevent rogue js being executed
      $userQuery = htmlspecialchars($_POST['searchBarInput']);
      // prevent sql inject
      $userQuery = mysqli_real_escape_string($conn, $userQuery);


// select database query with the users input
      $sql = mysqli_query($conn, "SELECT E.exhibitionid, image, title, spacesleft, type, title, ROUND(AVG(rating),1) as average
      FROM exhibitions E LEFT JOIN ratings R ON E.exhibitionid = R.exhibitionid
      WHERE ACTIVE = 1 AND title like '%$userQuery%' OR type like '%$userQuery%'
      GROUP By E.exhibitionid, title ORDER BY cancel, average DESC");
    ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/style.css">
    <title>National Museums Scotland</title>
  </head>
  <body>
    <?php require("includes/nav.php") ?>

    <div class="jumbotron">
      <h1>Filtered Exhibitions</h1>

    </div>

    <div class="container">
      <a href="javascript:history.go(-1)"><span class="backbtn">Back</span></a>
      <?php if($emptyRequest == 1){ ?>
        <h3 class='centerText'>You forgot to type something into the search bar.</h3>
        <p class='centerText light'>It's an easy mistake to make, don't worry.</p>

      <?php } else { ?>
      <h3 class='centerText'>You searched for <?php echo $userQuery; ?></h3>
    <?php } ?>

<?php $rowcount = mysqli_num_rows($sql); ?>
<!-- if no rows for select or empty rrequest -->
    <?php  if($rowcount == 0 || $emptyRequest == 1){ ?>
          <div class="card posDown">
            <p class='centerText pNoMarginBelow padding'>No results found.</p>
          </div>
  <?php  } else { ?>



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
        <!-- if no score -->
      <p class="score">Rating: <?php echo $averageMain; ?> / 10</p>
    <?php } else { echo "<br/>"; } ?>
    <!-- if there are some spaces left -->
      <?php if($spaceLeftMain > 0){ ?>
      <p class="card-text">Tickets left <?php echo $spaceLeftMain; ?></p>
    <?php }else{  ?>
      <p>Sold out!</p>
    <?php } ?>
    </div>
    <a class="btnStyle" href="specificExhibition.php?exid=<?php echo $exid; ?>">View exhibition</a>

  </div>

</div>

<?php } } ?>



   </div>


   <script src="https://code.jquery.com/jquery-3.3.1.min.js"
     integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
     crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/letterBoxAlerts.js"></script>
   <script src="js/loginForm.js"></script>
  </body>
</html>
