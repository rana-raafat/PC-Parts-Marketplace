<html>
    <head>
        <title> Sign Up </title>
        <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php 
            session_start();
            include "Menu.php";
        ?>
    <script>
    function validate(form){ //sometimes when the script is under the form it causes an error where the form doesn't know what the validate function is
        //var fail="";
        if(form.username.value==""){
            document.getElementById("UsernameError").innerHTML = "Username required";
            document.getElementById("UsernameAlert").style.visibility = "visible";
            return false;
            //fail+="Username required\n";
        }
        if(form.email.value==""){
            //fail+="Email required\n";
            document.getElementById("EmailError").innerHTML = "Email required";
            document.getElementById("EmailAlert").style.visibility = "visible";
            return false;
        }
        if(form.password.value==""){
            //fail+="Password required\n";
            document.getElementById("PasswordError").innerHTML = "Password required";
            document.getElementById("PasswordAlert").style.visibility = "visible";
            return false;
        }
        if(form.address.value==""){
            //fail+="Address required\n";
            document.getElementById("AddressError").innerHTML = "Address required";
            document.getElementById("AddressAlert").style.visibility = "visible";
            return false;
        }
        /*if(fail == ""){
            return true;
        }
        else{
            alert(fail);
            return false;
        }  */  
        return true; 
    }
    </script>

<div class="container">
    <div class="card justify-content-center">
        <div class="carda">
        <form method="post" action="" enctype="multipart/form-data" onsubmit="return validate(this);" class="form-horizontal">
            <h1>Sign Up</h1><br><br>
            <div class ="form-group">
                <label for="profilepic">Profile Picture:</label> <br>
                <input type="file" name="profilepic" class="form-control-file" ><br><br>
                <br>
          
                <label for="Username">Username:</label>
                <input type="text" name="username" placeholder="Enter your username" maxlength=25 class="form-control">
                <div class='alert alert-danger' id="UsernameAlert" style="visibility: hidden">               
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <label id="UsernameError"></label>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div>
                <div class='alert alert-danger' id="UsernameTakenAlert" style="visibility: hidden">               
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <label id="UsernameTakenError"></label>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div><br>


        
                <label for="Email">Email:</label>
                <input type="text" name="email" placeholder="Enter your email address" class="form-control">
                <div class='alert alert-danger' id="EmailAlert" style="visibility: hidden">               
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <label id="EmailError"></label>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div>
                <div class='alert alert-danger' id="BadEmailAlert" style="visibility: hidden">               
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <label id="BadEmailError"></label>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div>
                <div class='alert alert-danger' id="EmailTakenAlert" style="visibility: hidden">               
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <label id="EmailTakenError"></label>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div>


           
                <br><label for="Password">Password:</label><br>
                <input type="password" name="password" placeholder="Enter your password" maxlength=50 minlength=8 class="form-control">
                <div class='alert alert-danger' id="PasswordAlert" style="visibility: hidden">               
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <label id="PasswordError"></label>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div><br>


          
                <label for="Address">Address:</label><br>
                <input type="text" name="address" placeholder="Enter your delivery address"  class="form-control" >
                <div class='alert alert-danger' id="AddressAlert" style="visibility: hidden">               
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <label id="AddressError"></label>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                </div><br>
            </div>
            <input type="submit" name="submit"><br>
        </form>
        </div>
    </div>
</div>



<?php 
if(isset($_POST["submit"])){
    
    $username=$_POST["username"];
    $username=filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $password=$_POST["password"];
    $password=filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $email=$_POST["email"];
    $email=filter_var($email, FILTER_SANITIZE_EMAIL);
    $address=$_POST["address"];
    $address=filter_var($address, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $imagePath="resources/images/ProfilePictures/default.png"; //default image
    $userType="customer"; //default usertype is customer
 
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){  //check if valid email
        ?>
        <script>
            document.getElementById("BadEmailError").innerHTML = "Enter a valid email";
            document.getElementById("BadEmailAlert").style.visibility = "visible";
        </script>
        <?php
    }
    else{

        $con = mysqli_connect("localhost","root","","project");
        if(!$con){ //maybe here we can throw an exception? instead of using die()
            echo "connection error<br>";
            die();
        }

        $checkEmail="SELECT * FROM users WHERE email='" . $email . "'";
        $checkUsername="SELECT * FROM users WHERE username='" . $username . "'";
        $EmailResult = $con->query($checkEmail);
        $UsernameResult = $con->query($checkUsername);
        //try catch exception

        if($EmailResult->num_rows > 0){
           // echo "An account with this email already exists<br>";
           ?>
            <script>
                document.getElementById("EmailTakenError").innerHTML = "Email already exists";
                document.getElementById("EmailTakenAlert").style.visibility = "visible";
            </script>
            <?php
           
        }
        else if($UsernameResult->num_rows > 0){
            //echo "Username already taken<br>";
            ?>
            <script>
                document.getElementById("UsernameTakenError").innerHTML = "Username already taken";
                document.getElementById("UsernameTakenAlert").style.visibility = "visible";
            </script>
            <?php
        }
        else{
            $target_dir="resources/images/ProfilePictures/";
            $target_file=$target_dir . basename($_FILES["profilepic"]["name"]);
            $imageType= strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            if($_FILES["profilepic"]["size"]==0){ //check if no image is inserted
                echo "Default picture used<br>";
            }
            else if(file_exists($target_file)){ //check if pic already exists, if it does don't move_uploaded_file so there are no duplicates
                $imagePath=$target_file;
            }
            else if($_FILES["profilepic"]["size"]>1000000){
                echo "Error: Image size is too large<br>";
            }
            else if($imageType != "jpeg" && $imageType != "jpg" && $imageType != "png"){
                echo "Error: Incorrect file type, Please enter a jpg, jpeg or png<br>";
            }
            else{
                if(move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)){
                    $imagePath=$target_file;
                }
                else{
                    echo "Error uploading image<br>";
                }
            }
            
            $encryptedPass = md5($password);

            $sql="INSERT INTO users(username,password,email,address,imagePath,userType) VALUES('" . $username . "','" . $encryptedPass 
                . "','" . $email . "','" . $address . "','" . $imagePath ."','" . $userType . "')";

            $result = $con->query($sql);
            if(!$result){
                echo "error inserting data into database<br>";
                printf("Error: %s\n", mysqli_error($con));
        	    exit(); //exit stops the program
            }
            else{
                //create a new order for the user
                $IDsql = "SELECT id FROM users WHERE username='" . $username ."'"; //not tested
                $IDresult = $con->query($IDsql);
                if($IDresult->num_rows == 0){
                    echo "Error: user not found<br>";
                }
                else if($idrow = $IDresult->fetch_assoc()){
                    $ordersql = "INSERT INTO orders(customerID, numberOfProducts, completed) VALUES('". $idrow['id'] . "','0','0')";
                    $orderResult = $con->query($ordersql);
                    if(!$ordersql){
                        echo "Error: couldn't create new order<br>";
                    }
                    else{
                        echo "Account creation successful<br>";
                        //echo "<script>window.location.href='Home.php'</script>";
                        ?>
                        <script>
                        $(document).ready(function() {
                            window.location.replace("Home.php");;
                        });
                        </script>
                        <?php
                    }
                }
            }
        }
        $con->close();
    }
}
?>



    </body>
</html>
