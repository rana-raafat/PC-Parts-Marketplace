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

        if($_SESSION['userType']=='administrator')
        {
            if( isset( $_POST['uCustomerId_uCustomerIdSubmitted'] )  )
            {

                $uAdminId=$_POST['uAdminId'];
                $uCustomerId2=$_POST['uCustomerId2'];

            }

            else
            {
                echo "check again<br>";
            } 
            ?>

            <div class='container'>
                <div class='card'>
                    <div class='medium-card-container'>
                        <div class='chat-history'>
                            <ul>
                                <?php
                                $conn = new mysqli("localhost","root","", "project");
                                if(!$conn)
                                {
                                    echo "couldn't connect to the DataBase<br>";
                                    die();
                                }


                                $fetch_adminName_sql="SELECT username FROM users WHERE id='" . $uAdminId . "'";
                                $result3 = mysqli_query($conn,$fetch_adminName_sql);
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


                                $fetch_messages_sql="SELECT * FROM message WHERE (senderID='".$uCustomerId2."'AND recepientID='".$uAdminId."') OR (senderID='".$uAdminId."'AND recepientID='".$uCustomerId2."') ORDER BY messageID ASC";
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
                                    try{
                                        dbException($result3);
                                    }
                                    catch(Exception $e){
                                        printf("Database Error: %s\n", mysqli_error($conn));
                                        die();
                                    }
                                    while($fetch_customer = $result3->fetch_assoc())
                                    {
                                        
                                        echo "<li>";
                                        echo "<div class='message-data'>";


                                        if($fetch_customer['id']==$uCustomerId2){
                                        echo "  <img src=".$fetch_customer['imagePath']."></img>  ";
                                        echo $fetch_customer['username'];
                                        echo "</div>";
                                        echo "<div class='message my-message'>";
                                        echo $row['messageText'];
                                        echo "</div>";
                                        }


                                        else{
                                        echo "<div class='text-right'>";
                                        echo $fetch_customer['username'];
                                        echo "   <img src=".$fetch_customer['imagePath']."></img>  ";
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
                    echo "</div>";    
                echo "</div>";
            echo "</div>"; 
          
        }
        ?>

    </body>
</html>