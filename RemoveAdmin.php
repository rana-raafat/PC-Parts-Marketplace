<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Remove an Admin</title>
    </head>
    <body>
        <?php
        session_start();
        include "Menu.php";
        
        
        if(isset($_SESSION['id'])){
            if(isset($_GET['id'])){
                $adminID=$_GET['id'];
                if($_SESSION['userType']=='administrator'){
                    $con = new mysqli("localhost", "root", "", "project");
                    if(!$con){ 
                        echo "connection error<br>";
                        die();
                    }

                    $updatesql= "UPDATE users SET userType='customer' WHERE id='" . $adminID . "'";
                    $updateresult = mysqli_query($con,$updatesql);
                    
                    $deletesql= "DELETE FROM administrator WHERE id='". $adminID . "'";
                    $deleteResult = mysqli_query($con,$deletesql);
                    
                    if (!$deleteResult || !$updateresult) {
                        if (!$deleteResult){
                            echo "Error deleting from administrator table<br>";
                        }
                        else{
                            echo "Error updating users table<br>";
                        }
                    }
                    else{
                        echo "<script>window.history.go(-1);</script>";
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
