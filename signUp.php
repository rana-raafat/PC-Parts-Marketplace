<html>
    <head>
        <link rel="stylesheet" href="Style.css">
    </head>
<body>
<?php 
    session_start();
    include "Menu.php";
?>
<div class="SignUpForm">
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validate(this);" >
<h1>Sign Up</h1>
Image: <br>
<input type="file" name="profilepic"><br>
Username: <br>
<input type="text" name="username" placeholder="Enter your username"><br>
Email: <br>
<input type="text" name="email" placeholder="Enter your email address"><br>
Password: <br>
<input type="password" name="password" placeholder="Enter your password"><br>
Address: <br>
<input type="text" name="address" placeholder="Enter your delivery address"><br>
<input type="submit" name="submit"><br>
</form>
</div>

<script>
    function validate(form){
        var fail="";
        if(form.username.value==""){
            fail+="Username required\n";
        }
        if(form.email.value==""){
            fail+="Email required\n";
        }
        if(form.password.value==""){
            fail+="Password required\n";
        }
        if(form.address.value==""){
            fail+="Address required\n";
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
            
            $target_dir="resources/images/ProfilePictures/";
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