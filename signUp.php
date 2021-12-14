<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
<body>
<div class="signUpForm">
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validate(this);" >
<h1>Sign Up</h1>
Username: <br>
<input type="text" name="username" placeholder="Enter your username"><br>
Email: <br>
<input type="text" name="email" placeholder="Enter your email address"><br>
Password: <br>
<input type="password" name="password" placeholder="Enter your password"><br>
Address: <br>
<input type="text" name="address" placeholder="Enter your delivery address"><br>
Image: <br>
<input type="file" name="profilepic"><br>
<input type="submit" name="submit"><br>
</form>
</div>

<script>
    function validate(form){
        fail="";
        if(form.username.value=="")
            fail+="Username required  ";
        if(form.email.value=="")
            fail+="Email required  ";
        else{
            <?php
            $sanitizedEmail= filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            if(!filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL)){
                ?>
                fail += "Invalid email  ";
                <?php
            }
            ?>
        }
        if(form.password.value==""){
            fail+="Password required  ";
        }
        if(form.address.value=="")
            fail+="Address required  ";
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
    //defaultImage="ProfilePictures/default.png";
    $username=$_POST["username"];
    $password=$_POST["password"];
    $email=$_POST["email"];
    $address=$_POST["address"];
    $imagePath=""; 
    $userType="customer"; //default usertype is customer
    $default=false;

    if($_FILES["profilepic"]["size"]==0){
        $imagePath="ProfilePictures/default.png"; //default image
    }
    else{
        $target_dir="ProfilePictures/";
        $target_file=$target_dir.basename($_FILES["profilepic"]["name"]);
        $imageType= strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        if(file_exists($target_file)){ //why does it matter if the file exists already? normally multiple users can have the same pic
            echo "Image already exists<br>";
            $imagePath="ProfilePictures/default.png";
        }
        else if($_FILES["profilepic"]["size"]>1000000){
            echo "Image size is too large<br>";
            $imagePath="ProfilePictures/default.png";
        }
        else if($imageType != "jpeg" && $imageType != "jpg" && $imageType != "png"){
            echo "Incorrect file type; Enter a jpg, jpeg or png<br>";
            $imagePath="ProfilePictures/default.png";
        }
        else{
            if(move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)){
                $imagePath=$target_file;
            }
            else{
                $imagePath="ProfilePictures/default.png";
            }
        }
    }

    $con = mysqli_connect("localhost","root","","project");
    if(!$con){
        echo "connection error<br>";
        die();
    }
    $sql="INSERT INTO users(username,password,email,address,imagePath,userType) VALUES('" . $username . "','" . $password . "','" . $email . "','" . $address . "','" . $imagePath ."','" . $userType . "')";
    $result = $con->query($sql);
    if(!$result){
        echo "error inserting data into database<br>";
        printf("Error: %s\n", mysqli_error($con));
    	exit();//exit stops the program
    }
    else{
        echo "inserting successful<br>";
        header("Location:home.php");
    }
    $con->close();
    
}

?>
</body>
</html>