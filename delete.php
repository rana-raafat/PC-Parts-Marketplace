<html>
	
	<?php

		session_start();

		// Create connection
		if(isset($_POST['Yes'])) {

			$conn = new mysqli("localhost","root","", "project");
			//echo $_SESSION['email'];
			$sql="DELETE FROM users WHERE email ='". $_SESSION['email'] . "'";
			$result=mysqli_query($conn,$sql);
			session_destroy();
			header("Location:home.php");

        }
        if(isset($_POST['No'])) {
            header("Location:home.php");
        }

		/*
		$conn = new mysqli("localhost","root","", "project");
		$sql="DELETE FROM users WHERE email ='". $_SESSION['email'] . "'";
		$result=mysqli_query($conn,$sql);
		if($result)	
		{
			session_destroy();
			header("Location:home.php");
		}
		else
		{
			echo $sql;
		}
		*/	
	?>

	<form action="" method="post">

		Are you sure you want to Delete your account Yes/No<br>

        <input type="submit" name="Yes" value="Yes"/>
        <input type="submit" name="No" value="No"/>
	</form>
</html>

