<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Profile </title>
    </head>
    <body>
        <?php

        session_start();
        include "Menu.php";

        $conn = new mysqli("localhost","root","", "project");
        if(!$conn)
        {
            echo "couldn't connect to the DataBase<br>";
            die();
        }

        if(isset($_GET['id'])){
            if(isset($_POST['customerchat'])){
                $sql="SELECT * FROM message WHERE senderID='".$_GET['id']."'";
                $result = mysqli_query($conn,$sql);

                if(!$result)
                {
                    echo "couldn't read the messages from the DataBase<br>";
                    die();
                }

                $sql3="SELECT username FROM users WHERE id='" . $_GET['id'] . "'";
                $result3 = mysqli_query($conn,$sql3);
                if(!$result3){
                    echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                    die();
                }

                if($rows = $result3->fetch_assoc()){
                    echo "<h1>".$rows['username']."</h1>";
                }

                while($row = $result->fetch_assoc())
                {   
                    $sql3="SELECT username FROM users WHERE id='" . $row['recepientID'] . "'";
                    $result3 = mysqli_query($conn,$sql3);
                    if(!$result3)
                    {
                        echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
                        die();
                    }
                    
                    while($rows = $result3->fetch_assoc())
                    {
                        echo "To " . $rows['username'];
                        echo" : ";
                        echo $row['messageText'];
                        echo"<br>";
                    }
                
                }
            }
            else if(isset($_POST['adminchat'])){
                //supposed to get admin id and all the customers they contacted
                //so first select the people the admin contacted then select * those people's data from the users table where usertype=customer
                //after that diaplay those people in a table (similar to the normal chat table) that redirects them to chat history when they 
                //click on a name to show the entire conversation between the admin and that customer
                //$adminChatsql = "SELECT * FROM message, "
            }
            if(isset($_POST['exit']))
            {
                header("Location:Home.php");
            }
            
        }

        $conn->close();
        ?>

    </body>
</html>