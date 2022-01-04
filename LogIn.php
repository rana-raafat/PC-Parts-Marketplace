<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Log In </title>
    </head>
    <body>

<?php
//
session_start();
include "Menu.php";

if(isset($_POST['Submit'])){ //check if form was submitted
     
    $email=$_POST["Email"];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))//check if valid email
    {  
        exit("Error: Please enter a valid email") ;
    }
    else{
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project";
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        if(!$conn){ //maybe here we can throw an exception? instead of using die()
            echo "connection error<br>";
            die();
        }

        $encryptedPass = md5($_POST['Password']);

        $sql= "SELECT * FROM users WHERE email='" . $_POST['Email'] . "' AND password='" . $encryptedPass . "'";
        $result = mysqli_query($conn,$sql);	

        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }

        
        if($row = $result->fetch_assoc()){
            
            $_SESSION["id"]=$row['id'];
            $_SESSION["username"]=$row['username'];
            $_SESSION["password"]=$row['password'];
            $_SESSION["email"]=$row['email'];
            $_SESSION["address"]=$row['address'];
            $_SESSION["imagePath"]=$row['imagePath'];
            $_SESSION["userType"]=$row['userType'];
            header("Location:Home.php");
            
        }
        else{
            echo "Invalid Email or Password";
        }
    }
}
?>

<script>
    function validate(form){
        var fail="";
        
        if(form.email.value==""){
            fail+="Email required\n";
        }
        if(form.password.value==""){
            fail+="Password required\n";
        }
        if(fail == ""){
            return true;
        }
        else{
            alert(fail);
            return false;
        }
        
    }
</script>
<h1>Log In</h1>
<form action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this);" class="form-horizontal">
	Email:<br>
	<input type="text" name="Email" placeholder="Enter your email address">  <br>
	Password:<br>
	<input type="Password" name="Password" placeholder="Enter your password"><br>
	<input type="submit" value="Submit" name="Submit">
	<input type="reset">
</form>
    </body>
</html>