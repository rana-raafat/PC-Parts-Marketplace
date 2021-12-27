<html>
	<head>
		<title>Delete Account</title>
	</head>
	<body>
	<?php
		session_start();
		include_once "Menu.php";
		
		// Create connection
		if(isset($_POST['Yes'])) {

			$conn = new mysqli("localhost","root","", "project");
			//echo $_SESSION['email'];
			$sql="DELETE FROM users WHERE email ='". $_SESSION['email'] . "'";
			$result=mysqli_query($conn,$sql);
			if(!$result){
				//throw exception maybe? that says Database error or sth
			}
			else{
				session_destroy();
				header("Location:home.php");
			}
        }
        if(isset($_POST['No'])) {
            header("Location:home.php");
        }
	?>

	<form action="" method="post">

		Are you sure you want to delete your account Yes/No<br>

        <input type="submit" name="Yes" value="Yes"/>
        <input type="submit" name="No" value="No"/>
	</form>
	</body>
</html>

