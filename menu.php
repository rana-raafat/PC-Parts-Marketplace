<html>
	<head><link rel="stylesheet" href="style.css"></head>
<body>
    <a href='Home.php'><h1>Website name</h1></a>		
    <?php
	//session_start();
    
	if(!empty($_SESSION['Name'])){ //if logged in
		echo "<h2>Welcome ". $_SESSION['Name'] . " <img src='". $_SESSION['image']."' alt='profilepic' width='20' height='20'></h2>";
		echo"<a href='Home.php'>Home</a>"; 	//website title will redirect to home page too
        echo"<a href='Profile.php'>Profile</a>"; //not made yet
        echo"<a href='Cart.php'>SCart</a>"; //not made yet
		echo"<a href='SignOut.php'>SignOut</a>"; //not made yet
	}
	else{
		echo "<h2>Welcome</h2>";
		echo"<a href='Home.php'>Home</a>";
		echo"<a href='LogIn.php'>Login</a>"; //not made yet
		echo"<a href='SignUp.php'>SignUp</a>";
	}
	?>
    <form method='post' action='searchResults.php'> <?php /* page not made yet */ ?>
    
    <br><input type='text' name='searchQuery' placeholder='Search for a product' maxlength=75>
       <input type='submit' name='submitSearch'>
    </form>
	</body>
</html>
