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

        $conn = new mysqli("localhost","root","", "project");

        $sql="SELECT * FROM message, users WHERE ( (senderID='".$_SESSION['id']."') OR ( recepientID='".$_SESSION['id']."') ) AND SenderID=users.id";
        ?>
        <div class="container">
            <div class="card">
                <div class="chat-card">


                    <!------------------------------------------------- list ------------------------------------------------->

                    <div class="people-list-container">
                        <?php
                    
                        $plist_sql= $sql;

                        $plist_result = mysqli_query($conn,$plist_sql);
                        try{
                            dbException($plist_result);
                        }
                        catch(Exception $e){
                            printf("Database Error: %s\n", mysqli_error($conn));
                            die();
                        }

                        $id_arr=array();
                        while($plist_row = $plist_result->fetch_assoc()){
                            if($plist_row['id'] != $_SESSION['id']){
                                $repeated=false;
                                for($i=0;$i<sizeof($id_arr);$i++){
                                    if($id_arr[$i]==$plist_row['id']){
                                        $repeated=true;
                                        break;
                                    }
                                }

                                if($repeated==false){
                                    $id_arr[]=$plist_row['id'];
                                    ?>

                                    <a href="Chat.php?id=<?php echo $plist_row['id']?>">
                                        <ul class="people-list list-unstyled">                              
                                            <li>
                                                <img src="<?php echo $plist_row['imagePath'];?>" alt="profile picture" class="people-list-img img-circle">
                                                <?php
                                        $unread_sql = "SELECT COUNT('messageID') as unread_messages FROM message WHERE readStatus='0' AND SenderID=".$plist_row['id']." AND recepientID=".$_SESSION['id'];
                                        $unread_sql_result = mysqli_query($conn,$unread_sql);	
                                        try{
                                            dbException($unread_sql_result);
                                        }
                                        catch(Exception $e){
                                            printf("Database Error: %s\n", mysqli_error($conn));
                                            die();
                                        }
                                        $unread_messages = $unread_sql_result->fetch_assoc();
                                        if($unread_messages['unread_messages']==0){
                                            ?>
                                                <div class="people-list-about read">
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <div class="people-list-about unread">
                                            <?php
                                        }
                                        ?>         
                                                    <?php echo $plist_row['username'];?>
                                                    <br>
                                                    <i class="fa fa-user"></i> <?php echo $plist_row['userType']; ?>                                           
                                                </div>
                                            </li>
                                        </ul>
                                    </a>

                                    <?php
                                }    
                            }
                            //IF SESSIONED USER IS THE SENDER
                            else{

                                $plist_exc_sql = "SELECT * FROM  message, users WHERE messageID=".$plist_row['messageID']." AND users.id=".$plist_row['recepientID'];
                    
                                $plist_exc_result = mysqli_query($conn,$plist_exc_sql);
                                try{
                                    dbException($plist_exc_result);
                                }
                                catch(Exception $e){
                                    printf("Database Error: %s\n", mysqli_error($conn));
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

                                        <a href="Chat.php?id=<?php echo $plist_exc_row['id']?>">
                                        <ul class="list-unstyled people-list">                              
                                            <li>
                                                <img src="<?php echo $plist_exc_row['imagePath'];?>" alt="profile picture" class="people-list-img img-circle">
                                                <?php
                                        $unread_sql = "SELECT COUNT('messageID') as unread_messages FROM message WHERE readStatus='0' AND recepientID=".$_SESSION['id']." AND senderID=".$plist_exc_row['id'];
                                        $unread_sql_result = mysqli_query($conn,$unread_sql);
                                        try{
                                            dbException($unread_sql_result);
                                        }
                                        catch(Exception $e){
                                            printf("Database Error: %s\n", mysqli_error($conn));
                                            die();
                                        }	
                                        
                                        $unread_messages = $unread_sql_result->fetch_assoc();
                                        if($unread_messages['unread_messages']==0){
                                            ?>
                                                <div class="people-list-about read">
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <div class="people-list-about unread">
                                            <?php
                                        }
                                        ?>  
                                                        <?php echo $plist_exc_row['username'];?>
                                                        <br>
                                                        <i class="fa fa-user"></i> <?php echo $plist_exc_row['userType']; ?>                                            
                                                    </div>
                                                    <br>
                                                </li>
                                            </ul>
                                        </a>

                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                    </div>
            
                    <!------------------------------------------------ chat ------------------------------------------------>

                    <?php
                    if(!empty($_GET['id'])){
                        $seen_message_sql="UPDATE message SET readStatus=1 WHERE recepientID=".$_SESSION['id']." AND SenderID=".$_GET['id'];
                        $seen = mysqli_query($conn,$seen_message_sql);
                        try{
                            dbException($seen);
                        }
                        catch(Exception $e){
                            printf("Database Error: %s\n", mysqli_error($conn));
                            die();
                        }
                        
                        //to update inbox notification and read-unread style
                        if(mysqli_affected_rows($conn)>0){
                            echo "<meta http-equiv='refresh' content='0'>";
                        }
                        
                        ?>

                        
                        <div class="chat-container">


                            <?php
                            $header_sql = "SELECT * FROM users WHERE id=" . $_GET['id'];

                            $header_result = mysqli_query($conn,$header_sql);
                            try{
                                dbException($header_result);
                            }
                            catch(Exception $e){
                                printf("Database Error: %s\n", mysqli_error($conn));
                                die();
                            }

                            if($header_rows = $header_result->fetch_assoc()){
                            ?>
                                <!------------------------------------------ chat header ------------------------------------------->

                                <div class="chat-header">
                                    <img src="<?php echo $header_rows['imagePath'];?>" alt="profile picture" class="header-img img-circle">
                                    <div class="header-about">
                                        <h4> <?php echo $header_rows['username'];?> </h4>
                                        <div class="job"><i class="fa fa-user"></i> <?php echo $header_rows['userType'];?> </div>                                            
                                    </div>
                                </div>

                                <?php
                            }
                            

                            ?>

                            <!----------------------------------------------- messages ------------------------------------------------>

                            <div class="chat-history">
                                <ul>
                                    <?php
                                    $messages_sql= $sql . " AND ( (recepientID=". $_GET['id'] .") OR (senderID=". $_GET['id'].") )";

                                    $messages_result = mysqli_query($conn,$messages_sql);
                                    try{
                                        dbException($messages_result);
                                    }
                                    catch(Exception $e){
                                        printf("Database Error: %s\n", mysqli_error($conn));
                                        die();
                                    }

                                    while($messages_rows = $messages_result->fetch_assoc()){

                                        if($messages_rows['id'] == $_SESSION['id']){
                                        ?>

                                            <!---------------------------------------- sessioned user message ----------------------------------------->

                                            <li>
                                                
                                                <div class="message-data">
                                                    <img src="<?php echo $messages_rows['imagePath'];?>" alt="my profile picture">
                                                </div>

                                                <div class="message my-message">
                                                    <?php 
                                                    echo $messages_rows['messageText'];
                                                    if($messages_rows['readStatus'] == 1)
                                                        echo "<div class='readStatus-seen'><i class='glyphicon glyphicon-ok'></i><i class='glyphicon glyphicon-ok'></i></div>";
                                                    else
                                                        echo "<div class='readStatus-notSeen'><i class='glyphicon glyphicon-ok'></i><i class='glyphicon glyphicon-ok'></i></div>";
                                                    ?>
                                                </div>

                                            </li>

                                        <?php
                                        }
                                        else{
                                        ?>

                                            <!---------------------------------------- other user message ----------------------------------------->
                                            
                                            <li>
                                                <div class="message-data text-right">
                                                    <img src="<?php echo $messages_rows['imagePath'];?>" alt="profile picture">
                                                </div>

                                                <div class="message other-message">
                                                    <?php 
                                                    echo $messages_rows['messageText'];
                                                    ?>
                                                </div>

                                            </li>                   

                                        <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>

                            <!------------------------------------------ send a message ------------------------------------------->

                            <form action="" method="post">
                                <div class="input-group">
                                    <input type="text" name="txt" placeholder="Type Message ..." class="form-control">

                                    <span class="input-group-btn">
                                        <button type="submit" name="send" class="btn send">Send</button>
                                    </span>
                                </div>
                            </form>

                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>

        <!---------------------------------------------------------------------------------------------------->

        <?php
        if(isset($_POST['send'])) {
            if(!empty($_POST['txt'])){
                $text=$_POST['txt'];
                $text=filter_var($text, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                $sql2='INSERT INTO message(senderID,recepientID,auditorFlag,messageText,readStatus) VALUES("'. $_SESSION['id'] .'","'. $_GET['id'] .'","0","'. $text .'","0")' ;
               $result2 = mysqli_query($conn,$sql2);
                if(!$result2){
                    echo "couldn't insert into the DataBase<br>";
                    die();
                }
                
                echo "<script>window.location.href='Chat.php?id=". $_GET['id']."'</script>";
            }
        }

        $conn->close();

        ?>


    </body>
</html>