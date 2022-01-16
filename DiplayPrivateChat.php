<html>
  <head>
        <title>Chats</title>
    </head>

    <body>
    <?php
        session_start();
        include "Menu.php";
        if($_SESSION['userType']=='administrator')
        {
            if( isset( $_POST['uCustomerId_uCustomerIdSubmitted'] )  )
            {

                $uAdminId=$_POST['uAdminId'];
                $uCustomerId2=$_POST['uCustomerId2'];
                
                echo "<h1>".$uAdminId."</h1>";
                echo  "<h1>".$uCustomerId2."</h1>";

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


            $fetch_adminName_sql="SELECT username FROM users WHERE id='" . $uAdminId . "'";
            $result3 = mysqli_query($conn,$fetch_adminName_sql);
            if(!$result3){
                echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                die();
            }

            // just to display the name of the customer and display it at the top
            if($fetch_customerName = $result3->fetch_assoc()){
                echo "<h1>".$fetch_customerName['username']."</h1>";
            }


            $fetch_messages_sql="SELECT * FROM message WHERE (senderID='".$uCustomerId2."'AND recepientID='".$uAdminId."') OR (senderID='".$uAdminId."'AND recepientID='".$uCustomerId2."') ORDER BY messageID ASC";
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

    }
            ?>

    </body>
</html>