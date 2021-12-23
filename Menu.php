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
    	    	echo"<a href='Home.php'>Home </a>"; 	//website title will redirect to home page too
                echo"<a href='Profile.php'>Profile </a>"; //not made yet
                echo"<a href='Cart.php'>Cart </a>"; //not made yet
		        echo"<a href='SignOut.php'> SignOut </a>";
				echo"<a href='delete.php'>Delete </a>"; 
                echo"<a href='survey.php'>Survey </a>";
                echo"<a href='SurveyResults.php'>Survey Results</a>";
                
                
	        }
	        else{
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
        
        <form method='post' action='SearchResults.php'> <?php /* page not made yet */ ?>
            <input type='text' name='searchQuery' placeholder='Search for a product' maxlength=75>
            <input type='submit' name='submitSearch'>
        </form>
	</body>
</html>
