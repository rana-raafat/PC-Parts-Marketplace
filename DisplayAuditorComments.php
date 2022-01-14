<html>

<?php 
           session_start();
           include "Menu.php";
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
               if(!$result3){
                   echo "COULDN'T SEARCH FOR THE auditor's NAME FROM THE DB<br>";
                   die();
               }
   
               // just to display the name of the customer and display it at the top
               if($fetch_auditorName = $result3->fetch_assoc()){
                   echo "<h1>".$fetch_auditorName['username']."</h1>";
               }
   
   
               $fetch_messages_sql="SELECT * FROM auditorcomment";
               $result = mysqli_query($conn,$fetch_messages_sql);
               if(!$result)
               {
                   echo "couldn't read the messages from the DataBase<br>";
                   die();
               }
   
               while($row = $result->fetch_assoc())
               {   
                   $fetch_adminName_sql="SELECT username FROM users WHERE id='" . $row['auditorID'] . "'";
                   $result3 = mysqli_query($conn,$fetch_adminName_sql);
                   if(!$result3)
                   {
                       echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                       die();
                   }
                   
                   while($fetch_auditorName = $result3->fetch_assoc())
                   {
                       echo "Message ID:".$row['messageID'].":      ";
                       echo "Auditor Name:      ".$fetch_auditorName['username'];
                       echo"    :   ";
                       echo $row['commentText'];
                       echo"<br>";
                   }
               
               }
               $conn->close();
            }
?>

</html>