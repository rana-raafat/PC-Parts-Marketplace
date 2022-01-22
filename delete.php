<html>
	<head>
		<title>Delete Account</title>
	</head>
	<body>
		<?php
			session_start();
            include "Menu.php";

		
			if(isset($_POST['Yes'])) {

				$conn = new mysqli("localhost","root","", "project");
				if(!$con){ 
					echo "connection error<br>";
					die();
				}
			
				$sql="DELETE FROM users WHERE email ='". $_SESSION['email'] . "'";
				$sql2="DELETE FROM orders WHERE customerID ='". $_SESSION['id'] . "'";
				$result=mysqli_query($conn,$sql);
				
				if(!$result){
					
					echo "Error deleting user";
				}
				else{
					$result2=mysqli_query($conn,$sql2);
					if(!$result2){
						echo "Error deleting orders";
					}
					else{
						session_destroy();
						echo "<script>window.location.href='Home.php'</script>";
					}
					
				}
				$con->close();
    	    }
        	else if(isset($_POST['No'])) {
				echo "<script> 
						$('#deleteAccountModal .close').click(); 
						window.history.go(-1);
			 		  </script>";     
			}
		?>
	</body>
</html>

