<html>
    <head>
        <link rel="stylesheet" href="Style.css">
    </head>
    <body>

<?php
//
session_start();
if(isset($_POST['Submit'])){ //check if form was submitted
     
    $email=$_POST["Email"];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))//check if valid email
    {  
        echo "Error: Please enter a valid email<br>";
    }
    //when the user enters an invalid email then we shouldn't proceed and access the db so from $servername till the end should be inside an "else{}" statement
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

        $sql= "SELECT * FROM users WHERE email='" . $_POST['Email'] . "' AND password='" . $_POST['Password'] . "'";
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
?>
<?php include "Menu.php";?>

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
<h1>Login</h1>
<form action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this);">
	Email:<br>
	<input type="text" name="Email" placeholder="Enter your email address">  <br>
	Password:<br>
	<input type="Password" name="Password" placeholder="Enter your password"><br>
	<input type="submit" value="Submit" name="Submit">
	<input type="reset">
</form>
    </body>
</html>