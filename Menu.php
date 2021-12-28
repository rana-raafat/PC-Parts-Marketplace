<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="Style.css">
  </head>

  <body>
      <nav class="navbar navbar-inverse navbar-custom">
        <div class="container-fluid">


          <div class="navbar-header">
            <a class="navbar-brand" href='Home.php'>Website Name</a>
          </div>


          <ul class="nav navbar-nav">

            <li><a href="Home.php">Home</a></li>

            <!--DIRECTING TO CATEGORY RESULTS NOT DONE YET-->
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Products<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Motherboard</a></li>
                <li><a href="#">RAM</a></li>
                <li><a href="#">Graphics Card</a></li>
                <li><a href="#">Fan</a></li>
                <li><a href="#">HDD/SSD</a></li>
                <li><a href="#">Processor</a></li>
              </ul>
            </li>

<?php
//session_start();    
if(!empty($_SESSION['username'])){       
if($_SESSION['userType'] == "auditor"){
?>

            <li><a href='survey.php'>Survey</a></li>
            <!-- 
              i think this should be a "send survey" button instead of a link to the survey
              where when it is clicked it shows a list of customers, the auditor selects a number of them (using checkbox)
              and the survey link is sent to these customers as a message
            -->
            <li><a href='SurveyResults.php'>Survey Results</a></li>

<?php
}
else if($_SESSION['userType'] == "administrator"){
?>

            <li><a href='AddProduct.php'>Add a Product</a></li>

<?php
}
?>

          </ul>

    
          <ul class="nav navbar-nav navbar-right">
            <li><text class="header">Welcome<?php echo "  ".$_SESSION['username']; ?></text></li>
            <li><img src='<?php echo "  ".$_SESSION['imagePath']; ?>' alt='profilepic' width='50' height='50' class="img-circle"></li>;


            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Account<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="Profile.php">Profile</a></li>
                <li><a href="SignOut.php">Sign Out</a></li>
                <li><a href="delete.php">Delete Account</a></li>
              </ul>

<?php
}
else{
?>  

              </ul>

              <ul class="nav navbar-nav navbar-right">
                <li><a href="LogIn.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                <li><a href="SignUp.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
<?php
}
?>
                <li><a href="Cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
              </ul>

              <form class="navbar-form navbar-left" action="SearchResults.php" method="post">
                <div class="input-group">

                  <input type="text" class="form-control" name="searchQuery" placeholder="Search for a product">

                  <div class="input-group-btn">
                  <button class="btn btn-basic" type="submit" name="submitSearch">
                    <i class="glyphicon glyphicon-search"></i>
                  </button>
                  </div>

                </div>
              </form>


    </div>
  </nav>
</body>

</html>
