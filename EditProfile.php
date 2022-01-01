<html>
    <head>
        <title> Edit Profile </title>
    </head>
    <body>
        <?php
        session_start();
        include "Menu.php";

        ?>
        <script>
        function validate(form){ 
            var fail="";
            if(form.username.value==""){
                fail+="Userame required\n";
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
        <form method="post" action="" enctype="multipart/form-data" onsubmit="return validate(this);">
        <?php
        
        $emailError='';
        $usernameError='';
        if(isset($_SESSION['id'])){

            if(isset($_POST['submit'])){
                $con = mysqli_connect("localhost","root","","project");
                if(!$con){ //maybe here we can throw an exception? instead of using die()
                    echo "connection error<br>";
                    die();
                }
                $email = $_POST["email"];
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){  
                    $emailError='Please enter a valid email';
                }
                else{
                    $checkUsername="SELECT * FROM users WHERE username='" . $_POST['username'] . "'";
                    $UsernameResult = $con->query($checkUsername);

                    if($UsernameResult->num_rows > 0){
                        $usernameError = "Username already taken<br>";
                    }
                    else{
                        $imagePath=$_SESSION['imagePath'];
                        $target_dir="resources/images/ProfilePictures/";
                        $target_file=$target_dir . basename($_FILES["profilepic"]["name"]);
                        $imageType= strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        
                        if(file_exists($target_file)){ //check if pic already exists, if it does don't move_uploaded_file so there are no duplicates
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

                        $updatesql = "UPDATE users SET username='" . $_POST['username'] . "', password='" . $_POST['password'] . "', email='" 
                        . $_POST['email'] . "', address='" . $_POST['address'] . "', imagePath='" . $imagePath . "'";
                        //$updateResult = $con->query($updatesql);
                    }
                }
                $con->close();
            }

            echo "<img src='" . $_SESSION['imagePath'] ."'><input type='file' name='profilepic'><br>";
            echo "<input type='text' name='username' value='" . $_SESSION['username'] . "'>" . $usernameError ;
            echo "<br><br><input type='text' name='email' value='". $_SESSION['email'] ."'>". $emailError ."<br><br>";
            echo "<input type='password' name='password' value='" . $_SESSION['password'] . "' min='8'><br><br>" ;
            echo "<input type='text' name='address' value='" . $_SESSION['address'] . "'><br><br>" ;
            echo "<input type='submit' name='submit'><br>";
        }
        else{
            echo "Error: please log in to your account<br>";
        }
        ?>
        </form>
    </body>
</html>