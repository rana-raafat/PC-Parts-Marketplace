<html>
    <head>
        <title>Auditor comments</title>
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
               
                $conn = new mysqli("localhost","root","", "project");
                if(!$conn)
                {
                    echo "couldn't connect to the DataBase<br>";
                    die();
                }
    
    
                $fetch_customerName_sql="SELECT username FROM users WHERE id='" .$_SESSION['id'] . "'";
                $result3 = mysqli_query($conn,$fetch_customerName_sql);
                try{
                    dbException($result3);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($conn));
                    die();
                }
   
               // just to display the name of the customer and display it at the top
                if($fetch_auditorName = $result3->fetch_assoc()){
                    echo "<div class='container'><div class='card '><div class='large-card-container'><table class='custom-table'>";
                    echo "<h3> All Comments </h3>";
                }
   
   
                $fetch_messages_sql="SELECT * FROM auditorcomment,message WHERE auditorcomment.messageID=message.messageID";
                $result = mysqli_query($conn,$fetch_messages_sql);
                try{
                    dbException($result);
                }
                catch(Exception $e){
                    printf("Database Error: %s\n", mysqli_error($conn));
                    die();
                }
                
                echo "<tr><th>Sender</th> <th>Receiver</th> <th>Message</th> <th></th> <th>Auditor</th> <th>Auditor Comment</th> </tr>";
                while($row = $result->fetch_assoc())
                {                   
                    echo "<tr>";

                        //------------------------------------------------------------------------------------------------//
                        $fetch_sender_sql="SELECT imagePath,username FROM users WHERE id='" . $row['senderID'] . "'";
                        $result3 = mysqli_query($conn,$fetch_sender_sql);
                        try{
                            dbException($result3);
                        }
                        catch(Exception $e){
                            printf("Database Error: %s\n", mysqli_error($conn));
                            die();
                        }
                        
                        while($fetch_sender = $result3->fetch_assoc())
                        {
                            echo "<td>";
                            
                            echo "<img src=". $fetch_sender['imagePath']. " class='user-pic-icon'><img>";
                            echo  $fetch_sender['username'];

                            echo "</td>";
                        }
                        //------------------------------------------------------------------------------------------------//

                        $fetch_recepient_sql="SELECT imagePath,username,userType FROM users WHERE id='" . $row['recepientID'] . "'";
                        $result3 = mysqli_query($conn,$fetch_recepient_sql);
                        try{
                            dbException($result3);
                        }
                        catch(Exception $e){
                            printf("Database Error: %s\n", mysqli_error($conn));
                            die();
                        }
                        
                        while($fetch_recepient = $result3->fetch_assoc())
                        {
                            
                            echo "<td>";
                            
                            echo "<img src=". $fetch_recepient['imagePath']. " class='user-pic-icon'><img>";
                            echo  $fetch_recepient['username'];

                            echo "</td>";                        
                        }

                        //------------------------------------------------------------------------------------------------//

                        echo "<td><i class='fa fa-quote-left'></i>   ".$row['messageText']."   <i class='fa fa-quote-right'></i></td>";

                        //------------------------------------------------------------------------------------------------//
                       
                        echo "<td> </td>";
                       
                        //------------------------------------------------------------------------------------------------//

                        $fetch_auditor_sql="SELECT imagePath,username FROM users WHERE id='" . $row['auditorID'] . "'";
                        $result3 = mysqli_query($conn,$fetch_auditor_sql);
                        try{
                            dbException($result3);
                        }
                        catch(Exception $e){
                            printf("Database Error: %s\n", mysqli_error($conn));
                            die();
                        }
                        
                        while($fetch_auditor = $result3->fetch_assoc())
                        {
                            echo "<td>";
                            
                            echo "<img src=". $fetch_auditor['imagePath']. " class='user-pic-icon'><img>";
                            echo  $fetch_auditor['username'];

                            echo "</td>";                             
                        }

                        //------------------------------------------------------------------------------------------------//

                        echo "<td><i class='fa fa-quote-left'></i>   ".$row['commentText']."   <i class='fa fa-quote-right'></i></td>";

                    echo "</tr>";
                    
                }
                echo "</table></div></div>";
                $conn->close();
            }
        ?>
    </body>
</html>