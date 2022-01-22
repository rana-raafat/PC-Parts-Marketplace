<html>
    <head>
        <title> Sign Up </title>
    </head>
    <body>
        <?php 
            session_start();
            include "Menu.php";

            function dbException($queryResult){
                if(!$queryResult){
                    throw new Exception("SQL Error");
                }
                return true;
            }
        ?>
    <script>
    function validate(form){ 
        
        if(form.username.value==""){
            document.getElementById("UsernameError").innerHTML = "Username required";
            document.getElementById("UsernameAlert").style.visibility = "visible";
            return false;
            
        }
        if(form.email.value==""){
           
            document.getElementById("EmailError").innerHTML = "Email required";
            document.getElementById("EmailAlert").style.visibility = "visible";
            return false;
        }
        if(form.password.value==""){
            
            document.getElementById("PasswordError").innerHTML = "Password required";
            document.getElementById("PasswordAlert").style.visibility = "visible";
            return false;
        }
        if(form.address.value==""){
          
            document.getElementById("AddressError").innerHTML = "Address required";
            document.getElementById("AddressAlert").style.visibility = "visible";
            return false;
        } 
        return true; 
    }
    </script>

<div class="container">
    <div class="card">
        <div class="carda">
        <form method="post" action="" enctype="multipart/form-data" onsubmit="return validate(this);" class="form-horizontal">
            <h1>Sign Up</h1><br><br>
            <div class ="form-group">
                <label for="profilepic">Profile Picture:</label> <br>
                <input type="file" name="profilepic" class="form-control-file" ><br><br>
                <br>
          
                <label for="Username">Username:</label>
                <input type="text" name="username" placeholder="Enter your username" maxlength=25 class="form-control">
                
                <div class='alert alert-danger' id="UsernameAlert" style="visibility: hidden" >               
                    <i class="glyphicon glyphicon-exclamation-sign"></i>
                    <label id="UsernameError"></label>
                    <a href class="close" alert-hide=".alert">
                        <span aria-hidden="true">&times;</span>
                    </a> 
                </div>
                <div class='alert alert-danger' id="UsernameTakenAlert" style="visibility: hidden">               
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                    <label id="UsernameTakenError"></label>
                    <a href class="close" alert-hide=".alert">
                        <span aria-hidden="true">&times;</span>
                    </a> 
                </div><br>


        
                <label for="Email">Email:</label>
                <input type="text" name="email" placeholder="Enter your email address" class="form-control">
                <div class='alert alert-danger' id="EmailAlert" style="visibility: hidden">               
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                    <label id="EmailError"></label>
                    <a href class="close" alert-hide=".alert">
                        <span aria-hidden="true">&times;</span>
                    </a> 
                </div>
                <div class='alert alert-danger' id="BadEmailAlert" style="visibility: hidden">               
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                    <label id="BadEmailError"></label>
                    <a href class="close" alert-hide=".alert">
                        <span aria-hidden="true">&times;</span>
                    </a>  
                </div>
                <div class='alert alert-danger' id="EmailTakenAlert" style="visibility: hidden">               
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <label id="EmailTakenError"></label>
                    <a href class="close" alert-hide=".alert">
                        <span aria-hidden="true">&times;</span>
                    </a>  
                </div>


           
                <br><label for="Password">Password:</label><br>
                <input type="password" name="password" placeholder="Enter your password" maxlength=50 minlength=8 class="form-control">
                <div class='alert alert-danger' id="PasswordAlert" style="visibility: hidden">               
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                    <label id="PasswordError"></label>
                    <a href class="close" alert-hide=".alert">
                        <span aria-hidden="true">&times;</span>
                    </a> 
                </div><br>


          
                <label for="Address">Address:</label><br>
                <input type="text" name="address" placeholder="Enter your delivery address"  class="form-control" >
                <div class='alert alert-danger' id="AddressAlert" style="visibility: hidden">               
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                    <label id="AddressError"></label>
                    <a href class="close" alert-hide=".alert">
                        <span aria-hidden="true">&times;</span>
                    </a>  
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
    $password=$_POST["password"];
    $email=$_POST["email"];
    $address=$_POST["address"];
    $imagePath="resources/images/ProfilePictures/default.png"; //default image
    $userType="customer"; //default usertype is customer
    
    $sanitizedEmail= filter_var($email, FILTER_SANITIZE_EMAIL); 
    if(!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)){  //check if valid email
        ?>
        <script>
            document.getElementById("BadEmailError").innerHTML = "Enter a valid email";
            document.getElementById("BadEmailAlert").style.visibility = "visible";
        </script>
        <?php
    }
    else{

        $con = mysqli_connect("localhost","root","","project");
        if(!$con){ 
            echo "connection error<br>";
            die();
        }

        $checkEmail="SELECT * FROM users WHERE email='" . $email . "'";
        $checkUsername="SELECT * FROM users WHERE username='" . $username . "'";
        $EmailResult = $con->query($checkEmail);
        try{
            dbException($EmailResult);
        }
        catch(Exception $e){
            printf("Error: %s\n", mysqli_error($con));
            die();
        }
        $UsernameResult = $con->query($checkUsername);
        try{
            dbException($UsernameResult);
        }
        catch(Exception $e){
            printf("Error: %s\n", mysqli_error($con));
            die();
        }

        if($EmailResult->num_rows > 0){
     
           ?>
            <script>
                document.getElementById("EmailTakenError").innerHTML = "Email already exists";
                document.getElementById("EmailTakenAlert").style.visibility = "visible";
            </script>
            <?php
           
        }
        else if($UsernameResult->num_rows > 0){
          
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
            try{
                dbException($result);
            }
            catch(Exception $e){
                printf("Error: %s\n", mysqli_error($con));
                die();
            }
            //create a new order for the user
            $IDsql = "SELECT id FROM users WHERE username='" . $username ."'"; 
            $IDresult = $con->query($IDsql);
            try{
                dbException($IDresult);
            }
            catch(Exception $e){
                printf("Error: %s\n", mysqli_error($con));
                die();
            }
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
        $con->close();
    }
}
?>



    </body>
</html>
