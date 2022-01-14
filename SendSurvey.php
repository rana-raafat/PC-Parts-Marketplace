<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Send Survey </title>
    </head>
    <body>
        <?php
        session_start();
        include "Menu.php";
        ?>
        <div class="container">
            <div class="card">
                <div class="sendSurvey">
                <?php
                    if(isset($_SESSION['id'])){
                        $conn = new mysqli("localhost","root","", "project");
                        if(!$conn)
                        {
                            echo "couldn't connect to the DataBase<br>";
                            die();
                        }

                        $error='';

                        if(isset($_POST['exit'])){
                            echo "<script>window.location.href='Home.php'</script>";
                        }

                        if(isset($_POST['submit'])){
                            if(!isset($_POST['customers'])){
                                $error="Please <strong>select at least one customer</strong> or exit";
                            }
                            else{
                                $customersArray = $_POST['customers'];
                                $link = 'Kindly take <a href="survey.php">this survey</a>';
                                //don't sanatize this cause it needs to stay as a link obviously
                                for($i=0;$i<sizeof($customersArray);$i++){
                                    $survey="INSERT INTO message(senderID,recepientID,auditorFlag,messageText,readStatus) VALUES('". $_SESSION['id'] ."','". $customersArray[$i] ."','0','". $link ."','0') " ;
                                    $surveyResult = mysqli_query($conn,$survey);
                                    if(!$surveyResult){
                                        echo "couldn't insert survey into the DataBase<br>";
                                        printf("Error: %s\n", mysqli_error($conn));
                                        die();
                                    }
                                }
                                $conn->close();
                                echo "<script>window.location.href='Home.php'</script>";
                            }
                        }

                        echo "<form method='post' action='' onsubmit='return validate(this);'>";
                        echo "<text class='header'>Select customers the survey will be sent to</text>";
                        echo "<hr>";
                        if(!empty($error)){
                            ?>
                            <div class='alert alert-danger justify-content-center'>               
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <?php echo $error ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button> 
                            </div>
                            <?php
                        }
                        //echo "<input type='checkbox' name='customers[]' value='' hidden checked>";
                        $customerssql = "SELECT * FROM users WHERE userType='customer'";
                        $customersResult = $conn->query($customerssql);
                        if($customersResult->num_rows == 0){
                            echo "Error: no customers found<br>";
                        }
                        else {
                            while($customerRow = $customersResult->fetch_assoc()){
                                echo "<input type='checkbox' name='customers[]' value='". $customerRow['id'] ."'>". $customerRow['username'] ."<img src=". $customerRow['imagePath']. " class='user-pic-icon'><img>"; 
                                echo "<br>";
                            }
                        }
                        echo "<br>";
                        echo "<input type='submit' name='submit'>" ;
                        echo "<input type='submit' name='exit' value='exit'/>";
                        echo "</form>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>