<html>
	<head>
		<title>Delete Account</title>
	</head>
	<body>
		<?php
			session_start();
            include "Menu.php";

			// Create connection
			if(isset($_POST['Yes'])) {

				$conn = new mysqli("localhost","root","", "project");
				if(!$con){ //maybe here we can throw an exception? instead of using die()
					echo "connection error<br>";
					die();
				}
				//echo $_SESSION['email'];
				$sql="DELETE FROM users WHERE email ='". $_SESSION['email'] . "'";
				$sql2="DELETE FROM orders WHERE customerID ='". $_SESSION['id'] . "'";
				$result=mysqli_query($conn,$sql);
				$result2=mysqli_query($conn,$sql2);
				if(!$result || !$result2){
					//throw exception maybe? that says Database error or sth
					echo "error deleting";
				}
				else{
					session_destroy();
					echo "<script>window.location.href='Home.php'</script>";
				}
				$con->close();
    	    }
        	else if(isset($_POST['No'])) {
				echo "<script> 
						$('#signOutModal .close').click(); 
						window.history.go(-1);
			 		  </script>";     
			}
		?>
	</body>
</html>

