<html>
    <head>
        <?php
        session_start();
        include "Menu.php";
       
        $conn = new mysqli("localhost","root","", "project");

        $sql="SELECT * FROM message, users WHERE ( (senderID='".$_SESSION['id']."') OR ( recepientID='".$_SESSION['id']."') ) AND SenderID=users.id";
        ?>
    </head>

    <body>

        <div class="container">
            <div class="card chat-app">

                <!------------------------------------------------- list ------------------------------------------------->

                <script>
                function Search(){
                    //console.log('change');
                    <?php
                    if(!empty($_POST['search']))
                        $search_value = $_POST['search'];
                    else
                            $search_value = "";
                    ?>
                    //document.forms["searchForUsername"].submit();
                }
                </script>

                <div class="people-list chat-column">

      			    <form action="" method="post" name="searchForUsername">
                        <div class="input-group">
                            <input type="search" name="search" placeholder="Search" value="<?php echo $search_value; ?>" oninput='Search()'>
                            <span class="input-group-btn">
                                <button class="btn btn-basic search" type="submit" name="submitSearch">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>

	                <?php
		            if($search_value!=""){
                        $plist_sql= $sql . " AND username LIKE '%".$search_value;
                    }
	                else{
                        $plist_sql= $sql;
		            }
                    //pepols list 
                    $plist_result = mysqli_query($conn,$plist_sql);
                    if(!$plist_result){
                        echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
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
                                    <ul class="list-unstyled chat-list">
                                        <li class="clearfix">
                                            <img src="<?php echo $plist_row['imagePath'];?>" alt="profile picture" width='50' height='50' class="img-circle">
                                            <div class="about">
                                                <div class="name"> <?php echo $plist_row['username'];?> </div>
                                                <div class="job"><i class="fa fa-user"></i> <?php echo $plist_row['userType']; ?> </div>                                            
                                            </div>
                                        </li>
                                    </ul>
                                </a>

                                <?php
                            }    
                        }
                        else{

                            $plist_exc_sql = "SELECT * FROM  message, users WHERE messageID=".$plist_row['messageID']." AND users.id=".$plist_row['recepientID'];
		                    if($search_value!=""){
                                $plist_exc_sql= $plist_exc_sql . " AND username LIKE '%".$search_value;
                            }
                
                            $plist_exc_result = mysqli_query($conn,$plist_exc_sql);
                            if(!$plist_exc_result){
                                echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
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
	                ?>
	                </div>
            
                    <!------------------------------------------------ chat ------------------------------------------------>

                    <?php
                    if(!empty($_GET['id'])){
                    ?>
                        <div class="chat chat-column">
                            <?php
                            $header_sql = "SELECT * FROM users WHERE id=" . $_GET['id'];

                            $header_result = mysqli_query($conn,$header_sql);
                            if(!$header_result){
                                echo "couldn't read the messages from the DataBase<br>";
                                die();
                            }

                            if($header_rows = $header_result->fetch_assoc()){
                            ?>
                                <!------------------------------------------ chat header ------------------------------------------->

                                <div class="chat-header clearfix">
                                    <img src="<?php echo $header_rows['imagePath'];?>" alt="profile picture"  width='75' height='75' class="img-circle">
                                    <div class="chat-about">
                                        <h4> <?php echo $header_rows['username'];?> </h4>
                                        <div class="job"><i class="fa fa-user"></i> <?php echo $header_rows['userType'];?> </div>                                            
                                    </div>
                                </div>

                                <?php
                            }
                            

                            ?>

                            <!----------------------------------------------- messages ------------------------------------------------>

                            <div class="chat-history">
                                <ul class="m-b-0">
                                    <?php
                                    $messages_sql= $sql . " AND ( (recepientID=". $_GET['id'] .") OR (senderID=". $_GET['id'].") )";

                                    $messages_result = mysqli_query($conn,$messages_sql);
                                    if(!$messages_result){
                                        echo "couldn't read the messages from the DataBase<br>";
                                        die();
                                    }

                                    while($messages_rows = $messages_result->fetch_assoc()){

                                        if($messages_rows['id'] == $_SESSION['id']){
                                        ?>

                                            <!---------------------------------------- sessioned user message ----------------------------------------->

                                            <li class="clearfix">
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
                                            
                                            <li class="clearfix">
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

                            <div class="box-footer">
                                <form action="" method="post">
                                    <div class="input-group">
              					        <input type="text" name="txt" placeholder="Type Message ..." class="form-control txtToBeSent">

                          				<span class="input-group-btn">
                        				    <button type="submit" name="send" class="btn send">Send</button>
              			            	</span>
        				            </div>
      				            </form>
    			            </div>

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
            $sql2="INSERT INTO message(senderID,recepientID,messageText,readStatus) VALUES('". $_SESSION['id'] ."','". $_GET['id'] ."','". $_POST['txt'] ."','0') " ;
            $result2 = mysqli_query($conn,$sql2);
            if(!$result2){
                echo "couldn't insert into the DataBase<br>";
                die();
            }
            $conn->close();
            echo "<script>window.location.href='Chat.php?id=". $_GET['id']."'</script>";
        }
        ?>

    </body>
</html>