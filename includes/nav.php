<?php
session_start();
 if(!isset($_SESSION["userrole"])){
  ?>
 <!--LOGGED OUT NAVBAR -->
 <div class="alertBar" id="alertBar"> <?php echo $_GET['alertBarMsg']; ?> </div>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
    	   		<a class="nav-item nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
     		   <a class="nav-item nav-link" href="exhibitionsMain.php">Exhibitions</a>
            </li>
            <li class="nav-item">
    		    <a class="nav-item nav-link" href="#">Chatbot</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="#">National Museums Scotland</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
       			 <a  class="nav-item nav-link " href="register.php">Register</a>
            </li>

            <li class="nav-item">
       			    <a id="loginbtn" class="nav-item nav-link " href="#">Login</a>
            </li>
        </ul>
    </div>


<!--modal login window  -->
    <div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Login</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form class="loginForm form-horizontal" action="php/loginUser.php" method="post">
            <div class="form-group">
              <input type="text" name="un" placeholder="username" value="">
              <input type="text" name="pw" placeholder="password" value=""><br>
              <button type="submit" name="button">Login!</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
  </nav>

  <?php
} else if(($_SESSION['userrole'] === 'creator'
        || $_SESSION['userrole'] === 'readonly')) {
  ?>
  <!-- LOGGED IN AS CREATOR/READONLY NAVBAR -->
  <div class="alertBar" id="alertBar"> <?php echo $_GET['alertBarMsg']; ?> </div>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="exhibitionsMain.php">Exhibitons</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Chatbot</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                  href="userprofile.php">
                  @<?php echo $_SESSION['username'];?>
                </a>
            </li
        </ul>
    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="#">National Museums Scotland</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <!-- NEeds notify session is defined when user logs in. if it is 1 they have a new message.
            It will be set to one if an admin cancels an exhibition they are apart of-->
            <?php if($_SESSION['needsNotify'] == 0){ ?>
              <img class="letterBox letterNoAlert" id="letterBox" src="img/letter.png" alt="letter">
            <?php } ?>

            <?php if($_SESSION['needsNotify'] == 1){ ?>
              <img class="ALERTEDletterBox" id="letterBox" src="img/letter_highlighted.png" alt="letter">
            <?php } ?>

          </li>
            <li class="nav-item active">
              <a  class="nav-item nav-link " href="php/logout.php">Logout: <?php echo $_SESSION['username']; ?></a>
            </li>
        </ul>
    </div>
</nav>

<!--admin LOGIN  -->
  <?php
} else if($_SESSION['userrole'] === 'admin') {
  ?>
  <div class="alertBar" id="alertBar"> <?php echo $_GET['alertBarMsg']; ?> </div>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="exhibitionsMain.php">Exhibitons</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Chatbot</a>
            </li>
            <li class="nav-item">
              <a class="nav-link"
                href="userprofile.php">
                @<?php echo $_SESSION['username'];?>
              </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php">*administration</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="#">National Museums Scotland</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <?php var_dump($_SESSION['needsNotify']); ?>
            <?php if($_SESSION['needsNotify'] == 0){ ?>
              <img class="letterBox letterNoAlert" id="letterBox" src="img/letter.png" alt="letter">
            <?php } ?>

            <?php if($_SESSION['needsNotify'] == 1){ ?>
              <img class="ALERTEDletterBox" id="letterBox" src="img/letter_highlighted.png" alt="letter">
            <?php } ?>

          </li>
            <li class="nav-item active">
              <a  class="nav-item nav-link" href="php/logout.php">Logout: <?php echo $_SESSION['username']; ?></a>
            </li>
        </ul>
    </div>
</nav>
<?php } ?>

<div class="modal fade" id="letterAlertModal" role="dialog">
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title">You have a new alert!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <p>One or more exhibitions you have booked have been cancelled :(</p>
      <p> click <a href="userProfile.php?Notified=1&alertBarMsg=One of your bookings has been cancelled! Scroll to the bottom to check">here</a> to view your exhibitions and remove this alert.</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="letterNoAlert" role="dialog">
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
    <h4 class="modal-title">You have no pending messages.</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <p>We will post a message here if an exhibition you have booked has any urgent changes</p>
      <p>The letter will glow blue when this happens, so it will be pretty obvious!</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
