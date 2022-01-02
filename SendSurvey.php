<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Send Survey </title>
    </head>
    <body>
        <?php
        session_start();
        include "Menu.php";
        
        if(isset($_SESSION['id'])){
            $conn = new mysqli("localhost","root","", "project");
            if(!$conn)
            {
                echo "couldn't connect to the DataBase<br>";
                die();
            }

            $error='';

            if(isset($_POST['exit'])){
                header("Location:Home.php");
            }

            if(isset($_POST['submit'])){
                if(!isset($_POST['customers'])){
                    $error=' Please select at least one or exit';
                }
                else{
                    $customersArray = $_POST['customers'];
                    $link = 'Kindly take <a href="survey.php">this survey</a>';
                    //don't sanatize this cause it needs to stay as a link obviously
                    for($i=0;$i<sizeof($customersArray);$i++){
                        $survey="INSERT INTO message(senderID,recepientID,messageText,readStatus) VALUES('". $_SESSION['id'] ."','". $customersArray[$i] ."','". $link ."','0') " ;
                        $surveyResult = mysqli_query($conn,$survey);
                        if(!$surveyResult){
                            echo "couldn't insert survey into the DataBase<br>";
                            printf("Error: %s\n", mysqli_error($conn));
                            die();
                        }
                    }
                    $conn->close();
                    header("Location:Home.php");
                }
            }

            echo "<form method='post' action='' onsubmit='return validate(this);'>";
            echo "Select customers the survey will be sent to:-<br>";
            //echo "<input type='checkbox' name='customers[]' value='' hidden checked>";
            $customerssql = "SELECT * FROM users WHERE userType='customer'";
            $customersResult = $conn->query($customerssql);
            if($customersResult->num_rows == 0){
                echo "Error: no customers found<br>";
            }
            else {
                while($customerRow = $customersResult->fetch_assoc()){
                    echo "<input type='checkbox' name='customers[]' value='". $customerRow['id'] ."'>". $customerRow['username'] ."<br>";
                }
            }
            echo "<input type='submit' name='submit'>" ;
            echo "<input type='submit' name='exit' value='exit'/>". $error;
            echo "</form>";
        }
        ?>
    </body>
</html>