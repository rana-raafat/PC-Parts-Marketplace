<?php
        session_start();
        //include "Menu.php";

        function dbException($queryResult){
            if(!$queryResult){
                throw new Exception("SQL Error");
            }
            return true;
        }
    

        //if(isset($_POST['Submit'])){
         $errors="";
            //$email=$_POST["Email"];
            $email=$_GET['em'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))//check if valid email
            {  
                /*echo "<script> 
                    document.getElementById('EmailError').innerHTML = 'Enter a valid email';
                    document.getElementById('EmailAlert').style.visibility = 'visible';
                    </script>";*/
                    $errors="Invalid email";
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
                $encryptedPass = md5($_GET['pass']);
                //$encryptedPass = md5($_POST['Password']);

                //$sql= "SELECT * FROM users WHERE email='" . $_POST['Email'] . "' AND password='" . $encryptedPass . "'";
                $sql= "SELECT * FROM users WHERE email='" . $email . "' AND password='" . $encryptedPass . "'";
                $result = mysqli_query($conn,$sql);	
                try{
                    dbException($result);
                }
                catch(Exception $e){
                    //printf("Database Error: %s\n", mysqli_error($conn));
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

                    //echo "<script>window.location.href='Home.php'</script>";
                }
                else{
                    $errors="Incorrect email or password";
                   /* echo "<script> 
                        document.getElementById('loginError').innerHTML = 'Incorrect email or password';
                        document.getElementById('loginAlert').style.visibility = 'visible';
                        </script>";*/
                }
            }
            if($errors=="")
                echo "";
            echo $errors;
        //}
        ?>