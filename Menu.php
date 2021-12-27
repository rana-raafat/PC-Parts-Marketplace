<!DOCTYPE html>
<html lang="en">
    <head>
		<link rel="stylesheet" href="Style.css">
	</head>
    <body>
        <a href='Home.php'><h1>Website name</h1></a>		
        <?php
	        //session_start();    
        	if(!empty($_SESSION['username'])){ //if logged in
	    	    echo"<text class='header'>Welcome ". $_SESSION['username'] . " <img src='". $_SESSION['imagePath']."' alt='profilepic' width='50' height='50'></text>";
    	    	echo"<a href='Home.php'>    Home </a>"; 	//website title will redirect to home page too
                echo"<a href='Profile.php'>Profile </a>"; //not done yet
                echo"<a href='Cart.php'>Cart </a>"; //not made yet
		        echo"<a href='SignOut.php'> SignOut </a>";
				echo"<a href='delete.php'>Delete </a>"; //this button should probably be in the profile page after it is made 
                if($_SESSION['userType'] == "auditor"){
                    echo"<a href='survey.php'>Survey </a>"; //i think this should be a "send survey" button instead of a link to the survey
                    //where when it is clicked it shows a list of customers, the auditor selects a number of them (using checkbox)
                    //and the survey link is sent to these customers as a message
                    echo"<a href='SurveyResults.php'>Survey Results</a>";
                }
                else if($_SESSION['userType'] == "administrator"){
                    echo"<a href='AddProduct.php'>Add a Product</a>";
                }
	        }
	        else{
                //we should add a category list somewhere maybe idk
		        echo"<text class='header'> Welcome </text>";
		        echo"<a href='Home.php'>Home</a>";
                /*
                echo"<a href='LogIn.php'>Login</a>"; //not made yet
		        echo"<a href='SignUp.php'>SignUp</a>";
                */
                echo "<a href='LogIn.php'> <input type='button' value='Log In' class='menu_bar_left' > </a>";
                echo "<a href='SignUp.php'> <button class='menu_bar_left'> Sign Up </button> </a>";
				echo"<a href='delete.php'><input type='button' value='Delete' class='menu_bar_left' ></a>";
            }
	    ?>
        
        <form method='post' action='SearchResults.php'> <?php /* page not done */ ?>
            <br><input type='text' name='searchQuery' placeholder='Search for a product' maxlength=100>
            <input type='submit' name='submitSearch'>
        </form>
	</body>
</html>
