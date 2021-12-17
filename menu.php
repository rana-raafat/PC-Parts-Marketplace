<!DOCTYPE html>
<html lang="en">
    <head>
		<link rel="stylesheet" href="Style.css">
	</head>
    <body>
        <a href='Home.php'><h1>Website name</h1></a>		
        <?php
	        //session_start();    
        	if(!empty($_SESSION['Name'])){ //if logged in
	    	    echo"<text class='header'>Welcome ". $_SESSION['Name'] . " <img src='". $_SESSION['image']."' alt='profilepic' width='20' height='20'></text>";
    	    	echo"<a href='Home.php'>Home</a>"; 	//website title will redirect to home page too
                echo"<a href='Profile.php'>Profile</a>"; //not made yet
                echo"<a href='Cart.php'>Cart</a>"; //not made yet
		        echo"<a href='SignOut.php'>SignOut</a>"; //not made yet
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
            }
	    ?>
        
        <form method='post' action='SearchResults.php'> <?php /* page not made yet */ ?>
            <input type='text' name='searchQuery' placeholder='Search for a product' maxlength=75>
            <input type='submit' name='submitSearch'>
        </form>
	</body>
</html>