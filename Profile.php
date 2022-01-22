<html>
    <head>
        <title> Profile </title>
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

        $con = new mysqli("localhost", "root", "", "project");
        if(!$con){ 
            echo "connection error"; 
            echo "<br>";
            die();
        }
        if(isset($_GET['id'])){
            $sql="SELECT * FROM users WHERE id='". $_GET['id'] ."'";
            $result=$con->query($sql);
            try{
                dbException($result);
            }
            catch(Exception $e){
                printf("Database Error: %s\n", mysqli_error($con));
                die();
            }
            if($result->num_rows == 0){
                echo "Error: profile not found";
                echo "<br>";
            }
            else{
                if($row = $result->fetch_assoc()){
                    echo "<div class='container'>";
                    echo "<div class='card'>";
                    echo "<div class='profile'>";          
                    echo "<h1>" . $row['username'] . "</h1>";
                    echo "<br>";
                    echo "<img src='". $row['imagePath']. "' alt='profilepic' class='profile-image'><br><br>";
                    echo "<i class='fa fa-user'></i> ";
                    echo $row['userType'];
                    echo "<br><br>";
                    if(isset($_SESSION['id'])){
                        if($_SESSION['userType']=='administrator'){
                            if($row['userType']=='administrator'){
                                //if they open an admin's profile they have a button that can delete this admin
                                echo "<a href='RemoveAdmin.php?id=". $row['id'] ."'><input type='submit' name='removeadmin' value='Remove admin'></a>";
                            }
                            else if($row['userType']=='customer'){
                                //if they open a customer's profile they have a button that can make this customer an admin
                                echo "<a href='AddAdmin.php?id=". $row['id'] ."'><input type='submit' name='addadmin' value='Add admin'></a>";

                             
                                ?>
                                <br>
                                <a href='DisplayCustomersList.php'><button name='customerchat' value='Chat History'><i class='fa fa-commenting'></i> Chat History</button></a>
                                <?php
                            }
                        }
                        else if($_SESSION['userType']=='auditor'){
                            if($row['userType']=='administrator'){
                                //can see messages between admin and customers
                                ?>
                                <form method='post' action=<?php echo 'AdminChats.php'; ?>>
                                <input type='submit' name='adminchat' value='Chat History'>
                                </form>
                                <?php
                                
                            }
                            else if($row['userType']=='customer'){
                                //if they open a customer's profile they have a 'send survey' button
                                //sends survey link as a message
                                if(isset($_POST['sendsurvey'])){
                                    $link = 'Kindly take <a href="survey.php">this survey</a>';
                                 
                                    $survey="INSERT INTO message(senderID,recepientID,messageText,readStatus) VALUES('". $_SESSION['id'] ."','". $row['id'] ."','". $link ."','0') " ;
                                    $surveyResult = mysqli_query($con,$survey);
                                    if(!$surveyResult){
                                        echo "couldn't insert survey into the DataBase";
                                        echo "<br>";
                                        printf("Error: %s\n", mysqli_error($con));
                                        die();
                                    }
                                }
                                ?>
                                <form method='post' action=''>
                                <input type='submit' name='sendsurvey' value='Send Survey'>
                                </form>
                                <?php
                            }
                            else if($row['userType']=='hrpartner'){
                                //if they open an hr's profile they have a 'request investigation' button
                                //the link is sent to the hr as a message
                                
                                ?>
                                <form method='post' action=<?php echo 'InvestigationRequest.php?id=' . $row['id']; ?>>
                                <input type='submit' name='investigation' value='Request Investigation'>
                                </form>
                                <?php
                            }
                        }
                        else if($_SESSION['userType']=='customer'){
                            if($row['userType']!='customer'){
                                //if they open a profile that isn't a customer have a 'Message' button
                                echo "<a href='Chat.php?id=". $row['id'] ."'><input type='submit' name='message' value='Message Button'></a>";
                            }
                        }
                        else if($_SESSION['userType']=='hrpartner'){
                            if($row['userType']=='administrator'){
                                
                                echo "<a href='penalty.php'><input type='submit' name='penalty' value='Add a Penalty'></a>";
                            }
                        }
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            }
        }//IF IT'S SESSIONED USER OWN PROFILE
        else if(isset($_SESSION['id'])){
            echo "<div class='container'>";
            echo "<div class='card'>";
            echo "<div class='profile'>";
            echo "<h1>" . $_SESSION['username'] . "</h1>";
            echo "<br>";
            echo "<img src='". $_SESSION['imagePath']. "' alt='profilepic' class='profile-image'>";
            echo "<br><br>";
            echo "<text class='header'> Email: </text>" . $_SESSION['email'];
            echo "<br><br>";
            echo "<text class='header'> Address: </text>" . $_SESSION['address'];
            echo "<br><br>";


            if($_SESSION['userType']!='customer'){
                echo "<text class='header'> Position: </text>" . ucfirst($_SESSION['userType']);
                echo "<br><br>";

                if($_SESSION['userType']=='administrator'){
                    $penaltysql="SELECT penalties FROM administrator WHERE id='". $_SESSION['id'] ."'";
                    $penaltyResult=$con->query($penaltysql);
                    try{
                        dbException($penaltyResult);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($con));
                        die();
                    }
                    echo "<text class='header'> Number of penalties: </text>";
                    echo "<br>";
                    if($penaltyResult->num_rows == 0){
                        echo "Error: penalty row not found";
                        echo "<br>";
                    }
                    if($penaltyrow = $penaltyResult->fetch_assoc()){
                        echo $penaltyrow['penalties'];
                        echo "<br><br>";
                    }
                    $reasonsql="SELECT * FROM penalty WHERE adminID='". $_SESSION['id'] ."'";
                    $reasonResult=$con->query($reasonsql);
                    try{
                        dbException($reasonResult);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($con));
                        die();
                    }
                    echo "<text class='header'> Reasons for penalties: </text>";
                    echo "<br>";
                    if($reasonResult->num_rows == 0){
                        echo "None.";
                        echo "<br>";
                    }
                    $counter=1;
                    while($reasonrow = $reasonResult->fetch_assoc()){
                        echo $counter . ") " . $reasonrow['reason'];
                        echo "<br>";
                        $counter++;
                    }
                }
                else if($_SESSION['userType']=='hrpartner'){
                    $hrsql="SELECT * FROM hrpartner WHERE id='". $_SESSION['id'] ."'";
                    $hrResult=$con->query($hrsql);
                    try{
                        dbException($hrResult);
                    }
                    catch(Exception $e){
                        printf("Database Error: %s\n", mysqli_error($con));
                        die();
                    }
                    if($hrResult->num_rows == 0){
                        echo "Error: hr row not found";
                        echo "<br>";
                    }
                    if($hrRow = $hrResult->fetch_assoc()){
                        echo "<text class='header'> Number of penalties given: </text>";
                        echo "<br>";
                        echo $hrRow['penaltiesGiven'];
                        echo "<br><br>";
                        echo "<text class='header'> Number of investigations made: </text>";
                        echo "<br>";
                        echo $hrRow['investigationsMade'];
                        echo "<br>";
                    }
                }
            }
            ?>
            <br>
            <a href='EditProfile.php'><button type='submit' name='edit'>Edit Profile <span class="glyphicon glyphicon glyphicon-pencil"></span></button></a>
            <a data-toggle="modal" data-target="#deleteAccountModal"><button type='submit' name='delete'>Delete Account <i class="glyphicon glyphicon-trash"></i></button></a>
          
            <?php
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } 
        else{
            echo "Error please try again";
            echo "<br>";
        }
        $con->close();
        ?>
    </body>
</html>