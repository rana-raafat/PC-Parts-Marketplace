<html>
    <head>
        <title> Log In </title>
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
    </head>
    <body>

        <div class="container">
            <div class="card justify-content-center">
                <div class="carda">
                    <form action="" method="post" enctype="multipart/form-data" onsubmit="return validate(this);" class="form-horizontal">
                        <h1>Log In</h1>
                        <div class='alert alert-danger' id="loginAlert" style="visibility: hidden" >               
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <label id="loginError"></label>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> 
                        </div>
                        <br>
                        <label for="Email">E-mail:</label>
                        <input type="text"name="Email" placeholder="example@mail.com" class="form-control" >

                        <div class='alert alert-danger' id="EmailAlert" style="visibility: hidden">               
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <label id="EmailError"></label>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> 
                        </div>
                        <br>

                        <label for="Password">Password:</label>
                        <input type="Password" name="Password" id="Password" placeholder="********" maxlength=50 minlength=8 class="form-control">

                        <div class='alert alert-danger' id="PasswordAlert" style="visibility: hidden" >               
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <label id="PasswordError"></label>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> 
                        </div>
                        <br>

                        <input type="submit"  value="Submit" name ="Submit">
                        <input type="reset"> 
                        <br>
                    </form>
                </div>
            </div>
        </div>

        <?php

        if(isset($_POST['Submit'])){
         
            $email=$_POST["Email"];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))//check if valid email
            {  
                echo "<script> 
                    document.getElementById('EmailError').innerHTML = 'Enter a valid email';
                    document.getElementById('EmailAlert').style.visibility = 'visible';
                    </script>";
            }
            else{
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "project";
               
                $conn = new mysqli($servername, $username, $password, $dbname);
                if(!$conn){ 
                    echo "connection error<br>"; 
                    die();
                }

                $encryptedPass = md5($_POST['Password']);

                $sql= "SELECT * FROM users WHERE email='" . $_POST['Email'] . "' AND password='" . $encryptedPass . "'";
                $result = mysqli_query($conn,$sql);	
                try{
                    dbException($result);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($conn));
                    die();
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
                    
                    echo "<script> 
                        document.getElementById('loginError').innerHTML = 'Incorrect email or password';
                        document.getElementById('loginAlert').style.visibility = 'visible';
                        </script>";
                }
            }
        }
        ?>

        <script>
            function validate(form){
             
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
                return true;
            }
        </script>

    </body>
</html>