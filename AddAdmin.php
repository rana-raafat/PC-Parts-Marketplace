<html>
    <head>
        <!--------------- WHEN AN ADMIN VIEWS A CUSTOMER'S PROFILE THERE IS AN "ADD AS ADMIN" BUTTON ------------->
        <title>Add Admin</title>
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

                    if(!$con){
                        //ERROR MAKING CONNECTION WITH DATABASE
                        echo "<script>alert('connection error');window.history.go(-1);</script>";
                    }

                    $updatesql= "UPDATE users SET userType='administrator' WHERE id='" . $customerID . "'";
                    $updateresult = mysqli_query($con,$updatesql);
                    
                    $insertsql= "INSERT INTO administrator VALUES('". $customerID . "','0')";
                    $insertResult = mysqli_query($con,$insertsql);
                    
                    if (!$insertResult || !$updateresult) {
                        if (!$insertResult){
                            //ERROR WHILE OPERATING 'insertsql'
                            echo "<script>alert('Error inserting into administrator table');window.history.go(-1);</script>";
                        }
                        else{
                            //ERROR WHILE OPERATING 'updatesql'
                            echo "<script>alert('Error updating users table');window.history.go(-1);</script>";
                        }
                    }
                    else{
                        //EVERYTHING WENT SUCCESSFULLY
                        echo "<script>window.history.go(-1);</script>";
                    }

                }
                else{
                    //ERROR THAT SHOWS IF USER TRYING TO ACCESS PAGE IS NOT AN ADMIN
                    echo "<script>alert('Error: your account does not have this privilege'); window.history.go(-1);</script>";
                }

            }
            else{
                //ERROR THAT SHOWS IF NO 'id' URL QUERY PARAMETER IS SET 
                echo "<script>alert('Error: please try again'); window.history.go(-1);</script>";
            }

        }
        else{
                //ERROR THAT SHOWS IF NO USER IS LOGGED IN
                echo "<script>alert('Error: please log into your account'); window.history.go(-1);</script>";
            }

        ?>
    </body>

        <!-- P.S. 'window.history.go(-1)' IS TO TAKE US BACK TO PROFILE PAGE -->

</html>
