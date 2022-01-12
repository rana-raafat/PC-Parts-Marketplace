<?php

session_start();
include "Menu.php";
if($_SESSION['userType']=='auditor')
{
    
    $conn = new mysqli("localhost","root","", "project");
    if(!$conn){
        echo "couldn't connect to the DataBase<br>";
        die();
    }
    
    //SELECT username FROM users JOIN message ON (SenderID=users.id OR recepientID=users.id) WHERE userType="administrator"
    $auditor_sql=" SELECT * FROM message JOIN users ON (SenderID=users.id OR recepientID=users.id) WHERE userType='administrator' ";
    $auditor_result = mysqli_query($conn,$auditor_sql);
    if(!$auditor_result){
        echo "COULDN'T SEARCH FOR THE NAMES OF ADMINISTRATORS FROM THE DB<br>";
        die();
    }
    
    $unique_admin_names=array();
    $unique_admin_IDS=array();
    while($admin_row = $auditor_result->fetch_assoc()){
        //echo $admin_row['senderID']."<br>";
                
                $repeated_names_OR_IDS=false;

                for($i=0;$i<sizeof($unique_admin_names);$i++)
                {
                    if($unique_admin_names[$i]==$admin_row['username'])
                    {
                        $repeated_names_OR_IDS=true;
                        break;
                    }
                }

                if($repeated_names_OR_IDS==false)
                {
                    $unique_admin_names[]=$admin_row['username'];
                    $unique_admin_IDS[]=$admin_row['id'];
                }
                
    }
                for($i=0;$i<sizeof($unique_admin_names);$i++)
                {
                    echo $unique_admin_names[$i]." ";
                    echo $unique_admin_IDS[$i]." ";
                    
?>
                <a href=AuditorComments.php?id=<?php echo $unique_admin_IDS[$i] ?>> YOU WANNA SEE MY CHATS MF? </a>
                <br>
<?php                            
                }
    if(!empty($_GET['id'])){

    $sql="SELECT * FROM message JOIN users ON SenderID=users.id WHERE ( (senderID='".$_GET['id']."') OR ( recepientID='".$_GET['id']."') )";
    $result = mysqli_query($conn,$sql);
    if(!$result){
    echo "COULDN'T SEARCH FOR THE NAMES OF THE PEOPLE YOU CHATED WITH FROM THE DB<br>";
    die();
    }
    
    $id_arr =array();
    while($row =$result->fetch_assoc())
    {

        if($row['id'] != $_GET['id'])
        {
            //echo"hello";
            
            $repeated=false;
            for($i=0;$i<sizeof($id_arr);$i++)
            {
                if($id_arr[$i]==$row['id'])
                {
                    $repeated=true;
                    break;
                }
                if($repeated==false){
                    $id_arr[]=$row['id'];
                    ?>
                    <!-- HERE IS HOW TO DISPLAY THE ID OF THE PERSON YOU CLICK ON  -->
                    <h1>hello Rana </h1>
                    <a href="AuditorComments.php?id_test=<?php echo $row['id']?>">
                        <ul class="list-unstyled chat-list">
                            <li class="clearfix">
                                <img src="<?php echo $row['imagePath'];?>" alt="profile picture" width='50' height='50' class="img-circle">
                                <div class="about">
                                    <div class="name"> <?php echo $row['username'];?> </div>
                                    <div class="job"><i class="fa fa-user"></i> <?php echo $row['userType']; ?> </div>                                            
                                </div>
                            </li>
                        </ul>
                    </a>

                    <?php
                }

            }

        }

    else
    {
        //echo"hello";

    $plist_exc_sql = "SELECT * FROM  message, users WHERE messageID=".$row['messageID']." AND users.id=".$row['recepientID'];

    $plist_exc_result = mysqli_query($conn,$plist_exc_sql);
    if(!$plist_exc_result){
        echo "COULDN'T SEARCH from the second func";
        die();
    }


        if($plist_exc_row = $plist_exc_result->fetch_assoc()){           
            $repeated=false;
            for($i=0;$i<sizeof($id_arr);$i++){
                if($id_arr[$i]==$plist_exc_row['id']){
                    $repeated=true;
                    break;
                }
            }

            if($repeated==false){
                $id_arr[]=$plist_exc_row['id'];
                ?>
                <a href="AuditorComments.php?id_test=<?php echo $plist_exc_row['id']?>">
                
                    <ul class="list-unstyled chat-list">
                        <li class="clearfix">
                            <img src="<?php echo $plist_exc_row['imagePath'];?>" alt="profile picture" width='50' height='50' class="img-circle">
                            <div class="about">
                                <div class="name"> <?php echo $plist_exc_row['username'];?> </div>
                                <div class="job"><i class="fa fa-user"></i> <?php echo $plist_exc_row['userType']; ?> </div>                                            
                            </div>
                        </li>
                    </ul>
                </a>


            <?php

        }

    }
    }

    }        
}
}

else{
    echo"you are NOT THE FATHER";
}

?>