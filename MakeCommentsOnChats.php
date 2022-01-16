<html>
  <head>
        <title>Chats</title>
    </head>

    <body>
    <?php
        session_start();
        include "Menu.php";
        if($_SESSION['userType']=='auditor')
        {
            if( ( isset($_POST['send']) ) || ( isset( $_POST['uCustomerId_uAdminIdSubmitted'] ) )  )
            {

                $uCustomerId=$_POST['uCustomerId'];
                $uAdminId2=$_POST['uAdminId2'];
                
                echo "<h1>".$uCustomerId."</h1>";
                echo  "<h1>".$uAdminId2."</h1>";

            }

            else
            {
                echo "<h1>check again</h1>";
            } 
            
            $conn = new mysqli("localhost","root","", "project");
            if(!$conn)
            {
                echo "couldn't connect to the DataBase<br>";
                die();
            }


            $fetch_customerName_sql="SELECT username FROM users WHERE id='" . $uCustomerId . "'";
            $result3 = mysqli_query($conn,$fetch_customerName_sql);
            if(!$result3){
                echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                die();
            }

            // just to display the name of the customer and display it at the top
            if($fetch_customerName = $result3->fetch_assoc()){
                echo "<h1>".$fetch_customerName['username']."</h1>";
            }


            $fetch_messages_sql="SELECT * FROM message WHERE (senderID='".$uAdminId2."'AND recepientID='".$uCustomerId."') OR (senderID='".$uCustomerId."'AND recepientID='".$uAdminId2."')";
            $result = mysqli_query($conn,$fetch_messages_sql);
            if(!$result)
            {
                echo "couldn't read the messages from the DataBase<br>";
                die();
            }

            while($row = $result->fetch_assoc())
            {   
                $fetch_adminName_sql="SELECT username FROM users WHERE id='" . $row['senderID'] . "'";
                $result3 = mysqli_query($conn,$fetch_adminName_sql);
                if(!$result3)
                {
                    echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                    die();
                }
                
                while($fetch_customerName = $result3->fetch_assoc())
                {
                    echo $row['messageID'].": ";
                    echo $fetch_customerName['username'];
                    echo" : ";
                    echo $row['messageText'];
                    echo"<br>";
                }
            
            }

            if(isset($_POST['send'])) {

                $sql2="INSERT INTO auditorcomment(auditorID,messageID,commentText,readStatus) VALUES('". $_SESSION['id'] ."','". $_POST['num'] ."','". $_POST['txt'] ."','1') " ;
                $result2 = mysqli_query($conn,$sql2);
                if(!$result2){
                    echo "couldn't insert into the DataBase<br>";
                    die();
                }
                $conn->close();
                //echo "<script>window.location.href='test2.php'</script>"; 
            }

            if(isset($_POST['exit']))
            {
                header("Location:AuditorComments.php");
            }
            


        } 
            ?>

            <form action="" method="post">
            
            please enter the message no. you want to make your comment on: 
            <input type="number" name="num"><br>

            please enter your comment:
            <input type="textarea" name="txt"><br>
            <input type=hidden name=uCustomerId value="<?php echo $uCustomerId; ?>" >
            <input type=hidden name=uAdminId2 value="<?php echo $uAdminId2; ?>" >

            <input type="submit" name="send" value="send"/>
            <input type="submit" name="exit" value="exit"/>
            </form>
        
    </body>
</html>