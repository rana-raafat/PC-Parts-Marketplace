<html>
    <head>
        <title> Investigation Request </title>
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

        $con = new mysqli("localhost","root","", "project");
        if(!$con)
        {
            echo "couldn't connect to the DataBase<br>";
            die();
        }
        if(isset($_GET['id']))
        $HRid=$_GET['id'];
        
     
        $sql2="SELECT username FROM `users` WHERE userType='administrator'";
        $result2 = mysqli_query($con,$sql2);
        try{
            dbException($result2);
        }
        catch(Exception $e){
            printf("Database Error: %s\n", mysqli_error($con));
            die();
        }
        if ($result2->num_rows == 0) {
            echo "There are no Administrators at the moment<br>";
        }
        else{
            $hrsql="SELECT username FROM `users` WHERE id='$HRid'";
            $hrresult = mysqli_query($con,$hrsql);
            try{
                dbException($hrresult);
            }
            catch(Exception $e){
                printf("Database Error: %s\n", mysqli_error($con));
                die();
            }
            if($hrresult->num_rows == 0){
                echo "Error hr not found<br>";
            }
            $hrname=$hrresult->fetch_assoc();
            echo "<div class='container'>";
            echo "<div class='card'>";
            echo "<div class='medium-card-container'>";
            echo "<h4>HRPartner Name </h4>";
            echo"<p class='review'>". $hrname['username'] ."</p>";
            echo "<br><br>";
            echo"<form method='post'>"; 
            echo "<h4>Select admin: </h4><Select name='admins'";
            echo "<option value='' selected>Choose Admin</option>";
            while($row = $result2->fetch_assoc()){
                echo "<option value='". $row['username'] ."'>". $row['username'] ."</option>";
            }
            echo "</Select>";
            echo "<br><br>";
            echo "<h4>Write your problem:</h4>";
            
            echo "<textarea name='textarea'></textarea>";
            echo "<br><br>";
            echo "<input type='Submit' name='submit'>";
            echo"<br>";
            echo"</form>"; 
            if(isset($_POST["submit"])){
                $reason=$_POST["textarea"];
                $admin=$_POST["admins"];
                $sql="SELECT id FROM `users` WHERE username='$admin'";
                $result=mysqli_query($con,$sql);
                try{
                    dbException($result);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($con));
                    die();
                }
                $row2=$result->fetch_assoc();
              
                $insert="INSERT INTO investigationrequest( auditorID, hrID, adminID, reason) VALUES  ('".$_SESSION['id']."','$HRid','" . $row2['id'] . "','" . $reason . "')";
                $result3=mysqli_query($con,$insert);
                try{
                    dbException($result3);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($con));
                    die();
                }
                
                $investigationsql = "SELECT * FROM investigationrequest ORDER BY id DESC LIMIT 1";
                $invResult = $con->query($investigationsql);
                try{
                    dbException($invResult);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($con));
                    die();
                }
                if($invResult->num_rows == 0){
                    echo "Error request not found<br>";
                }
                else if($invRow = $invResult->fetch_assoc()){
                    $invesigationLink = 'Investigation requested <a href="ViewInvestigationRequest.php?id=' . $invRow['id'] . '"">click here </a> to view';
                   
                    $invMessage="INSERT INTO message(senderID,recepientID,auditorFlag,messageText,readStatus) VALUES('". $invRow['auditorID'] ."','". $invRow['hrID'] ."','0','". $invesigationLink ."','0') " ;
                    $messageResult = mysqli_query($con,$invMessage);
                    try{
                        dbException($messageResult);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($con));
                        die();
                    }
                    
                    $updatehr="UPDATE hrpartner SET investigationsMade=investigationsMade+1";
                    $updateResult = mysqli_query($con,$updatehr);
                    if(!$updateResult){
                        echo "couldn't insert survey into the DataBase<br>";
                        printf("Error: %s\n", mysqli_error($con));
                        die();
                    }
                    else{
                        $con->close();
                        echo "<script>window.location.href='chat.php?id=".$_GET['id']."'</script>";
                    }
                    
                    
                }
            }
            
            echo "</div>";
            echo "</div>";
            echo "</div>";
            
        }
    
        ?>
    </body>
</html>
