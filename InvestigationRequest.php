<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Investigation Request </title>
    </head>
    <body>
        <?php
        session_start();
        include "Menu.php";

        //use $_GET to get the hr id then use sql to get the hr name
        //at the end add the request data into the table 
        //then send the request as a message to the hr 
        //increment the investigationsmade value of this hr in the hrpartner table


        
        //i had this in the messages page initially but figured there was no point writing it there, sorry about that
        //didn't mean to write anything in here since i am technically not supposed to work on this page. this code is supposed to be the last
        //thing in the page btw
        //REMINDER: STILL NEED TO TEST IT
        $conn = new mysqli("localhost","root","", "project");
        if(!$conn)
        {
            echo "couldn't connect to the DataBase<br>";
            die();
        }

        $investigationsql = "SELECT * FROM investigationrequest ORDER BY id DESC LIMIT 1";
        $invResult = $conn->query($investigationsql);
        if($invResult->num_rows == 0){
            echo "Error request not found<br>";
        }
        else if($invRow = $invResult->fetch_assoc()){
            $invesigationLink = 'Investigation requested <a href="ViewInvestigationRequest.php?id=' . $invRow['id'] . '"">click here </a> to view';
            //don't sanatize this cause it needs to stay as a link obviously
            $survey="INSERT INTO message(senderID,recepientID,messageText,readStatus) VALUES('". $invRow['auditorID'] ."','". $invRow['hrID'] ."','". $invesigationLink ."','0') " ;
            $surveyResult = mysqli_query($conn,$survey);
            if(!$surveyResult){
                echo "couldn't insert survey into the DataBase<br>";
                printf("Error: %s\n", mysqli_error($conn));
                die();
            }
            $conn->close();
            echo "<script>window.location.href='Messages.php?id=".$_GET['id']."</script>";
        }

        
        ?>
    </body>
</html>