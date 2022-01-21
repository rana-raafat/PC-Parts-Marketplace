<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Add an Admin</title>
    </head>
    <body>
        <?php
        session_start();
        include "Menu.php";
        
        if(isset($_SESSION['id'])){
            if(isset($_GET['id'])){
                $customerID=$_GET['id'];
                if($_SESSION['userType']=='administrator'){
                    $con = new mysqli("localhost", "root", "", "project");
                    if(!$con){ //exception
                        echo "connection error<br>";
                        die();
                    }

                    $updatesql= "UPDATE users SET userType='administrator' WHERE id='" . $customerID . "'";
                    $updateresult = mysqli_query($con,$updatesql);
                    
                    $insertsql= "INSERT INTO administrator VALUES('". $customerID . "','0')";
                    $insertResult = mysqli_query($con,$insertsql);
                    
                    if (!$insertResult || !$updateresult) {
                        if (!$insertResult){
                            echo "Error inserting into administrator table<br>";
                        }
                        else{
                            echo "Error updating users table<br>";
                        }
                    }
                    else{
                        echo "<script>window.location.href='Home.php'</script>";
                    }
                }
                else{
                    echo "Error: your account does not have this privilege<br>";
                }
            }
            else{
                echo "Error: please try again<br>";
            }
        }
        else{
                echo "Error: please log into your account<br>";
            }
        ?>
    </body>
</html>
