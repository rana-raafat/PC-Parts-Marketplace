<html>
    <?php 
    session_start();
    include "Menu.php";
     ?>
<body>
    <h3>SignUp</h3>

<script>
    function validate(form){
        var fail="";
        if(form.username.value==""){
            fail+="Username required   ";
        }
        if(form.email.value==""){
            fail+="Email required   ";
        }
        if(form.password.value==""){
            fail+="Password required    ";
        }
        if(form.address.value==""){
            fail+="Address required  ";
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

<form method="post" action="SignUp.php" enctype="multipart/form-data" onsubmit="return validate(this);">

    Image: <input type="file" name="profilepic"><br><br>
    Username: <input type="text" name="username" maxlength=25><br>
    Email: <input type="text" name="email"><br>
    Password: <input type="password" name="password" maxlength=75 minlength=8><br>
    Address: <input type="text" name="address"><br><br>

    <input type="submit" name="submit"><br>
</form>
<?php 

if(isset($_POST["submit"])){
    
    $username=$_POST["username"];
    $password=$_POST["password"];
    $email=$_POST["email"];
    $address=$_POST["address"];
    $imagePath="ProfilePictures/default.png"; //default image
    $userType="customer"; //default usertype is customer
    
    $sanitizedEmail= filter_var($email, FILTER_SANITIZE_EMAIL); 
    if(!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)){  //check if valid email
        echo "Error: Please enter a valid email<br>";
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
        $UsernameResult = $con->query($checkUsername);

        if($EmailResult->num_rows > 0){
            echo "An account with this email already exists<br>";
        }
        if($UsernameResult->num_rows > 0){
            echo "Username already taken<br>";
        }
        else{
            
            $target_dir="ProfilePictures/";
            $target_file=$target_dir.basename($_FILES["profilepic"]["name"]);
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
            
            $sql="INSERT INTO users(username,password,email,address,imagePath,userType) VALUES('" . $username . "','" . $password 
                . "','" . $email . "','" . $address . "','" . $imagePath ."','" . $userType . "')";

            $result = $con->query($sql);
            if(!$result){
                echo "error inserting data into database<br>";
                printf("Error: %s\n", mysqli_error($con));
        	    exit(); //exit stops the program
            }
            else{
                echo "Account creation successful<br>";
                header("Location:SignUp.php");
                //header("Location:Home.php");
            }
        }
        $con->close();
    }
}

?>


</body>
</html>