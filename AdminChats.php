<html>
    <head>
        <title>Admin chats</title>
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
            
            $conn_to_get_admins = new mysqli("localhost","root","", "project");
            if(!$conn_to_get_admins){
                echo "couldn't connect to the DataBase<br>";
                die();
            }
            
            $auditor_sql=" SELECT * FROM message JOIN users ON (SenderID=users.id OR recepientID=users.id) WHERE userType='administrator' ";
            $auditor_result = mysqli_query($conn_to_get_admins,$auditor_sql);
            try{
                dbException($auditor_result);
            }
            catch(Exception $e){
                printf("Database Error: %s\n", mysqli_error($conn_to_get_admins));
                die();
            }
            if(!$auditor_result){
                echo "COULDN'T SEARCH FOR THE NAMES OF ADMINISTRATORS FROM THE DB<br>";
                die();
            }

            $unique_admin_images=array();
            $unique_admin_names=array();
            $unique_admin_IDS=array();
            $unique_admin_usertype=array();
            while($admin_row = $auditor_result->fetch_assoc()){
                
                        
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
            ?>
            <div class='container'>
                <div class='card'>
                    <div class='medium-card-container'>

                            <h3 class='text-center'>Administrators Chat History</h3>

                            <table class='table text-center'>
                                <?php
                                for($i=0;$i<sizeof($unique_admin_IDS);$i++)
                                {    
                                    echo "<tr>";

                                        echo "<td>";
                                            echo "<img src='". $unique_admin_images[$i]."'  class='user-pic-icon'><img>";
                                            echo $unique_admin_names[$i];
                                        echo "</td>";
                                        
                                        ?>
                                        
                                        <td>
                                            <form method="Post" action="AdminChats.php#2">
                                                <?php
                                                echo"<input type=hidden name=uAdminId value=".$unique_admin_IDS[$i].">"; 
                                                echo"<input type=hidden name=uAdminName value=".$unique_admin_names[$i].">";       
                                                ?>
                                            
                                                <button type="submit" name="submitted"> Chat History <i class='fa fa-commenting'></i></button>
                                            </form> <br>
                                        </td>

                                        <?php  

                                    echo "</tr>";
                    
                                }

                                ?>

                            </table>
                        </div>
                    </div>
                </div>
            <?php     
        }

        if( isset($_POST['submitted']) ){
            
            $conn = new mysqli("localhost","root","", "project");
            if(!$conn){
                echo "couldn't connect to the DataBase<br>";
                die();
            }

            $sql="SELECT * FROM message WHERE (senderID='".$_POST['uAdminId']."') OR ( recepientID='".$_POST['uAdminId']."')";

            $result = mysqli_query($conn,$sql);
            try{
                dbException($result);
            }
            catch(Exception $e){
                printf("Database Error: %s\n", mysqli_error($conn));
                die();
            }

            $unique_customer_name_arr=array(); 
            $unique_customer_id_arr=array();
            $unique_customer_usertype_arr=array();
            $unique_customer_image_arr=array();

            while($row = $result->fetch_assoc()){
                if ($row['senderID']==$_POST['uAdminId']){
                    $unique_reciever_id="SELECT * FROM users WHERE id='" . $row['recepientID'] . "'";
                    $fetch_unique_recieve_id = mysqli_query($conn,$unique_reciever_id);
                    try{
                        dbException($fetch_unique_recieve_id);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($conn));
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
                    try{
                        dbException($row_unique_sender_id);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($conn));
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
            ?>
            <div class='container'>
                <div class='card' id='2'>
                        <div class='medium-card-container'>

                            <h3 class='text-center'>Users <?php echo $_POST['uAdminName']; ?> Chatted With</h3>
                                
                            <table class='table text-center'>

                                <?php

                                for ($i=0;$i<sizeof($unique_customer_name_arr);$i++)
                                {          
                                    echo"    <tr>";

                                        echo "<td><img src='". $unique_customer_image_arr[$i]."'  class='user-pic-icon'><img>" .  $unique_customer_name_arr[$i]."</td>";
                                        echo "<td><i class='fa fa-user'></i>  ". $unique_customer_usertype_arr[$i]." </td>";
                                        
                                        ?>
                                        
                                        <td>
                                            
                                            <form method="Post" action="MakeCommentsOnChats.php">
                                        
                                                <?php
                                                if( isset($_POST['submitted']) ){
                                                echo"<input type=hidden name=uCustomerId value=".$unique_customer_id_arr[$i].">";
                                                echo"<input type=hidden name=uAdminId2 value=".$_POST['uAdminId'].">";
                                                }      
                                                ?>
                                                <button type="submit" name="uCustomerId_uAdminIdSubmitted">View Chat   <i class='fa fa-commenting'></i></button>

                                            </form>

                                        </td> 

                                    </tr> 
                                    
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            <?php
            $conn->close(); 
        }
        ?>          
    </body>
</html>
            


