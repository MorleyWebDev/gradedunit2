<?php
session_start();
 if(!isset($_SESSION["userrole"])){
  ?>
 <!--LOGGED OUT NAVBAR -->
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
            <li class="nav-item active">
              <a  class="nav-item nav-link " href="php/logout.php">Logout: <?php echo $_SESSION['username']; ?></a>
            </li>
        </ul>
    </div>
</nav>

<!--USER LOGIN  -->
  <?php
} else if($_SESSION['userrole'] === 'admin') {
  ?>
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
                href="userprofile.php?<?php echo $_SESSION['id']; ?> ">
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
            <li class="nav-item active">
              <a  class="nav-item nav-link" href="php/logout.php">Logout: <?php echo $_SESSION['username']; ?></a>
            </li>
        </ul>
    </div>
</nav>
<?php } ?>
