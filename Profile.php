<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Profile </title>
    </head>
    <body>
        <?php
        session_start();
        include "Menu.php";

        $con = new mysqli("localhost", "root", "", "project");
        if(!$con){ //exception
            echo "connection error<br>";
            die();
        }
        if(isset($_GET['id'])){
            $sql="SELECT * FROM users WHERE id='". $_GET['id'] ."'";
            $result=$con->query($sql);
            if($result->num_rows == 0){
                echo "Error: profile not found<br>";
            }
            else{
                if($row = $result->fetch_assoc()){
                    echo "<img src='". $row['imagePath']. "' alt='profilepic' width='150' height='150'><br>";
                    echo "Username: " . $row['username'] . "<br>";
                    if(isset($_SESSION['id'])){
                        if($_SESSION['userType']=='administrator'){
                            if($row['userType']=='administrator'){
                                //if they open an admin's profile they have a button that can delete this admin
                                echo "<a href='RemoveAdmin.php?id=". $row['id'] ."'><button type='submit' name='removeadmin'> Remove admin </button></a>";
                            }
                            else if($row['userType']=='customer'){
                                //if they open a customer's profile they have a button that can make this customer an admin
                                echo "<a href='AddAdmin.php?id=". $row['id'] ."'><button type='submit' name='addadmin'> Add admin </button></a>";

                                //can see messages the customer SENT NOT MADE YETTTT
                                ?>
                                <form method='post' action=<?php echo 'ChatHistory.php?id=' . $row['id']; ?>>
                                <button type='submit' name='customerchat'> Chat History </button>
                                </form>
                                <?php
                            }
                        }
                        else if($_SESSION['userType']=='auditor'){
                            if($row['userType']=='administrator'){
                                //can see messages between admin and customers
                                ?>
                                <form method='post' action=<?php echo 'ChatHistory.php?id=' . $row['id']; ?>>
                                <button type='submit' name='adminchat'> Chat History </button>
                                </form>
                                <?php
                                //redirects to show message history
                                //NOTE: on second thought this button should redirect to chats where
                                //a list of all the customers the admin contacted is there then when the auditor
                                //clicks on one of those people it sends the aditor to the chathistory page which then displays the
                                //conversation between them (then the auditor can add a comment to that conversation i don't understand how)
                            }
                            else if($row['userType']=='customer'){
                                //if they open a customer's profile they have a 'send survey' button
                                //sends survey link as a message
                                
                                ?>
                                <form method='post' action=<?php echo 'Messages.php?id=' . $row['id']; ?>>
                                <button type='submit' name='sendsurvey'> Send Survey </button>
                                </form>
                                <?php
                            }
                            else if($row['userType']=='hrpartner'){
                                //if they open an hr's profile they have a 'request investigation' button
                                //the link is sent to the hr as a message
                                
                                ?>
                                <form method='post' action=<?php echo 'InvestigationRequest.php?id=' . $row['id']; ?>>
                                <button type='submit' name='investigation'> Request Ivenstigation </button>
                                </form>
                                <?php
                            }
                        }
                        else if($_SESSION['userType']=='customer'){
                            if($row['userType']!='customer'){
                                //if they open a profile that isn't a customer have a 'Message' button
                                echo "<a href='Messages.php?id=". $row['id'] ."'><button type='submit' name='message'> Message </button></a>";
                            }
                        }
                    }
                }
            }
        }
        else if(isset($_SESSION['id'])){
            echo "<img src='". $_SESSION['imagePath']. "' alt='profilepic' width='150' height='150'><br><br>";
            echo "Username: " . $_SESSION['username'] . "<br><br>";
            echo "Email: " . $_SESSION['email'] . "<br><br>";
            echo "Password: " . $_SESSION['password'] . "<br><br>";
            echo "Address: " . $_SESSION['address'] . "<br><br>";

            if($_SESSION['userType']!='customer'){
                echo "Position: " . ucfirst($_SESSION['userType']) . "<br><br>";

                if($_SESSION['userType']=='administrator'){
                    $penaltysql="SELECT penalties FROM administrator WHERE id='". $_SESSION['id'] ."'";
                    $penaltyResult=$con->query($penaltysql);
                    echo "Number of penalties: ";
                    if($penaltyResult->num_rows == 0){
                        echo "Error: penalty row not found<br>";
                    }
                    if($penaltyrow = $penaltyResult->fetch_assoc()){
                        echo $penaltyrow['penalties'] . "<br><br>";
                    }
                    $reasonsql="SELECT * FROM penalty WHERE adminID='". $_SESSION['id'] ."'";
                    $reasonResult=$con->query($reasonsql);
                    echo "Reasons for penalties:<br>";
                    if($reasonResult->num_rows == 0){
                        echo "None<br>";
                    }
                    $counter=1;
                    while($reasonrow = $reasonResult->fetch_assoc()){
                        echo $counter . ") " . $reasonrow['reason'] . "<br>";
                        $counter++;
                    }
                }
                else if($_SESSION['userType']=='hrpartner'){
                    $hrsql="SELECT * FROM hrpartner WHERE id='". $_SESSION['id'] ."'";
                    $hrResult=$con->query($hrsql);
                    
                    if($hrResult->num_rows == 0){
                        echo "Error: hr row not found<br>";
                    }
                    if($hrRow = $hrResult->fetch_assoc()){
                        echo "Number of penalties given: " . $hrRow['penaltiesGiven'] . "<br>";
                        echo "Number of investigations made: " . $hrRow['investigationsMade'] . "<br>";
                    }
                }
            }
            ?>
            <a href='EditProfile.php'><button type='submit' name='edit' value='edit'>Edit profile</button></a>
            <a href='delete.php'><button type='submit' name='edit' value='edit'> Delete profile </button></a>
            <?php
        } 
        else{
            echo "Error please try again<br>";
        }
        $con->close();
        ?>
    </body>
</html>