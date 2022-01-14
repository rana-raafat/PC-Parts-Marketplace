<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Penalty </title>
    </head>
    <body>
        <script>
        function validate(form){
            var fail="";
            
            if(form.reason.value==""){
                fail+="Reason required\n";
            }
            if(form.admin.value==""){
                fail+="Category required\n";
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
        session_start();
        include "Menu.php";

        if(isset($_SESSION['id'])){
            if($_SESSION['userType']=='hrpartner'){
                $con = new mysqli("localhost", "root", "", "project");
                if(!$con){ //exception
                    echo "connection error<br>";
                    die();
                }

                $sql= "SELECT * FROM users WHERE userType='administrator'";
                $result = mysqli_query($con,$sql);
                if ($result->num_rows == 0) {
                    echo "Error: No admins found<br>";
                }
                else{
                    ?>
                    <form action='' method='post' onsubmit="return validate(this);">
                    <?php
                    echo "Please select the Admininstrator this penalty will be given to: <select name='admin'>";
                    echo "<option value='' selected>Choose Admin</option>";
                    while($row = $result->fetch_assoc()){
                        echo $row['id'];
                        echo "<option value='". $row['id'] ."'>". $row['username'] . "</option>";
                    }
                    echo "</select>";
                    echo "<br><br>Input reason for penalty: ";
                    echo "<input type='text' name='reason' placeholder='Enter reason'><br><br>";
                    echo "<input type='submit' value='submit' name='submit'>";
                }
                ?>
                </form>
                <?php
                if(isset($_POST['submit'])){
                    $insertsql= "INSERT INTO penalty(adminID, hrID,reason) VALUES('". $_POST['admin'] ."','". $_SESSION['id']."','". $_POST['reason'] ."')";
                    $insertResult = mysqli_query($con,$insertsql);
                    
                    $update_Admin_sql= "UPDATE administrator SET penalties = penalties+1 WHERE id='" . $_POST['admin'] . "'";
                    $update_Admin_Result = mysqli_query($con,$update_Admin_sql);
                    
                    $update_HR_sql= "UPDATE hrpartner SET penaltiesGiven = penaltiesGiven+1 WHERE id='" . $_SESSION['id'] . "'";
                    $update_HR_Result = mysqli_query($con,$update_HR_sql);

                    $selectPenaltiessql="SELECT penalties FROM administrator WHERE id='" . $_POST['admin'] . "'";
                    $penaltyResult = $con->query($selectPenaltiessql);

                    if(!$insertResult || !$update_HR_Result || !$update_Admin_Result || $penaltyResult->num_rows == 0) {
                        if (!$insertResult){
                            echo "Error inserting into penalty table<br>";
                        }
                        else if(!$update_HR_Result){
                            echo "Error updating hrpartner table<br>";
                        }
                        else if(!$update_Admin_Result){
                            echo "Error updating administrator table<br>";
                        }
                        else{
                            echo "Error admin not found in users table<br>";
                        }
                    }
                    else if($penaltyRow=$penaltyResult->fetch_assoc()){
                        if($penaltyRow['penalties']>=3){
                            //fire the admin by deleting their account
                            $deletesql = "DELETE FROM administrator WHERE id='" . $_POST['admin'] . "'";
                            $deleteResult = $con->query($deletesql);
                            if(!$deleteResult){
                                echo "Error deleting from admin table<br>";
                            }
                            else{
                                $deleteUsersql = "DELETE FROM users WHERE id='" . $_POST['admin'] . "'";
                                $deleteUserResult = $con->query($deleteUsersql);
                                if(!$deleteUserResult){
                                    echo "Error deleting from users table<br>";
                                }
                                else{
                                    echo "<script>window.location.href='Home.php'</script>";
                                }
                            }
                        }
                    }
                    else{
                        echo "<script>window.location.href='Home.php'</script>";
                    }
                }
            }
            else{
                echo "Error: your account does not have this privilege<br>";
            }
        }
        else{
            echo "Error: please log into your account<br>";
        }
        ?>
    </body>
</html>
