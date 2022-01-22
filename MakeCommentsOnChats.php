<html>
  <head>
        <title>Chats</title>
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

        if($_SESSION['userType']=='auditor')
        {
?>

    <div class='container'>
        <div class='card'>
            <div class='large-card-container'>
              <div class='chat-history'>
                <ul>
                    <?php
            if( ( isset($_POST['send']) ) || ( isset( $_POST['uCustomerId_uAdminIdSubmitted'] ) )  )
            {

                $uCustomerId=$_POST['uCustomerId'];
                $uAdminId2=$_POST['uAdminId2'];
                
             
            
                $conn = new mysqli("localhost","root","", "project");
                if(!$conn)
                {
                    echo "couldn't connect to the DataBase<br>";
                    die();
                }


                $fetch_customerName_sql="SELECT username FROM users WHERE id='" . $uCustomerId . "'";
                $result3 = mysqli_query($conn,$fetch_customerName_sql);
                try{
                    dbException($result3);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($conn));
                    die();
                }

                // just to display the name of the customer and display it at the top
                if($fetch_customerName = $result3->fetch_assoc()){
                    //echo "<h1>".$fetch_customerName['username']."</h1>";
                }

                $fetch_messages_sql="SELECT * FROM message WHERE (senderID='".$uAdminId2."'AND recepientID='".$uCustomerId."') OR (senderID='".$uCustomerId."'AND recepientID='".$uAdminId2."') ORDER BY messageID ASC";
                $result = mysqli_query($conn,$fetch_messages_sql);
                try{
                    dbException($result);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($conn));
                    die();
                }

                while($row = $result->fetch_assoc())
                {   
                    $fetch_adminName_sql="SELECT id,username,imagePath,userType FROM users WHERE id='" . $row['senderID'] . "'";
                    $result3 = mysqli_query($conn,$fetch_adminName_sql);
                    if(!$result3)
                    {
                        echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                        die();
                    }
                    
                    while($fetch_customer = $result3->fetch_assoc())
                    {

                    echo "<li>";

                    if($fetch_customer['id']==$uAdminId2){
                    echo "<div class='text-left'>";
                    echo "<div class='message-data'>";
                    echo "[".$row['messageID']."] ";
                    echo "<br><br>";
                    echo "<img src=".$fetch_customer['imagePath']."></img>  ";
                    echo $fetch_customer['username'];
                    echo "</div>";
                    echo "<div class='message my-message'>";
                    echo $row['messageText'];
                    echo "</div>";
                    echo "</div>";
                    }
                    else{
                    echo "<div class='text-right'>";
                    echo "<div class='message-data'>";
                    echo "[".$row['messageID']."] ";
                    echo "<br><br>";
                    echo $fetch_customer['username'];
                    echo "<img src=".$fetch_customer['imagePath']."></img>  ";
                    echo "</div>";
                    echo "<div class='message other-message'>";
                    echo $row['messageText'];
                    echo "</div>";
                    echo "</div>";
                    }

                    echo "</li>";
                    }
                }
                
            echo "</ul>";
            echo "</div>";
            }

            else
            {
                echo "check again";
            }
                if(isset($_POST['send'])) {

                    $text= $_POST['txt'];
                    $text=filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                    $sql2="INSERT INTO auditorcomment(auditorID,messageID,commentText,readStatus) VALUES('". $_SESSION['id'] ."','". $_POST['num'] ."','". $text ."','1') " ;
                    $result2 = mysqli_query($conn,$sql2);
                    if(!$result2){
                        echo "couldn't insert into the DataBase<br>";
                        die();
                    }
                    else{
                        $updatesql="UPDATE message SET auditorFlag='1' WHERE messageID='". $_POST['num'] ."'";
                        $updateResult = mysqli_query($conn,$updatesql);
                        if(!$updateResult){
                            echo "couldn't update message table<br>";
                            die();
                        }
                    }
                    $conn->close();
                    
                }

                if(isset($_POST['exit']))
                {
                    echo "<script>window.location.href='AdminChats.php'</script>";
                }
    }
            ?>
            <hr>

            <form action="" method="post">
            
            Enter the message [number] you want to make your comment on: 
            <br>
            <?php
            $messages_count_sql="SELECT COUNT(messageID) as messages_count FROM message";
            $messages_count_result = mysqli_query($conn,$messages_count_sql);
            if(!$messages_count_result){
                echo "couldn't select from DataBase<br>";
            }
            $messages_count = $messages_count_result->fetch_assoc();
            ?>
            <input type="number" name="num" value=1 min=1 max=<?php echo $messages_count['messages_count'];?>>
            <br><br>

            Enter your comment:
            <br>
            <textarea name="txt"></textarea>
            <br><br>

            <input type=hidden name=uCustomerId value="<?php echo $uCustomerId; ?>" >
            <input type=hidden name=uAdminId2 value="<?php echo $uAdminId2; ?>" >

            <input type="submit" name="send" value="send"/>
            <input type="submit" name="exit" value="exit"/>
            </form>
</div>
</div>
</div>
    </body>
</html>