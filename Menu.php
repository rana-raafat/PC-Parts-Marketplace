<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="Style.css">
	</head>
  <body>

<!-------------------------------------------------------- NAVBAR -------------------------------------------------------->

      <nav class="navbar navbar-inverse navbar-custom">
        <div class="container-fluid">

<!------------------------------------------------------ LEFT SIDE ------------------------------------------------------>

            <div class="navbar-header">
                <a class="navbar-brand" href='Home.php'>Website Name</a>
            </div>

            <ul class="nav navbar-nav">

                <li><a href="Home.php">Home</a></li>

                <!--DIRECTING TO CATEGORY RESULTS NOT DONE YET-->
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Products<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="Category.php?cat=Motherboard">Motherboard</a></li>
                    <li><a href="Category.php?cat=RAM">RAM</a></li>
                    <li><a href="Category.php?cat=Graphics">Graphics Card</a></li>
                    <li><a href="Category.php?cat=Fan">Fan</a></li>
                    <li><a href="Category.php?cat=HDD">HDD/SSD</a></li>
                    <li><a href="Category.php?cat=Processor">Processor</a></li>
                  </ul>
                </li>

                <?php
                //session_start();    

                /*----------------------------------------- If Signed In -----------------------------------------*/

                if(!empty($_SESSION['username'])){      
                    /*---------------------------------------- If Auditor ----------------------------------------*/
 
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

                    /*------------------------------------- If Administrator -------------------------------------*/

                    else if($_SESSION['userType'] == "administrator"){
                        ?>
                        <li><a href='AddProduct.php'>Add a Product</a></li>
                        <?php
                    }
                    /*--------------------------------------- If HR Partner ---------------------------------------*/

                    else if($_SESSION['userType'] == "hrpartner"){
                      ?>
                        <li><a href='Penalty.php'>Penalties</a></li>
                      <?php
                    }  
                    ?>
                    </ul>

<!------------------------------------------------------ RIGHT SIDE ------------------------------------------------------>

                    <!------------------------------------------- Shared ------------------------------------------->

                    <ul class="nav navbar-nav navbar-right">
                        
                        <li>
                          <text class="header"> Welcome <?php echo "  ".$_SESSION['username']; ?></text>
                          <!--<img src="resources\images\style\rgb-animate.gif" class="rgbshape">-->
                        </li>
                        <li><img src='<?php echo "  ".$_SESSION['imagePath']; ?>' alt='profilepic' width='50' height='50' class="img-circle"></li>

                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown">Account<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="Profile.php">Profile</a></li>  
                            <li><a data-toggle="modal" data-target="#signOutModal">Sign Out</a></li>
                            <li><a data-toggle="modal" data-target="#deleteAccountModal">Delete Account</a></li>
                        </ul>
                        
                        <?php

                        /*-------------------------------------- If Customer --------------------------------------*/

                       if($_SESSION['userType'] == "customer"){
                          ?>
                          <li><a href="Cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart</a></li>
                          <?php
                        }
                          ?>

                        <!----------------------------------------- Shared ----------------------------------------->

                        <li><a href="Chat.php"><span class="glyphicon glyphicon glyphicon-inbox"></span> Inbox</a></li>

                    </ul>

                    <?php
                }
                else{

                /*---------------------------------------- If Not Signed In ----------------------------------------*/

                        ?>  

                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="LogIn.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        <li><a href="SignUp.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    </ul>

                    <?php
                }
                ?>
                        
            
            <!--------------------------------------------------------- In both cases --------------------------------------------------------->
       
                <form class="searchbar" action="SearchResults.php" method="get">

                    <input type="text" name="searchQuery" placeholder="Search for a product">

                    <button class="btn btn-basic search" type="submit" name="submitSearch">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>

                </form>

            </ul>
        </div>
      </nav>

<!--------------------------------------------------------- MODALS --------------------------------------------------------->

<!----------------------------------------------------- Sign Out Modal ----------------------------------------------------->

  <div class="container">
    <div class="modal fade" id="signOutModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Sign Out</h4>
          </div>

          <div class="modal-body">
              <form action="SignOut.php" method="post">
                  Are you sure you want to sign out from your account?<br>
                  <input type="submit" name="Yes" value="Yes"/>
                  <input type="submit" name="No" value="No"/>
              </form>
          </div>

        </div>      
      </div>
    </div>
  </div>

<!-------------------------------------------------- Delete Account Modal -------------------------------------------------->

  <div class="container">
    <div class="modal fade" id="deleteAccountModal" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Delete Account</h4>
          </div>

          <div class="modal-body">
              <form action="delete.php" method="post">
                  Are you sure you want to delete your account?<br>
                  <input type="submit" name="Yes" value="Yes"/>
                  <input type="submit" name="No" value="No"/>
              </form>
          </div>

        </div>      
      </div>
    </div>
  </div>


</body>

</html>
