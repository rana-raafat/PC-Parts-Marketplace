<html>
    <head>
        <title> Log In </title>
        <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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

            echo "<script>window.location.href='Home.php'</script>";
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
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-6 mx-auto">
            <div class="carda h-100 border-primary justify-content-center">
                <div>


<!--<div class="carda mx-auto">-->
<!---  <img class="card-img-top" src="..." alt="Card image cap">--->
  
    <!--<h5 class="card-title" style="color:cyan;" >Card title</h5>-->
    <!--<p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&ab_channel=RickAstley" class="btn btn-primary">Go somewhere</a>-->
<form action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this);" class="form-horizontal">
<h1>Log In</h1><br><br>
  <!--<div class="form-horizontal">-->
    <label for="Email">E-mail:</label>
    <input type="text" class="form-control" name="Email" id="Email" placeholder="example.123@mailname.com" style= " text-align: center;">
 <!-- </div>-->
 <!-- <div class="form-horizontal">-->
    <label   style= "color: White;" >Password:</label>
    <input type="Password" name="Password" class="form-control" id="Password" placeholder="********" style= " text-align: center;">
  <!--</div>-->
  <input type="submit"  value="Submit" name ="Submit">
  <input type="reset" > <br><br>
 
<!-- -->

</form>
</div>
</div>
</div>
</div>
</div>
  

<!-- original format
<form action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this);">
	Email:<br>
	<input type="text" name="Email" placeholder="Enter your email address">  <br>
	Password:<br>
	<input type="Password" name="Password" placeholder="Enter your password"><br>
	<input type="submit" value="Submit" name="Submit">
	<input type="reset">
    
</form>-->
    </body>
</html>