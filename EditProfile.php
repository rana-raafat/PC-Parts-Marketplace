<html>
    <head>
        <title> Edit Profile </title>
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
                if(!$con){ 
                    echo "connection error";
                    echo "<br>";
                    die();
                }
                $email = $_POST["email"];
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){  
                    $emailError='Please enter a valid email';
                }
                else{
                    $checkUsername="SELECT * FROM users WHERE username='" . $_POST['username'] . "' AND username!='" . $_SESSION['username'] . "'";
                    $UsernameResult = $con->query($checkUsername);
                    try{
                        dbException($UsernameResult);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($con));
                        die();
                    }
                    if($UsernameResult->num_rows > 0){
                        $usernameError = "Username already taken";
                    }
                    else{
                        $imagePath=$_SESSION['imagePath'];

                        if ( isset( $_FILES["profilepic"] ) && !empty( $_FILES["profilepic"]["name"] ) ) {
                            $target_dir="resources/images/ProfilePictures/";
                            $target_file=$target_dir . basename($_FILES["profilepic"]["name"]);
                            $imageType=strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                            if(file_exists($target_file)){ //check if pic already exists, if it does don't move_uploaded_file so there are no duplicates
                                $imagePath=$target_file;
        
                            }
                            else if($_FILES["profilepic"]["size"]>1000000){
                                echo "Error: Image size is too large";
                                echo "<br>";
                            }
                            else if($imageType != "jpeg" && $imageType != "jpg" && $imageType != "png"){
                                echo "Error: Incorrect file type, Please enter a jpg, jpeg or png";
                                echo "<br>";
                            }
                            else{
                                if(move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)){
                                    $imagePath=$target_file;
                                }
                                else{
                                    echo "Error uploading image";
                                    echo "<br>";
                                }
                            }
                        }

                        if($_POST['password']!=$_SESSION['password']){
                            $encryptedPass = md5($_POST['password']);
                        }
                        else{
                            $encryptedPass=$_POST['password'];
                        }

                        $updatesql = "UPDATE users SET username='" . $_POST['username'] . "', password='" . $encryptedPass . "', email='" 
                        . $_POST['email'] . "', address='" . $_POST['address'] . "', imagePath='" . $imagePath . "' WHERE id='" . $_SESSION['id'] . "'";
                        $updateResult = $con->query($updatesql);
                        try{
                            dbException($updateResult);
                        }
                        catch(Exception $e){
                            printf("Database Error: %s\n", mysqli_error($con));
                            die();
                        }
                        /*if (!$updateResult) {
                            printf("Error: %s\n", mysqli_error($con));
                            die();
                        }
                        else{*/
                            $_SESSION["username"]=$_POST['username'];
                            $_SESSION["password"]=$encryptedPass;
                            $_SESSION["email"]=$_POST['email'];
                            $_SESSION["address"]=$_POST['address'];
                            $_SESSION["imagePath"]=$imagePath;
                            echo "<script>window.location.href='Profile.php'</script>";
                        //}
                    }
                }
                $con->close();
            }

            echo "<div class='container'>";
            echo "<div class='card justify-content-center'>";
            echo "<div class='profile'>";
            echo "<img src='" . $_SESSION['imagePath'] ."' class='profile-image'>";
            echo "<br>";
            echo "<input type='file' name='profilepic'>";
            echo "<br><br>";
            echo "<text class='header'> Username </text>";
            echo "<br>";
            echo "<input type='text' name='username' value='" . $_SESSION['username'] . "'>";
            echo "<br>";
            if(!empty($usernameError)){
            ?>
            <div class='alert alert-danger'>               
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <?php echo $usernameError ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <?php
            }
            echo "<br>";
            echo "<text class='header'> Email </text>";
            echo "<br>";
            echo "<input type='text' name='email' value='". $_SESSION['email'] ."'>";
            echo "<br>";
            if(!empty($emailError)){
            ?>
            <div class='alert alert-danger'>               
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <?php echo $emailError ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> 
            </div>
            <?php 
            }           
            echo "<br>";
            echo "<text class='header'> Password </text>";
            echo "<br>";
            echo "<input type='password' name='password' value='" . $_SESSION['password'] . "' min='8'>";
            echo "<br><br>";
            echo "<text class='header'> Address </text>";
            echo "<br>";
            echo "<input type='text' name='address' value='" . $_SESSION['address'] . "'>";
            echo "<br><br>";
            echo "<input type='submit' name='submit'>";
            echo "<br><br>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        else{
            echo "Error: please log in to your account";
            echo "<br>";
        }
        ?>
        </form>
    </body>
</html>