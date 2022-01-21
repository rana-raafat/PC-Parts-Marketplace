<html>
    <head>
        <link rel="stylesheet" href="Style.css">
        <title> View Suggestions </title>
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
    echo "connection error<br>";
    die();
}
$sql= "SELECT * FROM productsuggestion";
$result = mysqli_query($con,$sql);
try{
    dbException($result);
}
catch(Exception $e){
    printf("Database Error: %s\n", mysqli_error($con));
    die();
}
if ($result->num_rows == 0) {
    echo "No results found<br>";
}
echo "<div class='container'>";
echo "<table class='content-table' border='0'><tr> <th>Name of Product</th> <th>Customer</th><th>Suggestion ID</th><th >Image</th><th>Product Link</th><th>Product Description</th></tr>";
while($row = $result->fetch_assoc()){
    $namesql="SELECT username FROM users WHERE id='" . $row['customerID'] ."'";
    $nameresult = mysqli_query($con,$namesql);
    try{
        dbException($nameresult);
    }
    catch(Exception $e){
        printf("Database Error: %s\n", mysqli_error($con));
        die();
    }
    $username='User not found';
    if (!$nameresult) {
        echo "user not found<br>";
    }
    else{
        $namerow=$nameresult->fetch_assoc();
        $username=$namerow['username'];
    }
            echo "<tr><td> " . $row['productname'] . " </td>";
            echo " <td> " . $username . "</td>";
            echo " <td> " . $row['id'] . "</td>";
            echo " <td><img src='" . $row['imagePath'] . "' width='100' height='100'></td>";
            echo " <td> " . $row['productLink'] . "</td>";
            echo " <td> " . $row['productDescription'] . "</td>";
            
            echo "</tr>";
}
?>
    </body>
</html>