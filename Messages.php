<html>
<?php

session_start();
include "Menu.php";

$conn = new mysqli("localhost","root","", "project");
if(!$conn)
{
    echo "couldn't connect to the DataBase<br>";
    die();
}


$sql="SELECT * FROM message WHERE (senderID='".$_SESSION['id']."'AND recepientID='".$_GET['id']."') OR (senderID='".$_GET['id']."'AND recepientID='".$_SESSION['id']."')";
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
    $sql3="SELECT username FROM users WHERE id='" . $row['senderID'] . "'";
     $result3 = mysqli_query($conn,$sql3);
    if(!$result3)
    {
        echo "COULDN'T SEARCH FOR THE NAME FROM THE DB<br>";
        die();
    }
    
    while($rows = $result3->fetch_assoc())
    {
        echo $rows['username'];
        echo" : ";
        echo $row['messageText'];
        echo"<br>";
    }
 
}

if(isset($_POST['send'])) {

    $sql2="INSERT INTO message(senderID,recepientID,messageText,readStatus) VALUES('". $_SESSION['id'] ."','". $_GET['id'] ."','". $_POST['txt'] ."','1') " ;
    $result2 = mysqli_query($conn,$sql2);
    if(!$result2){
        echo "couldn't insert into the DataBase<br>";
        die();
    }
    $conn->close();
    header("Location:Messages.php?id=".$_GET['id']);
}

if(isset($_POST['exit']))
{
    header("Location:Chats.php");
}

?>

<form action="" method="post">

please enter a message<br>

<input type="textarea" name="txt">

<input type="submit" name="send" value="send"/>
<input type="submit" name="exit" value="exit"/>
</form>

</html>