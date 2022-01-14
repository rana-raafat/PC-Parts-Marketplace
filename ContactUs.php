<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> Contact Us </title>
    </head>
    <body>

<?php
//
session_start();
include "Menu.php";
$con = new mysqli("localhost", "root", "", "project");

if(!$con){
    echo "connection error<br>";
    die();
}
$sql= "SELECT username,userType,id FROM users WHERE userType='hrpartner' OR userType='auditor' OR userType='administrator'";
$result = mysqli_query($con,$sql);
if ($result->num_rows == 0) {
    echo "No results found<br>";
}

echo "<table border='2'><tr> <th>Name</th> <th>Position</th><th>Message</th></tr>";
while($row = $result->fetch_assoc()){
    
            echo "<td> " . $row['username'] . " </td>";
            echo " <td> " . $row['userType'] . "</td>";
            echo "<td><a href=Chats.php?id ='". $row['id'] . "'>click here </a></td>";
           
            echo "</tr>";
}
?>
  <button onclick="location.href='SuggestProduct.php'">Suggest a Product</button>
<br><br>
<h4>any problems contact us through here</h2>

    </body>
</html>
