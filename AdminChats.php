<?php

session_start();
include "Menu.php";
if($_SESSION['userType']=='auditor')
{
    
    $conn_to_get_admins = new mysqli("localhost","root","", "project");
    if(!$conn_to_get_admins){
        echo "couldn't connect to the DataBase<br>";
        die();
    }
    
    //SELECT username FROM users JOIN message ON (SenderID=users.id OR recepientID=users.id) WHERE userType="administrator"
    $auditor_sql=" SELECT * FROM message JOIN users ON (SenderID=users.id OR recepientID=users.id) WHERE userType='administrator' ";
    $auditor_result = mysqli_query($conn_to_get_admins,$auditor_sql);
    if(!$auditor_result){
        echo "COULDN'T SEARCH FOR THE NAMES OF ADMINISTRATORS FROM THE DB<br>";
        die();
    }

    $unique_admin_images=array();
    $unique_admin_names=array();
    $unique_admin_IDS=array();
    $unique_admin_usertype=array();
    while($admin_row = $auditor_result->fetch_assoc()){
        //echo $admin_row['senderID']."<br>";
                
                $repeated_IDS=false;

                for($i=0;$i<sizeof($unique_admin_names);$i++)
                {
                    if($unique_admin_IDS[$i]==$admin_row['id'])
                    {
                        $repeated_IDS=true;
                        break;
                    }
                }

                if($repeated_IDS==false)
                {
                    $unique_admin_images[]=$admin_row['imagePath'];
                    $unique_admin_names[]=$admin_row['username'];
                    $unique_admin_IDS[]=$admin_row['id']; 
                    $unique_admin_usertype[]=$admin_row['userType'];
                   
                }
                
    }
                for($i=0;$i<sizeof($unique_admin_IDS);$i++)
                {
                    echo $unique_admin_images[$i]." ";
                    echo $unique_admin_names[$i]." ";
                    echo $unique_admin_IDS[$i]." ";
                    echo $unique_admin_usertype[$i]." ";
                    
?>
                <form method="Post" action="AdminChats.php">
                    
               <!-- <a href=MakeCommentsOnChats.php?id=<?php //echo $unique_admin_IDS[$i] ?>> YOU WANNA SEE MY CHATS MF? </a> -->
               <?php
                 echo"<input type=hidden name=uAdminId value=".$unique_admin_IDS[$i].">";       
               ?>
                
                    <input type="submit" name="submitted">
                </form>
                <br>
  <?php                     
                }
            }

            if( isset($_POST['submitted']) ){
                
            $conn = new mysqli("localhost","root","", "project");
            if(!$conn){
                echo "couldn't connect to the DataBase<br>";
                 die();
            }
        
            echo "<table border='1'>
                <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Chats</th>
                <th>userType</th>
                <th>ImagePath</th>
                
                </tr>";
                $sql="SELECT * FROM message WHERE (senderID='".$_POST['uAdminId']."') OR ( recepientID='".$_POST['uAdminId']."')";
                //$sql2="SELECT username, id FROM users WHERE username !='" . $_POST['username'] . "'";
                $result = mysqli_query($conn,$sql);
                if(!$result){
                    echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                    die();
                }
                echo "<tr>";

                $unique_customer_name_arr=array(); 
                $unique_customer_id_arr=array();
                $unique_customer_usertype_arr=array();
                $unique_customer_image_arr=array();
    
                while($row = $result->fetch_assoc())
        {
                    if ($row['senderID']==$_POST['uAdminId'])
                    {
    
                        $unique_reciever_id="SELECT * FROM users WHERE id='" . $row['recepientID'] . "'";
                        $fetch_unique_recieve_id = mysqli_query($conn,$unique_reciever_id);
                        if(!$fetch_unique_recieve_id)
                        {
                            echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                            die();
                        }
                    
                        while($row2 = $fetch_unique_recieve_id->fetch_assoc())
                        {
                            $flag=false;
                            for($i=0;$i<sizeof($unique_customer_id_arr);$i++)
                            {
                                if($unique_customer_id_arr[$i]==$row2['id'])
                                {
                                    $flag=true;
                                    break;
                                }
                            }
    
                                if($flag==false)
                                {
                                    $unique_customer_name_arr[]=$row2['username'];
                                    $unique_customer_id_arr[]=$row2['id'];
                                    $unique_customer_usertype_arr[]=$row2['userType'];
                                    $unique_customer_image_arr[]=$row2['imagePath'];
                                }
                        }             
    
                    }
                    else if($row['recepientID']==$_POST['uAdminId'])
                    {
                        $unique_sender_id="SELECT * FROM users WHERE id='" . $row['senderID'] . "'";
                        $row_unique_sender_id = mysqli_query($conn,$unique_sender_id);
                        if(!$row_unique_sender_id){
                            echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                            die();
                        }
    
                            while($row3 = $row_unique_sender_id->fetch_assoc())
                            {   
                                $flag=false;
    
                                for($i=0;$i<sizeof($unique_customer_id_arr);$i++)
                                {
                                    if($unique_customer_id_arr[$i]==$row3['id'])
                                    {
                                        $flag=true;
                                        break;
                                    }
                                }
    
                                    if($flag==false)
                                    {
                                        $unique_customer_name_arr[]=$row3['username'];
                                        $unique_customer_id_arr[]=$row3['id'];
                                        $unique_customer_usertype_arr[]=$row3['userType'];
                                        $unique_customer_image_arr[]=$row3['imagePath'];
                                    } 
    
                            }  
                        }
                
        }     
    // mohamed mohamed mohamed hady farah hady
            for ($i=0;$i<sizeof($unique_customer_name_arr);$i++)
            {
                       
    ?>
    <tr>
        <td><?php echo $unique_customer_id_arr[$i]; ?></td>
        <td><?php echo $unique_customer_name_arr[$i]; ?></td>
        <!--<td><a href=Chat.php?id=<?php //echo $unique_customer_id_arr[$i]; ?> >Message</a></td>-->
        
        <form method="Post" action="MakeCommentsOnChats.php">
                    
                    <!-- <a href=MakeCommentsOnChats.php?id=<?php //echo $unique_admin_IDS[$i] ?>> YOU WANNA SEE MY CHATS MF? </a> -->
                    <?php
                    if( isset($_POST['submitted']) ){
                      echo"<input type=hidden name=uCustomerId value=".$unique_customer_id_arr[$i].">";
                      echo"<input type=hidden name=uAdminId2 value=".$_POST['uAdminId'].">";
                    }      
                    ?>
                     
                        <td> <input type="submit" name="uCustomerId_uAdminIdSubmitted"> </td>
        </form>

        <td><?php echo $unique_customer_usertype_arr[$i]; ?></td>
        <td><?php echo $unique_customer_image_arr[$i]; ?></td>
    
    </tr> 
    
    <?php
    
        }
        echo"</table>";

        
   
        $conn->close(); 
}
    ?>          
    
            


