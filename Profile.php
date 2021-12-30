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
        if(isset($_Get['id'])){
            $sql="SELECT * FROM users WHERE id='". $_Get['id'] ."'";
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
                            }
                            else if($row['userType']=='customer'){
                                //if they open a customer's profile they have a button that can make this customer an admin
                            }
                        }
                        else if($_SESSION['userType']=='hrpartner'){
                            if($row['userType']=='administrator'){
                            //they have the option to add a penalty to an admin when they open an admin's profile
                            //which sends the hr to the penalty page NEVERMIND
                            }
                        }
                        else if($_SESSION['userType']=='auditor'){
                            if($row['userType']=='administrator'){
                            //if the auditor opens an admin's profile they have an option to request an investigation
                            //which sends the auditor to the investigation request page
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