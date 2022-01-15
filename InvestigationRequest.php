<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Investigation Request </title>
    </head>
    <body>
        <?php
        session_start();
        include "Menu.php";

        
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
        if ($result2->num_rows == 0) {
            echo "There are no Administrators at the moment<br>";
        }
        else{
            $hrsql="SELECT username FROM `users` WHERE id='$HRid'";
            $hrresult = mysqli_query($con,$hrsql);
            if($hrresult->num_rows == 0){
                echo "Error hr not found<br>";
            }
            $hrname=$hrresult->fetch_assoc();
            echo "<div class='container'>";
            echo "<div class='card justify-content-center'>";
            echo "<div class='investigationRequest'>";
            echo "<h4>HRPartner Name </h4>";
            echo"<p class='review'>". $hrname['username'] ."</p>";
            echo "<br><br>";
            echo"<form method='post'>"; 
            echo "<h4>Select admin: </h4><Select name='admins'style='color:black;>";
            echo "<option value='' selected>Choose Admin</option>";
            while($row = $result2->fetch_assoc()){
                echo "<option value='". $row['username'] ."'>". $row['username'] ."</option>";
            }
            echo "</Select>";
            echo "<br><br>";
            echo "<h4>Write your problem:</h4>";
            
            echo "<textarea name='textarea''style='color:black; rows='5' cols='30'></textarea>";
            echo "<br><br>";
            echo "<input type='Submit' name='submit'>";
            echo"<br>";
            echo"</form>"; 
            if(isset($_POST["submit"])){
                $reason=$_POST["textarea"];
                $admin=$_POST["admins"];
                $sql="SELECT id FROM `users` WHERE username='$admin'";
                $result=mysqli_query($con,$sql);
                $row2=$result->fetch_assoc();
                //echo"$row2[id]";
                $insert="INSERT INTO investigationrequest( auditorID, hrID, adminID, reason) VALUES  ('".$_SESSION['id']."','$HRid','" . $row2['id'] . "','" . $reason . "')";
                $result3=mysqli_query($con,$insert);
                if (!$result3) {
                    printf("Error: %s\n", mysqli_error($con));
                    exit();
                }  
                $investigationsql = "SELECT * FROM investigationrequest ORDER BY id DESC LIMIT 1";
                $invResult = $con->query($investigationsql);
                if($invResult->num_rows == 0){
                    echo "Error request not found<br>";
                }
                else if($invRow = $invResult->fetch_assoc()){
                    $invesigationLink = 'Investigation requested <a href="ViewInvestigationRequest.php?id=' . $invRow['id'] . '"">click here </a> to view';
                    //don't sanatize this cause it needs to stay as a link obviously
                    $invMessage="INSERT INTO message(senderID,recepientID,auditorFlag,messageText,readStatus) VALUES('". $invRow['auditorID'] ."','". $invRow['hrID'] ."','0','". $invesigationLink ."','0') " ;
                    $messageResult = mysqli_query($con,$invMessage);
                    if(!$messageResult){
                        echo "couldn't insert survey into the DataBase<br>";
                        printf("Error: %s\n", mysqli_error($con));
                        die();
                    }
                    $con->close();
                    echo "<script>window.location.href='chat.php?id=".$_GET['id']."'</script>";
                    
                }
            }
            
            echo "</div>";
            echo "</div>";
            echo "</div>";
            
        }
    
        ?>
    </body>
</html>
