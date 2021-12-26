<html>

<?php

 session_start();
        include "Menu.php";
        
        $conn = new mysqli("localhost","root","", "project");
        if(!$conn){
            echo "couldn't connect to the DataBase<br>";
             die();
        }

        echo "<table border='1'>
            <tr>

            <th>Name</th>

            <th>Chats</th>
            
            </tr>";
            $sql="SELECT * FROM message WHERE (senderID='".$_SESSION['id']."') OR ( recepientID='".$_SESSION['id']."')";
            //$sql2="SELECT username, id FROM users WHERE username !='" . $_SESSION['username'] . "'";
            $result = mysqli_query($conn,$sql);
            if(!$result){
                echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                die();
            }
            echo "<tr>";

            while($row = $result->fetch_assoc()){
                if ($row['senderID']==$_SESSION['id']){

                    $sql2="SELECT * FROM users WHERE id='" . $row['recepientID'] . "'";
                    $result2 = mysqli_query($conn,$sql2);
                    if(!$result2){
                        echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                        die();
                    }
                
                    if($row2 = $result2->fetch_assoc()){
                        //echo "<td>" . $row2['username'] . "</td>";
?>             
    <tr>
        <td><?php echo$row2['username'];  ?></td>
        <td> <a href=Messages.php?id=<?php echo $row2['id']; ?> >Message</a></td>
    </tr>

<?php 
            }
        }
        else if($row['recepientID']==$_SESSION['id'])
        {
            $sql3="SELECT * FROM users WHERE id='" . $row['senderID'] . "'";
            $result3 = mysqli_query($conn,$sql3);
            if(!$result3){
                echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                die();
            }
            $username_arr=array(); 
            $id_arr=array();

            while($row3 = $result3->fetch_assoc()){ 
                $flag=false;
                // mohamed
                for($i=0;$i<sizeof($username_arr);$i++){
                    if($username_arr[$i]==$row3['username'])
                    {
                        $flag=true;
                        break;
                    }
                    else
                    {
                        
                    }
                   // $id_arr[]= $row3['id'];
                }

                $username_arr[$i]=$row3['username'];
                  
                

            } 
        }
            
    }     
// mohamed mohamed mohamed hady farah 
        for ($i=0;$i<sizeof($username_arr);$i++)
        {
            for ($j=0;$j<sizeof($username_arr);$j++)
            {
                if($i==$j)
                {
                    continue;// skipjutsu
                }
                else
                {
                   
?>
<tr>

    <td><?php echo $username_arr[$i]; ?></td>
    <td><a href=Messages.php?id=<?php echo $id_arr[$i]; ?> >Message</a></td>

</tr> 

<?php
                }
        }
    }

    echo"</table>";
    $conn->close(); 
?>          





       

</html>